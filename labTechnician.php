<?php
session_start();
include 'connection.php';

if(!isset($_SESSION['technicianEmail'])){
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



  $sqlPendingTests = "SELECT distinct  r.patientID, h.name, r.doctorID, r.ReportID FROM report r JOIN hospital h ON r.doctorID = h.doctorID WHERE r.flag = 'P' " ;
  $resultPendingTests = mysqli_query($conn, $sqlPendingTests);

  // if ($result2) {
//   $row2 = mysqli_fetch_assoc($result2);
// }

// session_start();

?>







<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>labTechnician</title>
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
    }

    header img {
      height: 100%;
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

    main h1 {
      position: relative;
      left: 70px;
    }

    main section {
      background-color: whitesmoke;
      margin: 4% 6%;
      padding: 1%;
      border-radius: 8px;
      box-shadow: 4px 4px 8px 5px darkgrey;
    }

    main section .headerContainer {
      /* background-color: lightblue; */
      padding: 1%;
    }

    main section .container {
      /* background-color: lightgreen; */
      border-top: 1px solid silver;
      padding-top: 1%;
      display: flex;
      flex-wrap: wrap;
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
    }

    main section .container .box:hover {
      background-color: #e3e8f8;
      color: #2f426b;
      box-shadow: 2px 2px 8px 1px grey;
      /* transition: background-color, box-shadow 1s; */
    }
  </style>
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <a href="logout.php"><button>Log Out</button></a>
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
    <!-- <div id="reportTemplatesContainer">
      <h3>Report Templates</h3>
      <div class="reportTemplatesAside">BioChemistry</div>
      <div class="reportTemplatesAside">Haematology</div>
      <div class="reportTemplatesAside">Bacteriology</div>
      <div class="reportTemplatesAside">Mycology</div>
      <div class="reportTemplatesAside">Virology</div>
      <div class="reportTemplatesAside">Tumar Markers</div>
      <div class="reportTemplatesAside">Parasitology</div>
      <div class="reportTemplatesAside">Cytology</div>
    </div> -->
    <div id="reportTemplatesContainer">
      <h3>All Patients</h3>
      <?php
      if ($result2) {
        while ($row2 = mysqli_fetch_array($result2)) {
          echo '<div class="reportTemplatesAside">';
          echo $row2['patientName'];
          echo "</div>";
        }
      }

      ?>


      <!-- <div class="reportTemplatesAside">Mayukh Baral</div>
        <div class="reportTemplatesAside">Bishal Koirala</div>
        <div class="reportTemplatesAside">Sadikshya Banstola</div> -->
    </div>
  </aside>
  <main>
    <section>
      <div class="headerContainer">
        <h2>New Tests</h2>
      </div>
      <div class="container">
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
    </section>


    <section>
    <div class="headerContainer">
        <h2>Pending Tests</h2>
    </div>
    <div class="container">
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
    </section>

    <section>
      <h2>All Patients</h2>
    </section>


    <h1> Welcome
      <?php echo $row['name']; ?>
    </h1>

  </main>

  <!-- <table id="tbl" border="1">
      <tr>
        <td>A</td>
        <td>B</td>
        <td>C</td>
      </tr>
      <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
      </tr>
      <tr>
        <td>I</td>
        <td>II</td>
        <td></td>
      </tr>
    </table>
    <button id="add" onclick="add()">Add Row</button> -->

  <script>
    // function add() {
    //   console.log("1");
    //   const newTr = document.createElement("tr");
    //   const newTd1 = document.createElement("td");
    //   const newTd2 = document.createElement("td");
    //   const newTd3 = document.createElement("td");
    //   const inpt1 = document.createElement("input");
    //   const inpt2 = document.createElement("input");
    //   const inpt3 = document.createElement("input");

    //   newTr.append(newTd1, newTd2, newTd3);

    //   newTd1.append(inpt1);
    //   newTd2.append(inpt2);
    //   newTd3.append(inpt3);

    //   document.getElementById("tbl").appendChild(newTr);
    //   // document.body.insertBefore(newTr, document.getElementById('tbl'));

    //   console.log(newTr);
    //   console.log("2");
    // }

    function biochemistry() {
      window.location.href = "bioChemistry.php";
    }

    function haematology() {
      window.location.href = "haematology.php";
    }

    function echocardiography() {
      window.location.href = "echocardiography.php";
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