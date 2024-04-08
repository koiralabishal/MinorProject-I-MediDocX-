<?php
session_start();

if (!isset($_SESSION['doctorEmail'])) {
  header('Location:index.php');

}

if (isset($_SESSION['doctorEmail']) ) {
  $doctorEmail = $_SESSION['doctorEmail'];
  // if (isset($doctorEmail) && !is_null($doctorEmail)) {
  include 'connection.php';

  // $email = $_SESSION['email'];




  $sql = "SELECT * FROM hospital WHERE email = '{$doctorEmail}' AND userType ='Doctor'";

  // var_dump($doctorEmail);
  $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$doctorEmail}' ORDER BY a.ID DESC";
  // $sql2 = "SELECT distinct patientName from test_data";
  $sql3 = "SELECT a.* FROM patientVisitDetails a JOIN patient  JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$doctorEmail}' ORDER BY a.ID DESC";


  // session_write_close();

  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  $result3 = mysqli_query($conn, $sql3);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
  }

  // if($result2){
//   $row = mysqli_fetch_assoc($result2);
// }
}
// session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>doctor</title>
    <link rel="stylesheet" href="style1.css" />
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
    </aside>

    <main>
      <section>
        <div class="sectionTitle">
          <h2>Appointed Patients</h2>
        </div>
        <div class="container">
          <div class="boxContainer">
          <?php

          if ($result2) {

            while ($row2 = mysqli_fetch_array($result2)) {

              echo '<div class="box" >';
              echo '<a href="doctorPatient.php?patientID=' . $row2['patientID'] . '&patientName=' . $row2['patientName'] . '&gender=' . $row2['gender'] . '&age=' . $row2['age'] . '">';
              echo "Name: " . $row2['patientName'] . "</br >";
              echo "Patient ID: " . $row2['patientID'] . "<br />";
              echo "</a>";
              echo " </div>";
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
        </div>
      </section>

      <section>
        <div class="sectionTitle">
          <h2>Pending Reports</h2>
        </div>
        <div class="container">
          <div class="date">2024/ 04/ 08</div>
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
          <div class="date">2024/ 04/ 07</div>
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
      </section>
    </main>

    <script>
      function addPatient() {
        window.location.href = "addPatient.html";
      }

      function patient() {
        window.location.href = "doctorPatient.html";
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
