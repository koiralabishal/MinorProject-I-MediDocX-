<?php
session_start();
include 'connection.php';

// if (!isset($_SESSION['doctorEmail'])) {
//   header('Location:index.php');
// }

// if (!isset($_SESSION['patientID'], $_SESSION['age'], $_SESSION['gender'])) {
//   header('Location:index.php');
// }

if (isset($_SESSION['doctorEmail'])) {

    $patientName = $_GET['patientName'];
    $patientID = $_GET['patientID'];
    $patientage = $_GET['age'];
    $patientgender = $_GET['gender'];
    $visitID = $_GET['visitID'];

    $doctorEmail = $_SESSION['doctorEmail'];


    $_SESSION['patientName'] = $patientName;
    $_SESSION['patientID'] = $patientID;
    $_SESSION['age'] = $patientage;
    $_SESSION['gender'] = $patientgender;
    $_SESSION['visitID'] = $visitID;

    $sql = "SELECT * FROM hospital WHERE email = '{$doctorEmail}' AND userType ='Doctor'";
    // $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

    $result = mysqli_query($conn, $sql);
    // $result2 = mysqli_query($conn, $sql2);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        // echo $row['doctorID'];
    }


    $sqlVisits = "SELECT * FROM patientVisitDetails WHERE patientID = $patientID AND referredToDoctorID = {$row['doctorID']} ORDER BY date DESC";
    $resultVisits = mysqli_query($conn, $sqlVisits);

    $hasVisitByYear = false;
    if ($resultVisits && mysqli_num_rows($resultVisits) > 0) {

        $visitsByYear = array();
        while ($rowVisits = mysqli_fetch_assoc($resultVisits)) {
            $year = date('Y', strtotime($rowVisits['date']));
            $month = date('m', strtotime($rowVisits['date']));
            $halfYear = ($month >= 1 && $month <= 6) ? 'Jan-Jun' : 'Jul-Dec';
            $visitsByYear[$year][$halfYear][] = $rowVisits;
            $hasVisitByYear = true;
        }

        function createVisitElements($visits)
        {
            foreach ($visits as $visit) {
                echo '<div class="box">';
                echo '<a href="doctorPatientVisit.php?date=' . $visit['date'] .'&visitID='. $visit['visitID']. '">';
                echo 'Date: ' . date('Y-m-d', strtotime($visit['date'])) . '<br>';
                echo '</a>';
                echo '</div>';
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
        }
    }




    // if ($result2) {
//   $row2 = mysqli_fetch_assoc($result2);
// }
} else if (!isset($_SESSION['patientID'], $_SESSION['age'], $_SESSION['gender'])) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>doctorPatient</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <header>
        <img src="MediDocX Logo.JPG" alt="" />
        <input type="text" placeholder="Search Patient...">
    </header>

    <aside>
        <div id="profileInfo">
            <div id="profilePic"></div>
            <div id="details">
                <b>
                    <?php echo $row['name']; ?>
                </b><br />
                <?php echo $row['userType']; ?> <br />
                ID:
                <?php echo $row['doctorID']; ?> <br />
                <?php echo $row['doctorQualification']; ?> <br />
                (
                <?php echo $row['universityCollageCountry']; ?>)
            </div>
        </div>
        <div id="reportTemplatesContainer">
            <h3>Patient Info</h3>
            <div class="reportTemplatesAside">Name:
                <?php echo $patientName; ?>
            </div>
            <div class="reportTemplatesAside">Patient ID:
                <?php echo $patientID; ?>
            </div>
            <div class="reportTemplatesAside">Age:
                <?php echo $patientage; ?>
            </div>
            <div class="reportTemplatesAside">Gender:
                <?php echo $patientgender; ?>
            </div>
        </div>
    </aside>

    <main>
        <section>
            <div class="sectionTitle">
                <h2>Recent Visits</h2>
            </div>
            <?php if($hasVisitByYear): ?> 
            <?php foreach ($visitsByYear as $year => $halfYears): ?>
                <?php foreach ($halfYears as $halfYear => $visits): ?>
                    <div class="container">
                        <div class="date"><?php echo $halfYear . ' ' . $year; ?></div>
                        <div class="boxContainer">
                            <?php createVisitElements($visits); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <?php endif; ?>

        </section>
    </main>

    <script>


        function visit() {
            window.location.href = "doctorPatientVisit.php";
        }

    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>