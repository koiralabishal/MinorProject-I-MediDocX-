<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['technicianEmail'])) {
    header('Location:index.php');
}

if (isset($_SESSION['technicianEmail']) && !is_null($_SESSION['technicianEmail'])) {
    $labTechnicianEmail = $_SESSION['technicianEmail'];

    // echo $labTechnicianEmail;

    $sql = "SELECT * FROM hospital WHERE email = '{$labTechnicianEmail}' AND userType ='Lab Technician'";

    $sql4 = "SELECT patientID from hospital WHERE userType = 'Patient'";
    $result4 = mysqli_query($conn, $sql4);

    if ($result4) {
        $row5 = mysqli_fetch_assoc($result4);
        $patientID = $row5['patientID'];
    }

    $sql2 = "SELECT distinct patientName FROM  test_data WHERE patientID = '$patientID'";
    $result2 = mysqli_query($conn, $sql2);
    // $sql2 = "SELECT Distinct h.name FROM hospital h JOIN test_data t ON h.doctorID = t.doctorID";
    $sql3 = "SELECT distinct t.patientName, t.patientID, h.name, t.doctorID, t.reportID
          FROM test_data t
          INNER JOIN hospital h ON t.doctorID = h.doctorID
          ORDER BY t.id DESC";

    // $sql3 = "SELECT a.* FROM all_patient a JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC";

    $result = mysqli_query($conn, $sql);

    $result3 = mysqli_query($conn, $sql3);
    // $result3 = mysqli_query($conn, $sql3);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    }
}

$sqlPendingTests = "SELECT distinct  r.patientID, h.name, r.doctorID, r.ReportID FROM report r JOIN hospital h ON r.doctorID = h.doctorID WHERE r.flag = 'P' ";
$resultPendingTests = mysqli_query($conn, $sqlPendingTests);

// if ($result2) {
//   $row2 = mysqli_fetch_assoc($result2);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>labTechnician</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <header>
        <img src="MediDocX Logo.JPG" alt="" />
        <a href="logout.php"><button>Log out</button></a>
        <input type="text" placeholder="Search Patient..." />
    </header>

    <aside>
        <div id="profileInfo">
            <div id="profilePic"></div>
            <div id="details">
                <?php echo $row['name']; ?>
                </b><br>
                <?php echo $row['userType']; ?> <br>
                ID:
                <?php echo $row['labTechnicianID']; ?> <br>
                <!-- B. Radiology -->
            </div>
        </div>
    </aside>

    <main>
        <section>
            <div class="sectionTitle">
                <h2>New Tests</h2>
            </div>
            <!-- <div class="container"> -->
                <div class="boxContainer">
                    <?php
                    if ($result3) {
                        while ($row3 = mysqli_fetch_array($result3)) {
                            echo '<div class="box">';
                            echo '<a href="labTechnicianPatient.php?patientName=' . $row3['patientName'] . '&patientID=' . $row3['patientID'] . '&doctorID=' . $row3['doctorID'] . '&reportID=' . $row3['reportID'] . ' ">';
                            echo "Name: " . $row3['patientName'] . "<br />";
                            echo "Patient ID: " . $row3['patientID'] . "<br />";
                            echo "Referred by: Dr." . $row3['name'];
                            echo '</a>';
                            echo '</div>';
                        }
                    }
                    echo "<style>
               a{
                text-decoration:none;
                color:white;
               }

               .box:hover a {
                color: black;
               }

             </style>";
                    ?>
                </div>
            <!-- </div> -->
        </section>

        <section>
            <div class="sectionTitle">
                <h2>Pending Tests</h2>
            </div>
            <!-- <div class="container"> -->
                <div class="boxContainer">
                    <?php
                    if ($resultPendingTests) {
                        while ($rowPendingTests = mysqli_fetch_array($resultPendingTests)) {
                            echo '<div class="box">';
                            echo '<a href="pendingTests.php?patientID=' . $rowPendingTests['patientID'] . '&doctorID=' . $rowPendingTests['doctorID'] . '&reportID=' . $rowPendingTests['ReportID'] . ' ">';
                            // echo "Name: " . $rowPendingTests['patientName'] . "<br />";
                            echo "Patient ID: " . $rowPendingTests['patientID'] . "<br />";
                            echo "Referred by: Dr." . $rowPendingTests['name'];
                            echo '</a>';
                            echo '</div>';
                        }
                    }
                    echo "<style>
               a{
                text-decoration:none;
                color:white;
               }

               .box:hover a {
                color: black;
               }

             </style>";
                    ?>
                </div>
            <!-- </div> -->
        </section>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>