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
  $adminEmail = $_SESSION['adminEmail'];

  if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    // Check if the file extension is allowed
    if (in_array($file_extension, $allowed_extensions)) {
      // Establish a database connection (replace with your database credentials)
      $mysqli = new mysqli("localhost", "root", "", "medidocx");

      // Check connection
      if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
      }

      // Get the contents of the uploaded file
      $image_data = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));

      // Prepare and execute SQL query to insert image data into the database
      $sql = "UPDATE images SET image_data = '$image_data' WHERE user_email = '$adminEmail'";
      if ($mysqli->query($sql) === TRUE) {
        echo "Image uploaded and updated into database successfully.";
        exit;
      } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
      }

      // Close the database connection
      $mysqli->close();
    } else {
      echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
  }
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
  <title>adminAddNewDoctor</title>
  <link rel="stylesheet" href="style1.css" />
  <link rel="stylesheet" href="form.css" />
  <style>
    .profile-pic-container img {
      width: 48%;
      aspect-ratio: 1/1;
      margin: auto auto;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      transition: opacity 0.3s ease;
    }

    .profile-pic-container img:hover {
      opacity: 0.3;
      cursor: pointer;
    }

    .profile-pic-container {
      position: relative;
    }

    .profile-pic-container .upload-photo-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-weight: bold;
      font-size: 14px;
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: pointer;

    }

    .profile-pic-container img:hover+.upload-photo-text,
    .upload-photo-text:hover {
      opacity: 1;
    }

    .upload-photo-text:hover {
      color: black;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <button onclick = "admin()">Home</button>
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->

    </form>
    <button type="submit" id="logoutButton">Log out</button>
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic" class="profile-pic-container">



        <img id="avatar" src="getImageAdmin.php" onclick="handleImageUpload()">
        <div class="upload-photo-text">
          + Upload Photo
        </div>




      </div>
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
        <h2>Add New Doctor</h2>
      </div>
      <div class="container">
        <form action="adminAddNewDoctor.php" method="POST">
          <label id="test">
            <span class="labelText">Name:</span>
            <input type="text" id="doctorName" name="doctorName" oninput="autoFillDoctorPrefix()" />
          </label>

          <!-- <label id="test">
            <span class="labelText">Doctor ID:</span>
            <input type="text" id="doctorId" name="doctorId"/>
          </label> -->

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
            <input type="text" name="address">
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
<script>
  function admin(){
    window.location = "admin.php";
  }
</script>
<script>
  function autoFillDoctorPrefix() {
    var input = document.getElementById('doctorName');
    var prefix = 'Dr. ';
    if (input.value === '') {
      return; // If the input is empty, do nothing
    }
    if (input.value.indexOf(prefix) !== 0) {
      input.value = prefix + input.value;
    }
  }
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function handleImageUpload() {
    swal({
      title: "Upload Image",
      text: "Choose an image from your device",
      content: {
        element: "input",
        attributes: {
          type: "file",
          accept: "image/*"
        }
      },
      buttons: {
        confirm: {
          text: "Upload",
          closeModal: false,
          value: true,
          visible: true,
          className: "",
          closeModal: true
        },
        cancel: {
          text: "Cancel",
          value: false,
          visible: true,
          className: "",
          closeModal: true
        }
      }
    }).then((value) => {

      if (value) {
        const fileInput = document.querySelector('input[type="file"]');
        const file = fileInput.files[0];


        const allowedExtensions = ["jpg", "jpeg", "png"];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        // Check if the file extension is allowed
        if (!allowedExtensions.includes(fileExtension)) {
          swal("Error", "Only JPG, JPEG, and PNG files are allowed.", "error");
          return;
        }


        const maxSizeInBytes = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSizeInBytes) {
          swal("Warning", "Image must be less than 2MB.", "warning");
          return;
        }

        const formData = new FormData();
        formData.append('file', file);

        // Send the file to the server using fetch API
        fetch('adminAddNewDoctor.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.text())
          .then(data => {
            // Check if the response contains "Error"
            if (data.startsWith("Error")) {
              swal("Error", data, "error");
            } else {
              document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('avatar').src = data;
                // Update the avatar image src with the URL of the uploaded image

              });

              swal("Success", "Image uploaded successfully!", "success").then(() => {
                window.location = "adminAddNewDoctor.php";
              });
            }
          })
          .catch(error => {
            console.error('Error:', error);
            swal("Error", "An error occurred while uploading the image.", "error");
          });
      }

    });
  }


</script>
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

  $doctorName = $_POST['doctorName'];
  // $doctorId = $_POST['doctorId'];
  $dob = $_POST['dob'];
  $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;
  $address = $_POST['address'];
  $email = $_POST['email'];
  $specialization = $_POST['specialization'];
  $qualification = $_POST['qualification'];
  $universityCollegeCountry = $_POST['universityCollegeCountry'];


  $sqlEmailQuery = "SELECT email FROM hospital WHERE email = '$email' ";
  $resultEmail = mysqli_query($conn, $sqlEmailQuery);

  // $sqlIDQuery = "SELECT doctorID from hospital WHERE doctorID = '$doctorId'";
  // $resultID = mysqli_query($conn, $sqlIDQuery);

  if (empty($doctorName) || empty($dob) || empty($gender) || empty($address) || empty($email) || empty($specialization) || empty($qualification) || empty($universityCollegeCountry)) {
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
        window.location = "adminAddNewDoctor.php";
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
        window.location = "adminAddNewDoctor.php";
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
        window.location = "adminAddNewDoctor.php";
      });

    </script> -->
  <?php
  // }

  $last_id_query = "SELECT MAX(max_id) AS max_id FROM (
    SELECT MAX(doctorID) AS max_id FROM hospital WHERE userType = 'Doctor'
    UNION
    SELECT MAX(labTechnicianID) AS max_id FROM hospital WHERE userType = 'Lab Technician'
) AS combined_ids;
";


  $last_id_result = mysqli_query($conn, $last_id_query);
  $last_id_row = mysqli_fetch_assoc($last_id_result);
  $last_id = $last_id_row['max_id'];

  if ($last_id === "") {
    $ID = 1; // If table is empty, set ID to 1
  } else {
    $ID = $last_id + 1; // Otherwise, increment the last ID
  }


  if (count($errors) == 0) {

    $sql = "INSERT INTO hospital (name,email, doctorID, patientID, labTechnicianID, doctorSpecialization, doctorQualification, universityCollageCountry, userType) 
    VALUES ('$doctorName', '$email','$ID', NULL, NULL, '$specialization', '$qualification', '$universityCollegeCountry', 'Doctor')";

    if (mysqli_query($conn, $sql)) {
      ?>
      <script>

        swal({
          title: "Success",
          text: "New Doctor Added Successfully\nDoctor ID: <?php echo $ID ?>",
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