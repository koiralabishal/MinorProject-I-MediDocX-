<?php
session_start();
include '../../config/connection.php';

if (!isset($_SESSION['adminEmail'])) {
  header('Location: ../../index.php');
}
function logout()
{
  // Clear session data
  unset($_SESSION['adminEmail']);
  // Redirect to the login page
  header('Location: ../../index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
  logout();
}
// echo $_SESSION['adminEmail'];
if (isset($_SESSION['adminEmail'])) {

  $adminEmail = $_SESSION['adminEmail'];

  if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    // Check if the file extension is allowed
    if (in_array($file_extension, $allowed_extensions)) {
      // Establish a database connection (replace with your database credentials)
      $mysqli = new mysqli($server, $user, $pass, $database, $port);

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
  $sqlDoctorNameID = "SELECT name, doctorID FROM hospital WHERE userType = 'Doctor' ORDER BY id DESC";
  $resultDoctorNameID = mysqli_query($conn, $sqlDoctorNameID);

  $sqlTechnicianNameID = "SELECT name, labTechnicianID FROM hospital WHERE userType = 'Lab Technician' ORDER BY id DESC";
  $resultTechnicianNameID = mysqli_query($conn, $sqlTechnicianNameID);

  $sqlPatient = "SELECT name ,patientID FROM new_patient ORDER BY id DESC";
  $resultPatient = mysqli_query($conn, $sqlPatient);

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
  <title>admin</title>
  <link rel="stylesheet" href="../../assets/css/style1.css" />
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
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->

    </form>
    <button type="submit" id="logoutButton">Log out</button>
    <button onclick="addNewDoctor()">Add New Doctor</button>
    <button onclick="addNewLabTechnician()">Add New Lab Technician</button>
    <input type="text" id="searchInput" placeholder="Search ..." />
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic" class="profile-pic-container">



        <img id="avatar" src="../../api/images/getImageAdmin.php" onclick="handleImageUpload()">
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
        <h2>All Doctors</h2>
      </div>
      <!-- <div class="container"> -->
      <div class="boxContainer">
        <?php
        if ($resultDoctorNameID) {
          while ($rowDoctorNameID = mysqli_fetch_assoc($resultDoctorNameID)) {
            echo '<div class="box">';
            echo 'Name: <span class="name">' . $rowDoctorNameID['name'] . '</span><br />';
            echo 'Doctor ID: <span class = "ID" >' . $rowDoctorNameID['doctorID'] . '</span><br />';
            echo '</div>';
          }
        }
        ?>
        <!-- <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div> -->
      </div>
      <!-- </div> -->
    </section>

    <section>
      <div class="sectionTitle">
        <h2>All Lab Technicians</h2>
      </div>
      <!-- <div class="container"> -->
      <div class="boxContainer">
        <?php
        if ($resultTechnicianNameID) {
          while ($rowTechnicianNameID = mysqli_fetch_assoc($resultTechnicianNameID)) {
            echo '<div class="box">';
            echo 'Name: <span class="name">' . $rowTechnicianNameID['name'] . '</span><br />';
            echo 'Lab Technician ID: <span class="ID">' . $rowTechnicianNameID['labTechnicianID'] . '</span><br />';
            echo '</div>';
          }
        }
        ?>
        <!-- <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div> -->
      </div>
      <!-- </div> -->
    </section>

    <section>
      <div class="sectionTitle">
        <h2>All Lab Patients</h2>
      </div>
      <!-- <div class="container"> -->
      <div class="boxContainer">
        <?php

        if ($resultPatient) {
          while ($rowresultPatient = mysqli_fetch_array($resultPatient)) {
            echo '<div class="box">';
            echo 'Name: <span class="name">' . $rowresultPatient['name'] . '</span><br/>';
            echo 'Patient ID: <span class="ID"> ' . $rowresultPatient['patientID'] . '</span><br/>';
            // echo 'Ref. By: Dr.' . $rowresultPatientNameIDDoctorName['name'] . '<br/>';
            echo '</div>';
          }
        }

        ?>
        <!-- <div class="box" onclick="patient()">
            Name: Bishal Koirala <br />
            Patient ID: 21 <br />
            Referred by: Dr. Nabin Bhattarai
          </div> -->
      </div>
      <!-- </div> -->
    </section>

  </main>
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
          fetch('admin.php', {
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
                  window.location = "admin.php";
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
    document.addEventListener('DOMContentLoaded', function () {
      var searchInput = document.getElementById('searchInput');

      // Add event listener to the search input field
      searchInput.addEventListener('input', function () {
        var searchValue = searchInput.value.toLowerCase().trim(); // Get the search input value and convert to lowercase

        // Loop through all box elements and show/hide based on search input
        var boxes = document.querySelectorAll('.box');
        boxes.forEach(function (box) {
          var name = box.querySelector('.name').textContent.toLowerCase(); // Get the patient name
          var ID = box.querySelector('.ID').textContent.toLowerCase(); // Get the patient ID

          // Check if search value matches either patient name or patient ID
          if (name.includes(searchValue) || ID.includes(searchValue)) {
            box.style.display = 'block'; // Show the box
          } else {
            box.style.display = 'none'; // Hide the box
          }
        });
      });
    });
  </script>
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