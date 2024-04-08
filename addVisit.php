
<?php
session_start();
include 'connection.php';

// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $patientage = $_GET['age'];
// $patientgender = $_GET['gender'];
$patientName = $_SESSION['patientName'];
$patientID  = $_SESSION['patientID'];
$patientage = $_SESSION['age'];
$patientgender = $_SESSION['gender'];
$email = $_SESSION['email'];



$sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Doctor'";
// $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

$result = mysqli_query($conn, $sql);
// $result2 = mysqli_query($conn, $sql2);

if ($result) {
  $row = mysqli_fetch_assoc($result);
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
        padding: 1%;
        display: flex;
      }

      main section .header button {
        border: 1px solid gray;
        margin: auto 4% auto auto;
        padding: 1%;
        height: fit-content;
        background-color: rgb(252, 252, 252);
        font-size: 16px;
        border-radius: 12px;
        /* background-color: red; */
      }

      main section .header button:hover {
        box-shadow: 2px 2px 4px 2px darkgrey;
        cursor: pointer;
        background-color: rgb(254, 254, 254);
      }

      main section .container {
        /* background-color: lightgreen; */
        border-top: 1px solid silver;
        padding-top: 1%;
        display: flex;
        /* flex-wrap:wrap; */
      }

      main section .container .box {
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
        font-family: Arial, Helvetica, sans-serif;
        width: 100%;
        max-width: 98%;
      }
      main section .container .box:hover {
        background-color: #e3e8f8;
        color: #2f426b;
        box-shadow: 2px 2px 8px 1px grey;
        /* transition: background-color, box-shadow 1s; */
      }

      main section .container .box textarea {
        /* background-color: red; */
        min-width: 100%;
        width:100%;
        max-width: 100%;
        height: 48vh;
      }
    </style>
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
        <b><?php echo $row['name']; ?></b><br />
          <?php echo $row['userType']; ?> <br />
          ID: <?php echo $row['doctorID']; ?> <br />
          <?php echo $row['doctorQualification']; ?> <br />
          (<?php echo $row['universityCollageCountry']; ?>)
        </div>
      </div>
      <div id="reportTemplatesContainer">
        <h3>Patient Info</h3>
        <div class="reportTemplatesAside">Name: <?php echo $patientName; ?></div>
        <div class="reportTemplatesAside">Patient ID: <?php echo $patientID; ?></div>
        <div class="reportTemplatesAside">Age: <?php echo $patientage; ?></div>
        <div class="reportTemplatesAside">Gender: <?php echo $patientgender; ?></div>
      </div>
      <!-- <div id="reportTemplatesContainer">
        <h3>All Patients</h3>
        <div class="reportTemplatesAside">Mayukh Baral</div>
        <div class="reportTemplatesAside">Bishal Koirala</div>
        <div class="reportTemplatesAside">Sadikshya Banstola</div>
      </div> -->
    </aside>
    <main>
      <section>
        <div class="header">
          <h2>Add Prescription</h2>
          <button onclick="requestationLetter()">Request Letter</button>
        </div>
        <div class="container">
          <div class="box">
            <textarea
              name="newPrescription"
              id=""

            ></textarea>
          </div>
        </div>
        <!-- <button type="submit">Save</button> -->
    </section>

    </main>

    <script>
      function requestationLetter() {
        window.location.href = "requestationLetter.php"
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

      function immunology(){
        window.location.href = "immunology.php";
      }

      // document.addEventListener('DOMContentLoaded', function(){
      //     let box = document.querySelectorAll('.box');
      //     box.forEach(function(bpar){
      //         bpar.addEventListener("click", function(){
      //             this.style.backgroundColor = "red";
      //         });
      //     });
      // });

      // let box = document.querySelectorAll(".box");
      // box.forEach(function (bpar) {
      //   bpar.addEventListener("click", function () {
      //       this.style.transition = "all .2s";
      //       // this.style.zIndex = "0";
      //       if(this.style.backgroundColor == "red"){
      //           this.style.backgroundColor = "grey";
      //           this.style.transform = "scale(1)";
      //           // this.style.zIndex = "0";
      //       }
      //       else{
      //           // this.style.zIndex = "10";
      //           this.style.transform = "scale(2)";
      //           this.style.backgroundColor = "red";
      //       }
      //   });
      // });
      
    </script>
  </body>
</html>
