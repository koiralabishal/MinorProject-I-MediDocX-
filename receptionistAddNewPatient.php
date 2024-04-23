<?php
session_start();
include 'connection.php';

if(!isset($_SESSION['receptionistEmail'])){
  header('Location:index.php');
}

function logout()
{
  // Clear session data
  unset($_SESSION['receptionistEmail']);
  // Redirect to the login page
  header('Location: index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
  logout();
}
if(isset($_SESSION['receptionistEmail'])){
  $receptionistEmail  = $_SESSION['receptionistEmail'];

  $sqlReceptionistInfo = "SELECT * FROM receptionist WHERE receptionistEmail = '$receptionistEmail'";
  $resultReceptionistInfo = mysqli_query($conn,  $sqlReceptionistInfo);

  if($resultReceptionistInfo){
    $rowReceptionistInfo = mysqli_fetch_assoc($resultReceptionistInfo);
  }
}
?>



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
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
      <button type="submit" id="logoutButton">Log out</button>
    </form>
    <!-- <button onclick="addPatient()">Add Patient <i class="fa fa-search">Hi</i> </button> -->
    <input type="text" placeholder="Search Patient..." />
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic"></div>
      <div id="details">
      <b> <?php echo $rowReceptionistInfo['name']; ?> </b><br />
        Receptionist <br />
        ID: <?php echo $rowReceptionistInfo['receptionistID']; ?> <br />
        <!-- M.D. Cardiology -->
      </div>
    </div>
  </aside>
  <main>
    <section>
      <div class="sectionTitle">
        <h2>Appoint New Patient</h2>
      </div>
      <div class="container">
        <form id = "patientForm" action="receptionistAddNewPatient.php" method="POST">
          <label id="test">
            <span class="labelText">Name:</span>
            <input type="text" id="patientName" name="name" />
          </label>

          <!-- <label id="test">
            <span class="labelText">PatientID:</span>
            <input type="text" id="patientID" name="patientID" />
          </label> -->

          <label>
            <span class="labelText">DOB:</span>
            <input type="date" id="dob" name="dob" />
          </label>

          <label>
            <span class="labelText">Gender:</span>
            <label for="male">Male</label><input type="radio" id="male" value="Male" name="gender">
            <label for="female">Female</label><input type="radio" id="female" value="Female" name="gender">
          </label>

          <label>
            <span>Address:</span>
            <input type="text" name="address">
          </label>

          <label>
            <span>Email:</span>
            <input type="" name="email">
          </label>

          <label>
            <button type="submit" name="submit">Add new Patient</button>
          </label>
        </form>
      </div>
    </section>
  </main>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Show SweetAlert confirmation dialog when the logout button is clicked
    document.getElementById('logoutButton').addEventListener('click', function (event) {
      event.preventDefault(); // Prevent the default form submission

      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        buttons: ["Cancel", "Yes"], // Customize the buttons
        dangerMode: true, // Highlight the "Yes" button in red
      }).then((willLogout) => {
        if (willLogout) {
          document.getElementById('logoutForm').submit(); // Submit the form to perform logout
        } else {
          swal("You can continue browsing!", {
            icon: "success",
          });
        }
      });
    });
  </script>

</html>
<?php
// Connect to the database
include 'connection.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
  // Initialize an array to store validation errors
  $errors = [];

  // Validate name
  $name = $_POST['name'];
  // $ID = $_POST['patientID'];
  $dob = $_POST['dob'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;


  $sqlEmailQuery = "SELECT email from new_patient WHERE email = '$email'";
  $resultEmail = mysqli_query($conn, $sqlEmailQuery);

  // $sqlIDQuery = "SELECT patientID from new_patient WHERE patientID = '$ID'";
  // $resultID = mysqli_query($conn, $sqlIDQuery);

  if (empty($gender) || empty($name) || empty($dob) || empty($address) || empty($email)) {
    $errors['empty'] = "All fields are required";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['empty']; ?> ",
        icon: "error",
        button: "Ok",
      }).then(() =>{
        window.location = "receptionistAddNewPatient.php";
      });

    </script>
    <?php
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['email']; ?> ",
        icon: "error",
        button: "Ok",
      }).then(() =>{
        window.location = "receptionistAddNewPatient.php";
      });

    </script>
    <?php
  } elseif (mysqli_num_rows($resultEmail) > 0) {
    $errors['email'] = "Email already in use";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['email']; ?> ",
        icon: "error",
        button: "Ok",
      }).then(() =>{
        window.location = "receptionistAddNewPatient.php";
      });

    </script>
    <?php

  } 
  // elseif (mysqli_num_rows($resultID)) {
  //   $errors['id'] = "ID already in use";
    ?>
    <!-- <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['id']; ?> ",
        icon: "error",
        button: "Ok",
      }).then(() =>{
        window.location = "receptionistAddNewPatient.php";
      });

    </script> -->
    <?php
  // }


  $last_patient_id_query = "SELECT MAX(patientID) AS max_patient_id FROM new_patient";
  $last_patient_id_result = mysqli_query($conn, $last_patient_id_query);
  $last_patient_id_row = mysqli_fetch_assoc($last_patient_id_result);
  $last_patient_id = $last_patient_id_row['max_patient_id'];

  if ($last_patient_id === "") {
    $ID = 1; // If table is empty, set report ID to 1
  } else {
    $ID = $last_patient_id + 1; // Otherwise, increment the last report ID
  }

  // If there are no validation errors, insert data into the database
  if (count($errors) == 0) {
    // Prepare and execute the SQL statement to insert data into the new_patient table
    $sql = "INSERT INTO new_patient (name, patientID, dob, gender, address, email) VALUES ('$name','$ID', '$dob', '$gender', '$address', '$email')";
    if (mysqli_query($conn, $sql)) {
      ?>
      <script>

        swal({
          title: "Success",
          text: "New Patient Added Successfully\nPatient ID : <?php echo $ID ?>",
          icon: "success",
          button: "Ok",
        }).then(() => {
          window.location = "receptionist.php";
        });

      </script>
      <?php
    }
  }
}
?>