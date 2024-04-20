<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>receptionist</title>
    <link rel="stylesheet" href="style1.css" />
    <style>
      .container form {
        background-color: lightblue;
        display: flex;
        flex-direction: column;
      }

      .container form label .inputName {
        display: inline-block;
        width: 173px;
        height: 19px;
        background-color: white;
        border: 1px solid #767676;
        border-radius: 3px;
      }
    </style>
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
          <b> Mayukh Baral </b><br />
          Receptionist <br />
          ID: 54 <br />
          M.D. Cardiology
        </div>
      </div>
    </aside>
    <main>
      <section>
        <div class="sectionTitle">
          <h2>Appoint Patient</h2>
          <button onclick="addNewPatient()">Add new patient</button>
        </div>
        <div class="container">
          <form action="">
            <label id="test">
              <span class="labelText">Patient Id:</span>
              <input type="text" id="patientId" />
            </label>
            <label>
              <span class="labelText">Patient Name:</span>
              <span class="inputName"></span>
            </label>
            <label>
              <span class="labelText">Ref. Doctor Id:</span>
              <input type="text" id="doctorId" />
            </label>
            <label>
              <span class="labelText">Ref. Doctor Name:</span>
              <span class="inputName"></span>
            </label>
            <label>
              <span class="labelText">Date:</span>
              <input type="datetime-local">
            </label>
            <label>
              <button type="submit">Appoint</button>
            </label>            
          </form>
        </div>
      </section>
    </main>
    <script>
      function addNewPatient(){
        window.location.href = "receptionistAddNewPatient.php";
      }
    </script>
  </body>
</html>
