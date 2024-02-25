<?php
session_start();
include 'connection.php';

$email = $_SESSION['email'];


$sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Doctor'";
$sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC";

$sql3 = "SELECT a.* FROM all_patient a JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC";

$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);

if ($result) {
  $row = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>doctorl</title>
  <!-- <link rel="stylesheet" href="style.css"> -->
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    header {
      background-color: rgb(239, 239, 239);
      padding: 1vw;
      width: 100vw;
      height: 15vh;
      position: fixed;
      display: flex;
    }

    header img {
      height: 100%;
    }

    header input {
      /* align-self: center; */
      border: none;
      margin: auto 4% auto auto;
      padding: 1%;
      height: fit-content;
      background-color: rgb(252, 252, 252);
      font-size: 16px;
      border-radius: 12px;
    }

    header input:focus {
      /* background-color: red; */
      outline: none;
      /* border-bottom: 1px solid gray; */
      /* text-decoration: underline; */
      /* text-decoration-line: underline; */
    }

    aside {
      display: inline-block;
      background-color: #3e588f;
      color: #e3e8f8;
      width: 15vw;
      height: 85vh;
      margin-top: 15vh;
      position: fixed;
    }

    aside #profileInfo {
      /* background-color: red; */
      width: 100%;
      /* height: 32vh; */
      padding-top: 16%;
    }

    aside #profileInfo #profilePic {
      width: 48%;
      aspect-ratio: 1/1;
      margin: auto auto;
      background-image: url(Mayukh\ Baral.jpg);
      background-repeat: no-repeat;
      background-position: center top;
      background-size: 100%;
      border-radius: 50%;
    }

    aside #profileInfo #details {
      width: fit-content;
      /* background-color: gold; */
      color: #e3e8f8;
      margin: 8% auto 0;
      text-align: center;
    }

    aside #reportTemplatesContainer {
      background-color: #2f426b;
      margin-top: 8%;
    }

    aside #reportTemplatesContainer h3 {
      /* background-color: red; */
      padding: 4%;
      padding-left: 6%;
      border-bottom: 1px solid rgb(190, 177, 104);
    }

    aside #reportTemplatesContainer .reportTemplatesAside {
      /* background-color: red; */
      border-bottom: 1px solid #3e588f;
      padding: 2%;
      padding-left: 12%;
    }

    main {
      display: inline-block;
      background-color: #e3e8f8;
      margin-top: 15vh;
      margin-left: 15vw;
      width: 85vw;
      /* padding-top: 4vh; */
      /* padding: 2%; */
    }

    main section {
      background-color: whitesmoke;
      margin: 4% 6%;
      padding: 1%;
      border-radius: 8px;
      box-shadow: 4px 4px 8px 5px darkgrey;
    }

    main section .header {
      /* background-color: lightblue; */
      font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
      padding: 1%;
    }

    main section .container {
      background-color: #e3e8f8;
      /* background-color: red; */
      padding: 1%;
      margin: 2% 1%;
      border-radius: 8px;
    }

    main section .container .month {
      /* background-color:cadetblue; */
      padding: 1%;
      font-family: Arial, Helvetica, sans-serif;
      border-bottom: 1px solid silver;
    }

    main section .boxContainer {
      /* background-color: lightgreen; */
      /* padding-top: 1%; */
      display: flex;
      /* flex-wrap:wrap; */
    }

    main section .boxContainer .box {
      background-color: #4e6eb2;
      color: #e3e8f8;
      padding: 2%;
      /* height: 100px; */
      margin: 1%;
      display: inline-block;
      transition: all 0.2s;
      cursor: pointer;
      border-radius: 8px;
      border: 1px solid silver;
      font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS",
        sans-serif;
    }

    main section .boxContainer .box:hover {
      background-color: whitesmoke;
      color: #2f426b;
      box-shadow: 2px 2px 8px 1px grey;
      /* transition: background-color, box-shadow 1s; */
    }
  </style>
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <!-- <button onclick="addPatient()">Add Patient <i class="fa fa-search">Hi</i> </button> -->
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
        
        (<?php echo $row['universityCollageCountry']; ?>)
      </div>
    </div>
    <div id="reportTemplatesContainer">
      <h3>All Patients</h3>
       <?php
       if($result3){
        while($row3 = mysqli_fetch_array($result3)){
        echo '<div class="reportTemplatesAside">';
        echo $row3['patientName'];
        echo "</div>";
        //  <div class="reportTemplatesAside">Bishal Koirala</div>
        // <div class="reportTemplatesAside">Sadikshya Banstola</div>
        
       }
      }
      ?>
    </div>
    
  </aside>
  <main>
    <section>
      <div class="header">
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
      <div class="header">
        <h2>Pending Patients</h2>
      </div>
      <div class="container">
        <div class="month">Pending Reports</div>
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
        <div class="month">Follow-up Patients</div>
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
    function addPatient() {
      window.location.href = "addPatient.php";
    }

    function patient() {
      window.location.href = "doctorPatient.php";
    }

    function biochemistry() {
      window.location.href = "bioChemistry.php";
    }

    function haematology() {
      window.location.href = "haematology.php";
    }

    function echocardiography() {
      window.location.href = "echocardiography.php";
    }
  </script>
</body>

</html>