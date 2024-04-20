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
            <div class="box">
              Name: Mayukh Baral <br />
              Patient ID: 54 <br />
              Referred by: Dr. Ram Chandra Kafle
            </div>
            <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div>
          </div>
        </div>
      </section>

      <section>
        <div class="sectionTitle">
          <h2>All Lab Technicians</h2>
        </div>
        <div class="container">
          <div class="boxContainer">
            <div class="box">
              Name: Mayukh Baral <br />
              Patient ID: 54 <br />
              Referred by: Dr. Ram Chandra Kafle
            </div>
            <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div>
          </div>
        </div>
      </section>

      <section>
        <div class="sectionTitle">
          <h2>All Lab Patients</h2>
        </div>
        <div class="container">
          <div class="boxContainer">
            <div class="box">
              Name: Mayukh Baral <br />
              Patient ID: 54 <br />
              Referred by: Dr. Ram Chandra Kafle
            </div>
            <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div>
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
