<?php
session_start();
include '../../config/connection.php';

if (!isset($_SESSION['receptionistEmail'])) {
  header('Location:../../index.php');
}

function logout()
{
  // Clear session data
  unset($_SESSION['receptionistEmail']);
  // Redirect to the login page
  header('Location: ../../index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
  logout();
}
if (isset($_SESSION['receptionistEmail'])) {
  $receptionistEmail = $_SESSION['receptionistEmail'];

  if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    // Check if the file extension is allowed
    if (in_array($file_extension, $allowed_extensions)) {
      $mysqli = $conn;


      // Get the contents of the uploaded file
      $image_data = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));

      // Prepare and execute SQL query to insert image data into the database
      $sql = "UPDATE images SET image_data = '$image_data' WHERE user_email = '$receptionistEmail'";
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

  $sqlReceptionistInfo = "SELECT * FROM receptionist WHERE receptionistEmail = '$receptionistEmail'";
  $resultReceptionistInfo = mysqli_query($conn, $sqlReceptionistInfo);

  if ($resultReceptionistInfo) {
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
  <link rel="stylesheet" href="../../assets/css/style1.css" />
  <link rel="stylesheet" href="../../assets/css/form.css">
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
    <img src="../../assets/img/MediDocX Logo.JPG" alt="" />
    <button onclick="receptionist()">Home</button>
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->

    </form>
    <button type="submit" id="logoutButton">Log out</button>
    <!-- <button onclick="addPatient()">Add Patient <i class="fa fa-search">Hi</i> </button> -->
    <!-- <input type="text" placeholder="Search Patient..." /> -->
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic" class="profile-pic-container">



        <img id="avatar" src="../../api/images/getImageReceptionist.php" onclick="handleImageUpload()">
        <div class="upload-photo-text">
          + Upload Photo
        </div>




      </div>
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
        <form id="patientForm" action="receptionistRegisterNewPatient.php" method="POST">
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
<script>
  function receptionist() {
    window.location = "receptionist.php";
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
        fetch('receptionistRegisterNewPatient.php', {
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
                window.location = "receptionistRegisterNewPatient.php";
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
// Connect to the database
include '../../config/connection.php';

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
      }).then(() => {
        window.location = "receptionistRegisterNewPatient.php";
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
      }).then(() => {
        window.location = "receptionistRegisterNewPatient.php";
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
      }).then(() => {
        window.location = "receptionistRegisterNewPatient.php";
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


  // $last_patient_id_query = "SELECT MAX(patientID) AS max_patient_id FROM new_patient";
  $last_patient_id_query = "SELECT patientID FROM new_patient ORDER BY id DESC LIMIT 1";
  $last_patient_id_result = mysqli_query($conn, $last_patient_id_query);
  $last_patient_id_row = mysqli_fetch_assoc($last_patient_id_result);
  // $last_patient_id = $last_patient_id_row['max_patient_id'];
  $last_patient_id = $last_patient_id_row['patientID'];

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