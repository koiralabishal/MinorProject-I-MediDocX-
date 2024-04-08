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

    $doctorEmail = $_SESSION['doctorEmail'];
    // $patientName = $_SESSION['patientName'];
// $patientID  = $_SESSION['patientID'];
// $patientage = $_SESSION['age'];
// $patientgender = $_SESSION['gender'];

    $_SESSION['patientName'] = $patientName;
    $_SESSION['patientID'] = $patientID;
    $_SESSION['age'] = $patientage;
    $_SESSION['gender'] = $patientgender;

    $sql = "SELECT * FROM hospital WHERE email = '{$doctorEmail}' AND userType ='Doctor'";
    // $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

    $result = mysqli_query($conn, $sql);
    // $result2 = mysqli_query($conn, $sql2);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
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
            <div class="container">
                <div class="date">February, 2024</div>
                <div class="boxContainer">
                    <div class="box" onclick="visit()">
                        Date: 2024/ 02/ 17 <br />
                        Visit Type: Routine Check-up <br />
                    </div>
                    <div class="box">
                        Date: 2022/ 09/ 07 <br />
                        Visit Type: Follow-up Consultation <br />
                    </div>
                    <div class="box">
                        Date: 2022/ 09/ 05 <br />
                        Visit Type: Routine Check-up <br />
                    </div>
                    <div class="box">7</div>
                    <div class="box">8</div>
                    <div class="box">9</div>
                    <div class="box">10</div>
                </div>
            </div>

            <div class="container">
                <div class="date">September, 2022</div>
                <div class="boxContainer">
                    <div class="box">
                        Date: 2022/ 09/ 07 <br />
                        Visit Type: Follow-up Consultation <br />
                    </div>
                    <div class="box">
                        Date: 2022/ 09/ 05 <br />
                        Visit Type: Routine Check-up <br />
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function addVisit() {
            window.location.href = "addVisit.html";
        }

        function visit() {
            window.location.href = "doctorPatientVisit.html";
        }
        function biochemistry() {
            window.location.href = "bioChemistry.html";
        }

        function haematology() {
            window.location.href = "haematology.html";
        }

        function echocardiography() {
            window.location.href = "echocardiography.html";
        }
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>