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
    </header>

    <aside>
      <div id="profileInfo">
        <div id="profilePic"></div>
        <div id="details">
          <b> Mayukh Baral </b><br />
          Lab Technician <br />
          ID: 54 <br />
          B. Radiology
        </div>
      </div>
      <div id="reportTemplatesContainer">
        <h3>Patient Info</h3>
        <div class="reportTemplatesAside">Name: Bishal Koirala</div>
        <div class="reportTemplatesAside">Patient ID: 54</div>
        <div class="reportTemplatesAside">Age: 21</div>
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
        <div class="headerContainer">
          <h2><label for="newPrescription">Add Prescription</label></h2>
        </div>
        <div class="container">
          <div class="box">
            <textarea
              name="newPrescription"
              id=""
              cols="30"
              rows="10"
            ></textarea>
          </div>
        </div>
        <!-- <button type="submit">Save</button> -->
    </section>

      <section>
        <div class="headerContainer">
          <h2>Request Letter</h2>
        </div>
        <div class="container">
          <div class="box" id="b" onclick="biochemistry()">BioChemistry</div>
          <div class="box" onclick="haematology()">Hematology</div>
          <div class="box" onclick="echocardiography()">EchoCardiography</div>
          <div class="box" onclick="immunology()">Immunology</div>
        </div>
      </section>

    </main>

    <script>
      function addVisit() {
        window.location.href = "addVisit.php";
      }

      function visit() {
        window.location.href = "doctorPatientVisit.php";
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
