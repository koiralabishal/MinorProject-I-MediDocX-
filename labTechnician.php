<?php
// session_name('lab_technician_session');
session_start();
include 'connection.php';


if (!isset($_SESSION['technicianEmail'])) {
    header('Location:index.php');
}

function logout()
{
    // Clear session data
    unset($_SESSION['technicianEmail']);
    // Redirect to the login page
    header('Location: index.php');
    exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
    logout();
}


if (isset($_SESSION['technicianEmail']) && !is_null($_SESSION['technicianEmail'])) {
    $labTechnicianEmail = $_SESSION['technicianEmail'];
    // $patientName = $_SESSION['patientName'];
    // $gender = $_SESSION['gender'];
    // $age = $_SESSION['age'];
    // $patientID = $_SESSION['patientID'];

    // echo $labTechnicianEmail;

    $sql = "SELECT * FROM hospital WHERE email = '{$labTechnicianEmail}' AND userType ='Lab Technician'";

    // $sql4 = "SELECT patientID from hospital WHERE userType = 'Patient'";
    // $result4 = mysqli_query($conn, $sql4);

    // if ($result4) {
    //     $row5 = mysqli_fetch_assoc($result4);
    //     $patientID = $row5['patientID'];
    // }

    // $sql2 = "SELECT distinct patientName FROM  test_data WHERE patientID = '$patientID'";
    // $result2 = mysqli_query($conn, $sql2);
    // $sql2 = "SELECT Distinct h.name FROM hospital h JOIN test_data t ON h.doctorID = t.doctorID";
    $sql3 = "SELECT distinct t.patientName, t.patientID, h.name, t.doctorID, t.reportID,t.visitID
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

$sqlPendingTests = "SELECT distinct  r.patientID, h.name, r.doctorID, r.ReportID, r.visitID, n.patientName FROM report r JOIN hospital h ON r.doctorID = h.doctorID JOIN patientvisitdetails n ON r.patientID = n.patientID  WHERE r.flag = 'P'  ORDER BY r.id DESC ";
$resultPendingTests = mysqli_query($conn, $sqlPendingTests);

// $patientName = "SELECT name FROM hospital WHERE patientID = '{$patientID}'";
// $resultPatientName = mysqli_query($conn, $patientName);

// if ($resultPatientName) {
//     $rowPatientName = mysqli_fetch_assoc($resultPatientName);
// }
// $sqlPatientInfo = "SELECT * FROM patientVisitDetails WHERE patientID = '$patientID' AND referredToDoctorID = '$doctorID' AND visitID = '$visitID'";
// $resultPatientInfo = mysqli_query($conn,$sqlPatientInfo);
// if($resultPatientInfo){
//     $rowPatientInfo = mysqli_fetch_assoc($resultPatientInfo);
// }

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
        <!-- <a href="logout.php"><button>Log out</button></a> -->
        <form method="post" id="logoutForm">
            <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
            <button type="submit" id="logoutButton">Log out</button>
        </form>
        <input type="text" id="searchInput" placeholder="Search Patient..." />




    </header>

    <aside>
        <div id="profileInfo">
            <div id="profilePic"></div>
            <div id="details">
                <b>
                    <?php echo $row['name']; ?>
                </b><br>
                <?php echo $row['userType']; ?> <br>
                ID:
                <?php echo $row['labTechnicianID']; ?> <br>
                <?php echo $row['doctorQualification']; ?> <br>
                <?php echo $row['universityCollageCountry']; ?> <br>

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
                        // echo '<div class="box" id = "patient" data-patient-name="' . htmlspecialchars($row3['patientName']) . '" data-patient-id="' . htmlspecialchars($row3['patientID']) . '" data-doctor-id="' . htmlspecialchars($row3['doctorID']) . '" data-report-id="' . htmlspecialchars($row3['reportID']) . '" data-visit-id="' . htmlspecialchars($row3['visitID']) . '">';
                        echo '<div class="box">';
                        echo '<a href="labTechnicianPatient.php?patientName=' . $row3['patientName'] . '&patientID=' . $row3['patientID'] . '&doctorID=' . $row3['doctorID'] . '&reportID=' . $row3['reportID'] . '&visitID=' . $row3['visitID'] . ' ">';
                        echo 'Name: <span class="patientName">' . $row3['patientName'] . '</span><br />';
                        echo 'Patient ID: <span class="patientID"> ' . $row3['patientID'] . '</span><br />';
                        echo "Referred by: " . $row3['name'];
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
                        // echo '<div class="box" id = "pendingTest" data-patient-id="' . htmlspecialchars($rowPendingTests['patientID']) . '" data-doctor-id="' . htmlspecialchars($rowPendingTests['doctorID']) . '" data-report-id="' . htmlspecialchars($rowPendingTests['ReportID']) . '" data-visit-id="' . htmlspecialchars($rowPendingTests['visitID']) . '">';
                        echo '<div class="box">';
                        echo '<a href="pendingTests.php?patientID=' . $rowPendingTests['patientID'] . '&doctorID=' . $rowPendingTests['doctorID'] . '&reportID=' . $rowPendingTests['ReportID'] . '&visitID=' . $rowPendingTests['visitID'] . ' ">';
                        echo 'Name: <span class="patientName">' . $rowPendingTests['patientName'] . '</span><br />';
                        echo 'Patient ID: <span class="patientID">' . $rowPendingTests['patientID'] . '</span><br />';
                        echo 'Ref. By: '.$rowPendingTests['name'];
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
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            var pendingTests = document.querySelectorAll('#pendingTest');
            var patients = document.querySelectorAll('#patient');

            patients.forEach(function (patient) {
                patient.addEventListener('click', function () {
                    var patientName = this.getAttribute('data-patient-name');
                    var patientID = this.getAttribute('data-patient-id');
                    var doctorID = this.getAttribute('data-doctor-id');
                    var visitID = this.getAttribute('data-visit-id');
                    var reportID = this.getAttribute('data-report-id');

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'labTechnicianPatient.php');
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            // Handle the response if needed
                            window.location.href = 'labTechnicianPatient.php';
                        }
                    };

                    var data = {
                        patientName: patientName,
                        patientID: patientID,
                        doctorID: doctorID,
                        visitID: visitID,
                        reportID: reportID

                    };

                    xhr.send(JSON.stringify(data));
                });
            });

            pendingTests.forEach(function (pendingTest) {
                pendingTest.addEventListener('click', function () {
                    // var patientName = this.getAttribute('data-patient-name');
                    var patientID = this.getAttribute('data-patient-id');
                    var doctorID = this.getAttribute('data-doctor-id');
                    var visitID = this.getAttribute('data-visit-id');
                    var reportID = this.getAttribute('data-report-id');

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'pendingTests.php');
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            // Handle the response if needed
                            window.location.href = 'pendingTests.php'; // Redirect to page 3
                        }
                    };

                    var data = {
                        patientID: patientID,
                        doctorID: doctorID,
                        visitID: visitID,
                        reportID: reportID

                    };

                    xhr.send(JSON.stringify(data));
                });
            });
        });
    </script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('searchInput');

            // Add event listener to the search input field
            searchInput.addEventListener('input', function () {
                var searchValue = searchInput.value.toLowerCase().trim(); // Get the search input value and convert to lowercase

                // Loop through all box elements and show/hide based on search input
                var boxes = document.querySelectorAll('.box');
                boxes.forEach(function (box) {
                    var patientName = box.querySelector('.patientName').textContent.toLowerCase(); // Get the patient name
                    var patientID = box.querySelector('.patientID').textContent.toLowerCase(); // Get the patient ID

                    // Check if search value matches either patient name or patient ID
                    if (patientName.includes(searchValue) || patientID.includes(searchValue)) {
                        box.style.display = 'block'; // Show the box
                    } else {
                        box.style.display = 'none'; // Hide the box
                    }
                });
            });
        });
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // Show SweetAlert confirmation dialog when the logout button is clicked
        document.getElementById('logoutButton').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default form submission

            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: ["Cancel", "Yes"], // Customize the buttons
                dangerMode: true, // Highlight the "Yes" button in red
            }).then((willLogout) => {
                if (willLogout) {
                    document.getElementById('logoutForm').submit(); // Submit the form to perform logout
                } else {
                    swal("You can continue browsing!", {
                        icon: "success",
                    });
                }
            });
        });
    </script>
</body>

</html>