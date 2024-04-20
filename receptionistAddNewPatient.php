<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>receptionistAddNewPatient</title>
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
      <!-- <button onclick="addPatient()">Add Patient <i class="fa fa-search">Hi</i> </button> -->
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
          <h2>Appoint New Patient</h2>
        </div>
        <div class="container">
          <form action="">
            <label id="test">
              <span class="labelText">Name:</span>
              <input type="text" id="patientId" />
            </label>

            <label>
              <span class="labelText">DOB:</span>
              <input type="date" id="dob" />
            </label>

            <label>
              <span class="labelText">Gender:</span>
              <label for="male">Male</label><input type="radio" id="male" name="gender">
              <label for="female">Female</label><input type="radio" id="female" name="gender">
            </label>

            <label>
              <span>Address:</span>
              <input type="text">
            </label>

            <label>
              <span>Email:</span>
              <input type="email">
            </label>

            <label>
              <button type="submit">Add new Patient</button>
            </label>            
          </form>
        </div>
      </section>
    </main>
  </body>
</html>
