<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>patient</title>
    <link rel="stylesheet" href="style1.css">
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
          Patient <br />
          ID: 54 <br />
          M.D. Cardiology <br />
          (TU, GMC, Nepal)
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
      function visit() {
        window.location.href = "PatientVisit.html";
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
  </body>
</html>
