<?php
session_start();
include 'connection.php';

$date = $_SESSION['date'];

if (isset($_POST['submit'])) {
    $patientID = $_POST['patientID'];
    $doctorID = $_POST['doctorID'];
    $visitID = $_POST['visitID'];
    $prescription = $_POST['newPrescription'];

    $sqlUpdateQuery = "UPDATE prescription set prescriptions='$prescription' WHERE patientID='$patientID'
    AND doctorID='$doctorID'
    AND visitID='$visitID'";

    $resultUpdateQuery = mysqli_query($conn, $sqlUpdateQuery);

    if ($resultUpdateQuery) {

        // Check if there are any rows in appointed_patient table for the given conditions
        $countQuery = "SELECT COUNT(*) AS count FROM appointed_patient WHERE patientID='$patientID' AND doctorID='$doctorID'";
        $resultCount = mysqli_query($conn, $countQuery);
        $rowCount = mysqli_fetch_assoc($resultCount);
        $count = $rowCount['count'];

        if ($count > 0) {
            // If rows exist in appointed_patient table, delete from it
            $deleteQuery = "DELETE FROM appointed_patient WHERE patientID='$patientID' AND doctorID='$doctorID' AND visitID='$visitID'";
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
            // If no rows exist in appointed_patient table, delete from pendingReport table

            $sqlReportID = "SELECT reportID FROM pendingReport WHERE patientID = '$patientID' AND doctorID ='$doctorID' AND visitID = '$visitID'";

            $resultReport = mysqli_query($conn, $sqlReportID);

            if($resultReport){
                $rowReportID = mysqli_fetch_assoc($resultReport);
            }

            $deleteReportQuery = "DELETE FROM pendingReport WHERE patientID='$patientID' AND doctorID='$doctorID' AND date = '$date' AND reportID = '{$rowReportID['reportID']}'";
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
        }

    }
}





// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $patientage = $_GET['age'];
// $patientgender = $_GET['gender'];
$patientName = $_SESSION['patientName'];
$patientID = $_SESSION['patientID'];
$patientage = $_SESSION['age'];
$patientgender = $_SESSION['gender'];
$email = $_SESSION['doctorEmail'];
// $visitID = $_SESSION['visitID'];
// echo $visitID;




$sqlVisitID = "SELECT visitID FROM patientVisitDetails WHERE date = '$date'";
$resultVisitID = mysqli_query($conn, $sqlVisitID);

if ($resultVisitID) {
    $rowVisitID = mysqli_fetch_assoc($resultVisitID);
}


$sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Doctor'";
// $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

$result = mysqli_query($conn, $sql);
// $result2 = mysqli_query($conn, $sql2);

if ($result) {
    $row = mysqli_fetch_assoc($result);
}


$sqlPrescription = "SELECT prescriptions FROM prescription WHERE patientID = '$patientID'
AND doctorID = {$row['doctorID']}
AND visitID = {$rowVisitID['visitID']}";

$resultPrescription = mysqli_query($conn, $sqlPrescription);

if ($resultPrescription) {
    $rowPrescription = mysqli_fetch_assoc($resultPrescription);
}

// if ($result2) {
//   $row2 = mysqli_fetch_assoc($result2);
// }


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
        <section id="prescriptionSection">
            <div class="sectionTitle">
                <h2>Add Prescription</h2>
            </div>
            <form action="addPrescription.php" method="POST">
                <input type="hidden" name="patientID" value="<?php echo $patientID; ?>" />
                <input type="hidden" name="doctorID" value="<?php echo $row['doctorID']; ?>" />
                <input type="hidden" name="visitID" value="<?php echo $rowVisitID['visitID']; ?>" />
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

</html>