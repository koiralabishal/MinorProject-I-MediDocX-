<?php

include 'connection.php';


$sqlDoctorNameID = "SELECT name, doctorID FROM hospital WHERE userType = 'Doctor' ORDER BY id DESC";
$resultDoctorNameID = mysqli_query($conn, $sqlDoctorNameID);

$sqlTechnicianNameID = "SELECT name, labTechnicianID FROM hospital WHERE userType = 'Lab Technician' ORDER BY id DESC";
$resultTechnicianNameID = mysqli_query($conn, $sqlTechnicianNameID);

$sqlPatientDoctorID = "SELECT distinct patientID, doctorID FROM report";
$resultPatientDoctorID = mysqli_query($conn, $sqlPatientDoctorID);



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>admin</title>
  <link rel="stylesheet" href="style1.css" />
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <button onclick="addNewDoctor()">Add New Doctor</button>
    <button onclick="addNewLabTechnician()">Add New Lab Technician</button>
    <input type="text" placeholder="Search Patient..." />
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic"></div>
      <div id="details">
        <b> Mayukh Baral </b><br />
        Admin <br />
        ID: 54 <br />
        M.D. Cardiology
      </div>
    </div>
  </aside>

  <main>
    <section>
      <div class="sectionTitle">
        <h2>All Doctors</h2>
      </div>
      <div class="container">
        <div class="boxContainer">
          <?php
          if ($resultDoctorNameID) {
            while ($rowDoctorNameID = mysqli_fetch_assoc($resultDoctorNameID)) {
              echo '<div class="box">';
              echo 'Name: Dr. ' . $rowDoctorNameID['name'] . '<br />';
              echo 'Doctor ID: ' . $rowDoctorNameID['doctorID'] . '<br />';
              echo '</div>';
            }
          }
          ?>
          <!-- <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div> -->
        </div>
      </div>
    </section>

    <section>
      <div class="sectionTitle">
        <h2>All Lab Technicians</h2>
      </div>
      <div class="container">
        <div class="boxContainer">
          <?php
          if ($resultTechnicianNameID) {
            while ($rowTechnicianNameID = mysqli_fetch_assoc($resultTechnicianNameID)) {
              echo '<div class="box">';
              echo 'Name: ' . $rowTechnicianNameID['name'] . '<br />';
              echo 'Lab Technician ID:' . $rowTechnicianNameID['labTechnicianID'] . '<br />';
              echo '</div>';
            }
          }
          ?>
          <!-- <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div> -->
        </div>
      </div>
    </section>

    <section>
      <div class="sectionTitle">
        <h2>All Lab Patients</h2>
      </div>
      <div class="container">
        <div class="boxContainer">
          <?php
          if ($resultPatientDoctorID) {
            while ($rowPatientDoctorID = mysqli_fetch_array($resultPatientDoctorID)) {
              $patientID = $rowPatientDoctorID['patientID'];
              $doctorID = $rowPatientDoctorID['doctorID'];

              $sqlPatientNameIDDoctorName = "SELECT distinct p.patientName, p.patientID,h.name FROM patientvisitdetails p JOIN hospital h ON p.referredToDoctorID = h.doctorID WHERE h.doctorID = '$doctorID' AND p.patientID = '$patientID'  ORDER BY p.id DESC";
              $resultPatientNameIDDoctorName = mysqli_query($conn, $sqlPatientNameIDDoctorName);
              if ($resultPatientNameIDDoctorName) {
                while ($rowresultPatientNameIDDoctorName = mysqli_fetch_array($resultPatientNameIDDoctorName)) {
                  echo '<div class="box">';
                  echo 'Name: ' . $rowresultPatientNameIDDoctorName['patientName'] . '<br/>';
                  echo 'Patient ID: ' . $rowresultPatientNameIDDoctorName['patientID'] . '<br/>';
                  echo 'Ref. By: Dr.' . $rowresultPatientNameIDDoctorName['name'] . '<br/>';
                  echo '</div>';
                }
              }

            }

          }

          ?>
          <!-- <div class="box" onclick="patient()">
            Name: Bishal Koirala <br />
            Patient ID: 21 <br />
            Referred by: Dr. Nabin Bhattarai
          </div> -->
        </div>
      </div>
    </section>

  </main>

  <script>
    function addNewDoctor() {
      window.location.href = "adminAddNewDoctor.php";
    }

    function addNewLabTechnician() {
      window.location.href = "adminAddNewLabTechnician.php";
    }

  </script>
</body>

</html>