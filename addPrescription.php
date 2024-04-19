<?php
// session_name('doctor_session');
session_start();
include 'connection.php';
if (!isset($_SESSION['doctorEmail'])){
    header('Location: index.php');
}
function logout()
{
    // Clear session data
    unset($_SESSION['doctorEmail']);
    // Redirect to the login page
    header('Location: index.php');
    exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
    logout();
}




$email = $_SESSION['doctorEmail'];
$visitID = $_SESSION['visitID'];

$date = $_SESSION['date'];

$sqlPatientInfo = "SELECT * FROM patientvisitdetails WHERE visitID = '$visitID' AND date = '$date'";
$resultPatientInfo = mysqli_query($conn, $sqlPatientInfo);
if ($resultPatientInfo) {
    $rowPatientInfo = mysqli_fetch_assoc($resultPatientInfo);
}

// $sql2 = "SELECT a.* FROM patientvisitdetails a JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC";
// $result2 = mysqli_query($conn, $sql2);
// if ($result2) {
//     $row2 = mysqli_fetch_assoc($result2);
// }

if (isset($_POST['submit'])) {
    $patientID = $_POST['patientID'];
    $doctorID = $_POST['doctorID'];
    $visitID = $_POST['visitID'];
    $date = $_POST['date'];
    $prescription = $_POST['newPrescription'];

    $sqlUpdateQuery = "UPDATE prescription set prescriptions='$prescription' WHERE patientID='$patientID'
    AND doctorID='$doctorID'
    AND visitID='$visitID'
    AND date = '$date'";

    $resultUpdateQuery = mysqli_query($conn, $sqlUpdateQuery);

    if ($resultUpdateQuery) {

        // Check if there are any rows in appointed_patient table for the given conditions
        $countQuery = "SELECT COUNT(*) AS count FROM appointed_patient WHERE patientID='$patientID' AND doctorID='$doctorID' AND visitID='$visitID' AND date = '$date'";
        $resultCount = mysqli_query($conn, $countQuery);
        $rowCount = mysqli_fetch_assoc($resultCount);
        $count = $rowCount['count'];

        if ($count > 0) {
            // If rows exist in appointed_patient table, delete from it
            $deleteQuery = "DELETE FROM appointed_patient WHERE patientID='$patientID' AND doctorID='$doctorID' AND visitID='$visitID' AND date = '$date'";
            $resultDelete = mysqli_query($conn, $deleteQuery);

            if ($resultDelete) {
                ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Success</title>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                </head>

                <body>

                    <script>

                        document.addEventListener('DOMContentLoaded', function () {
                            // Hide the form
                            document.getElementById('prescriptionSection').style.display = 'none';

                            // Show success message
                            swal({
                                title: "Success",
                                text: "Added Successfully",
                                icon: "success",
                                button: "Ok",
                            }).then(function () {
                                // Redirect to labTechnician.php
                                window.location = "doctor.php";
                            });
                        });


                    </script>
                </body>

                </html>
                <?php
            }
        } else {
            // Check if there are any rows in appointed_patient table for the given conditions
            $countQuery = "SELECT COUNT(*) AS count FROM pendingreport WHERE patientID='$patientID' AND doctorID='$doctorID' AND visitID='$visitID' AND date = '$date'";
            $resultCount = mysqli_query($conn, $countQuery);
            $rowCount = mysqli_fetch_assoc($resultCount);
            $count = $rowCount['count'];

            if ($count > 0) {
                $deleteReportQuery = "DELETE FROM pendingreport WHERE patientID='$patientID' AND doctorID='$doctorID' AND date = '$date' AND visitID = '$visitID' AND date= '$date'";
                $resultDeleteReport = mysqli_query($conn, $deleteReportQuery);

                if ($resultDeleteReport) {
                    ?>
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Success</title>
                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    </head>

                    <body>

                        <script>

                            document.addEventListener('DOMContentLoaded', function () {
                                // Hide the form
                                document.getElementById('prescriptionSection').style.display = 'none';

                                // Show success message
                                swal({
                                    title: "Success",
                                    text: "Added Successfully",
                                    icon: "success",
                                    button: "Ok",
                                }).then(function () {

                                    window.location = "doctor.php";
                                });
                            });


                        </script>
                    </body>

                    </html>
                    <?php
                }
            } else {
                ?>
                <!-- <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Success</title>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                </head>

                <body> -->
                    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
                    <script>

                        document.addEventListener('DOMContentLoaded', function () {
                            // Hide the form
                            document.getElementById('prescriptionSection').style.display = 'display';

                            // Show success message
                            swal({
                                title: "Success",
                                text: "Added Successfully",
                                icon: "success",
                                button: "Ok",
                            });
                        });


                    </script>
                 <!-- </body>

                 </html> -->
                <?php
            }


        }
        // If no rows exist in appointed_patient table, delete from pendingReport table

        // $sqlReportID = "SELECT reportID FROM pendingReport WHERE patientID = '$patientID' AND doctorID ='$doctorID' AND visitID = '$visitID' AND date = '$date'";

        // $resultReport = mysqli_query($conn, $sqlReportID);

        // if ($resultReport) {
        //     $rowReportID = mysqli_fetch_assoc($resultReport);
        // }


    }
}





// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $patientage = $_GET['age'];
// $patientgender = $_GET['gender'];
// $patientName = $_SESSION['patientName'];
// $patientID = $_SESSION['patientID'];
// $patientage = $_SESSION['age'];
// $patientgender = $_SESSION['gender'];

// $visitID = $_SESSION['visitID'];
// echo $visitID;
// echo $visitID;

// $date = $_SESSION['date'];
// echo $date;

// $sqlVisitID = "SELECT visitID FROM patientVisitDetails WHERE date = '$date'";
// $resultVisitID = mysqli_query($conn, $sqlVisitID);

// if ($resultVisitID) {
//     $rowVisitID = mysqli_fetch_assoc($resultVisitID);
// }


$sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Doctor'";
// $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

$result = mysqli_query($conn, $sql);
// $result2 = mysqli_query($conn, $sql2);

if ($result) {
    $row = mysqli_fetch_assoc($result);
}


$sqlPrescription = "SELECT prescriptions FROM prescription WHERE patientID = '{$rowPatientInfo['patientID']}'
AND doctorID = {$row['doctorID']}
AND visitID = '$visitID'";

$resultPrescription = mysqli_query($conn, $sqlPrescription);

if ($resultPrescription) {
    $rowPrescription = mysqli_fetch_assoc($resultPrescription);
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>addVisit</title>
    <link rel="stylesheet" href="style1.css" />
</head>

<body>
    <header>
        <img src="MediDocX Logo.JPG" alt="" />
        <form method="post" id="logoutForm">
            <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
            <button type="submit" id="logoutButton">Log out</button>
        </form>

        <input type="text" placeholder="Search Patient..." />
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
                <?php echo $rowPatientInfo['patientName']; ?>
            </div>
            <div class="reportTemplatesAside">Patient ID:
                <?php echo $rowPatientInfo['patientID']; ?>
            </div>
            <div class="reportTemplatesAside">Age:
                <?php echo $rowPatientInfo['age']; ?>
            </div>
            <div class="reportTemplatesAside">Gender:
                <?php echo $rowPatientInfo['gender']; ?>
            </div>
        </div>
    </aside>

    <main>
        <section id="prescriptionSection">
            <div class="sectionTitle">
                <h2>Add Prescription</h2>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="patientID" value="<?php echo $rowPatientInfo['patientID']; ?>" />
                <input type="hidden" name="doctorID" value="<?php echo $row['doctorID']; ?>" />
                <input type="hidden" name="visitID" value="<?php echo $visitID; ?>" />
                <input type="hidden" name="date" value="<?php echo $date; ?>" />
                <textarea name="newPrescription" id=""><?php if (isset($rowPrescription) && !empty($rowPrescription['prescriptions'])) {
                    $prescription = str_replace('<br />', '', $rowPrescription['prescriptions']);
                    echo $prescription;
                } ?></textarea>
                <button type="submit" name="submit">Submit</button>
            </form>
        </section>
        <!-- <button type="submit">Save</button> -->
    </main>
</body>
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

</html>