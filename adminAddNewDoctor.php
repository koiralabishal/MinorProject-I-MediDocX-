<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>adminAddNewDoctor</title>
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
        <h2>Add New Doctor</h2>
      </div>
      <div class="container">
        <form action="adminAddNewDoctor.php" method="POST">
          <label id="test">
            <span class="labelText">Name:</span>
            <input type="text" id="doctorName" name = "doctorName"/>
          </label>

          <label id="test">
            <span class="labelText">Doctor ID:</span>
            <input type="text" id="doctorId" name="doctorId"/>
          </label>

          <label>
            <span class="labelText">DOB:</span>
            <input type="date" id="dob" name="dob" />
          </label>

          <label>
            <span class="labelText">Gender:</span>
            <label for="male">Male</label><input type="radio" id="male" name="gender" value="Male">
            <label for="female">Female</label><input type="radio" id="female" name="gender" value="Female">
          </label>

          <label>
            <span>Address:</span>
            <input type="text" name = "address">
          </label>

          <label>
            <span>Email:</span>
            <input type="" id="email" name="email">
          </label>

          <label>
            <span>Specilization:</span>
            <input type="text" name="specialization">
          </label>

          <label>
            <span>Qualification:</span>
            <input type="text" name="qualification">
          </label>

          <label>
            <span>University/ College/ Country:</span>
            <input type="text" name="universityCollegeCountry">
          </label>

          <label>
            <button type="submit" name="submit">Add new Doctor</button>
          </label>
        </form>
      </div>
    </section>
  </main>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</html>

<?php

include 'connection.php';

if (isset($_POST['submit'])) {

  $errors = [];

  $doctorName = $_POST['doctorName'];
  $doctorId = $_POST['doctorId'];
  $dob = $_POST['dob'];
  $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;
  $address = $_POST['address']; 
  $email = $_POST['email'];
  $specialization = $_POST['specialization'];
  $qualification = $_POST['qualification']; 
  $universityCollegeCountry = $_POST['universityCollegeCountry'];

  
  $sqlEmailQuery = "SELECT email FROM hospital WHERE email = '$email' ";
  $resultEmail = mysqli_query($conn, $sqlEmailQuery);

  $sqlIDQuery = "SELECT doctorID from hospital WHERE doctorID = '$doctorId'";
  $resultID = mysqli_query($conn, $sqlIDQuery);

  if (empty($doctorName) || empty($doctorId) || empty($dob) || empty($gender) || empty($address) || empty($email) || empty($specialization) || empty($qualification) || empty($universityCollegeCountry)) {
    $errors['empty'] = "All fields are required";
    ?>
    <script>
      swal({
        title: "Error",
        text: "<?php echo $errors['empty'] ?>",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "adminAddNewDoctor.php";
      });
    </script>
    <?php
  }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['email'] ?>",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "adminAddNewDoctor.php";
      });

    </script>
    <?php
  }elseif (mysqli_num_rows($resultEmail) > 0) {
    $errors['email'] = "Email already in use";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['email'] ?>",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "adminAddNewDoctor.php";
      });

    </script>
    <?php

  }elseif (mysqli_num_rows($resultID)) {
    $errors['id'] = "ID already in use";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['id']; ?> ",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "adminAddNewDoctor.php";
      });

    </script>
    <?php
  }

  if (count($errors) == 0) {

    $sql = "INSERT INTO hospital (name,email, doctorID, patientID, labTechnicianID, doctorSpecialization, doctorQualification, universityCollageCountry, userType) 
    VALUES ('$doctorName', '$email','$doctorId', NULL, NULL, '$specialization', '$qualification', '$universityCollegeCountry', 'Doctor')";

    if (mysqli_query($conn, $sql)) {
      ?>
      <script>

        swal({
          title: "Success",
          text: "New Doctor Added Successfully",
          icon: "success",
          button: "Ok",
        }).then(() => {
          window.location = "admin.php";
        });

      </script>
      <?php
    }
  }
}
?>