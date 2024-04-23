<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['adminEmail'])) {
  header('Location: index.php');
}
function logout()
{
  // Clear session data
  unset($_SESSION['adminEmail']);
  // Redirect to the login page
  header('Location: index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
  logout();
}

if (isset($_SESSION['adminEmail'])) {
  $adminInfo = "SELECT * from admins WHERE adminEmail = '{$_SESSION['adminEmail']}'";
  $adminInfoResult = mysqli_query($conn, $adminInfo);

  if ($adminInfoResult) {
    $rowAdminInfo = mysqli_fetch_array($adminInfoResult);
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>adminAddNewLabTechnician</title>
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
    <input type="text" placeholder="Search Patient..." />
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic"></div>
      <div id="details">
        <b> <?php echo $rowAdminInfo['name']; ?> </b><br />
        Admin <br />
        ID: <?php echo $rowAdminInfo['adminID']; ?> <br />
        <!-- M.D. Cardiology -->
      </div>
    </div>
  </aside>
  <main>
    <section>
      <div class="sectionTitle">
        <h2>Add New Lab Technician</h2>
      </div>
      <div class="container">
        <form action="adminAddNewLabTechnician.php" method="POST">
          <label id="test">
            <span class="labelText">Name:</span>
            <input type="text" id="technicianName" name="technicianName"
              value="<?php echo isset($_POST['technicianName']) ? htmlspecialchars($_POST['technicianName']) : ''; ?>" />
          </label>

          <!-- <label id="test">
              <span class="labelText">Technician ID:</span>
              <input type="text" id="technicianId" name = "technicianId" />
            </label> -->

          <label>
            <span class="labelText">DOB:</span>
            <input type="date" id="dob" name="dob"
              value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" />
          </label>

          <label>
            <span class="labelText">Gender:</span>
            <label for="male">Male</label><input type="radio" id="male" name="gender" value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'checked' : ''; ?>>
            <label for="female">Female</label><input type="radio" id="female" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?>>
          </label>

          <label>
            <span>Address:</span>
            <input type="text" name="address"
              value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
          </label>

          <label>
            <span>Email:</span>
            <input type="" name="email"
              value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
          </label>

          <label>
            <span>Qualification:</span>
            <input type="text" name="qualification"
              value="<?php echo isset($_POST['qualification']) ? htmlspecialchars($_POST['qualification']) : ''; ?>">
          </label>

          <label>
            <span>University/ College/ Country:</span>
            <input type="text" name="universityCollegeCountry"
              value="<?php echo isset($_POST['universityCollegeCountry']) ? htmlspecialchars($_POST['universityCollegeCountry']) : ''; ?>">
          </label>

          <label>
            <button type="submit" name="submit">Add new Lab Technician</button>
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

include 'connection.php';

if (isset($_POST['submit'])) {

  $errors = [];

  $technicianName = $_POST['technicianName'];
  // $technicianId = $_POST['technicianId'];
  $dob = $_POST['dob'];
  $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;
  $address = $_POST['address'];
  $email = $_POST['email'];
  // $specialization = $_POST['specialization'];
  $qualification = $_POST['qualification'];
  $universityCollegeCountry = $_POST['universityCollegeCountry'];


  $sqlEmailQuery = "SELECT email FROM hospital WHERE email = '$email' ";
  $resultEmail = mysqli_query($conn, $sqlEmailQuery);

  // $sqlIDQuery = "SELECT labTechnicianID from hospital WHERE labTechnicianID = '$technicianId'";
  // $resultID = mysqli_query($conn, $sqlIDQuery);

  if (empty($technicianName) || empty($dob) || empty($gender) || empty($address) || empty($email) || empty($qualification) || empty($universityCollegeCountry)) {
    $errors['empty'] = "All fields are required";
    ?>
    <script>
      swal({
        title: "Error",
        text: "<?php echo $errors['empty'] ?>",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "adminAddNewLabTechnician.php";
      });
    </script>
    <?php
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['email'] ?>",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "adminAddNewLabTechnician.php";
      });

    </script>
    <?php
  } elseif (mysqli_num_rows($resultEmail) > 0) {
    $errors['email'] = "Email already in use";
    ?>
    <script>

      swal({
        title: "Error",
        text: "<?php echo $errors['email'] ?>",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "adminAddNewLabTechnician.php";
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
      }).then(() => {
        window.location = "adminAddNewLabTechnician.php";
      });

    </script> -->
  <?php
  // }

  $last_id_query = "SELECT max(doctorID) AS max_id FROM hospital WHERE userType = 'Doctor' UNION  SELECT max(labTechnicianID) AS max_id FROM hospital WHERE userType = 'Lab Technician'";

  $last_id_result = mysqli_query($conn, $last_id_query);
  $last_id_row = mysqli_fetch_assoc($last_id_result);
  $last_id = $last_id_row['max_id'];

  if ($last_id === "") {
    $ID = 1; // If table is empty, set ID to 1
  } else {
    $ID = $last_id + 1; // Otherwise, increment the last ID
  }


  if (count($errors) == 0) {

    $sql = "INSERT INTO hospital (name,email, doctorID, patientID, labTechnicianID, doctorQualification,doctorSpecialization ,universityCollageCountry, userType) 
    VALUES ('$technicianName', '$email',NULL, NULL,'$ID', '$qualification',NULL, '$universityCollegeCountry', 'Lab Technician')";

    if (mysqli_query($conn, $sql)) {
      ?>
      <script>

        swal({
          title: "Success",
          text: "New Lab Technician Added Successfully\nLab Technician ID: <?php echo $ID ?>",
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