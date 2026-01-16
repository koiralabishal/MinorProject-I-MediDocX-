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
// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
  // Include your database connection file

  if ($_POST['action'] === 'fetchPatientName') {
    // Fetch patient name based on patient ID
    $patientId = $_POST['patientId'];
    $sql = "SELECT name FROM new_patient WHERE patientID = '$patientId'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      echo $row['name'];
    }
    exit(); // Exit the script after echoing the patient's name
  }

  if ($_POST['action'] === 'fetchDoctorName') {
    // Fetch doctor name based on doctor ID
    $doctorId = $_POST['doctorId'];
    // Assume you have a table named 'hospital' with doctor details
    $sql = "SELECT name FROM hospital WHERE doctorID = '$doctorId' AND userType = 'Doctor'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      echo $row['name'];
    }
    exit(); // Exit the script after echoing the doctor's name
  }

}

if (isset($_SESSION['receptionistEmail'])) {
  $receptionistEmail = $_SESSION['receptionistEmail'];

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
  <title>receptionist</title>
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
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->

    </form>
    <button type="submit" id="logoutButton">Log out </button>

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
        <h2>Appoint Patient</h2>

        <button onclick="registerNewPatient()">Add new patient</button>
      </div>
      <div class="container">
        <form id="appointForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <label id="test">
            <span class="labelText">Patient Id:</span>
            <input type="text" id="patientId" name="patientId" />
          </label>
          <label>
            <span class="labelText">Patient Name:</span>
            <span class="inputName" id="patientName" name="patientName"></span>
          </label>
          <label>
            <span class="labelText">Ref. Doctor Id:</span>
            <input type="text" id="doctorId" name="doctorId" />
          </label>
          <label>
            <span class="labelText">Ref. Doctor Name:</span>
            <span class="inputName" id="doctorName" name="doctorName"></span>
          </label>
          <label>
            <span class="labelText">Date:</span>
            <input type="datetime-local" name="appointmentDate">
          </label>
          <label>
            <button type="submit" id="appointBtn" name="submit">Appoint</button>
          </label>
        </form>
      </div>
    </section>
  </main>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
          fetch('receptionist.php', {
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
                  window.location = "receptionist.php";
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>

    // $(document).ready(function () {
    //   // Handle form submission
    //   $('#appointBtn').on('click', function (e) {
    //     event.preventDefault(); // Prevent the default form submission
    //     var formData = $('#appointForm').serialize(); // Serialize form data
    //     $.ajax({
    //       type: 'POST',
    //       url: '<?php echo $_SERVER['PHP_SELF']; ?>',
    //       data: formData, // Send serialized form data
    //       dataType: 'json', // Expect JSON response
    //       success: function (response) {
    //         if (response.status === 'success') {
    //           swal({
    //             title: "Success",
    //             text: response.message,
    //             icon: "success",
    //             button: "Ok",
    //           });
    //         } else {
    //           swal({
    //             title: "Error",
    //             text: response.message,
    //             icon: "error",
    //             button: "Ok",
    //           });
    //         }
    //       },
    //       error: function () {
    //         swal({
    //           title: "Error",
    //           text: "Failed to make an appointment. Please try again later.",
    //           icon: "error",
    //           button: "Ok",
    //         });
    //       }
    //     });
    //   });
    // });

    $(document).ready(function () {
      // Fetch patient name based on patient ID
      $('#patientId').on('change', function () {
        var patientId = $(this).val();
        $.ajax({
          type: 'POST',
          url: '<?php echo $_SERVER['PHP_SELF']; ?>',
          data: { action: 'fetchPatientName', patientId: patientId },
          success: function (response) {
            $('#patientName').text(response);
          }
        });
      });

      // Fetch doctor name based on doctor ID
      $('#doctorId').on('change', function () {
        var doctorId = $(this).val();
        $.ajax({
          type: 'POST',
          url: '<?php echo $_SERVER['PHP_SELF']; ?>',
          data: { action: 'fetchDoctorName', doctorId: doctorId },
          success: function (response) {
            $('#doctorName').text(response);
          }
        });
      });
    });

    function registerNewPatient() {
      window.location.href = "receptionistRegisterNewPatient.php";
    }
  </script>
</body>

</html>

<?php
include '../../config/connection.php';

// Handle form submission
if (isset($_POST['submit'])) {
  $patientId = $_POST['patientId'];
  $doctorId = $_POST['doctorId'];
  $appointmentDate = $_POST['appointmentDate'];

  // Check if any field is empty
  if (empty($patientId) || empty($doctorId) || empty($appointmentDate)) {
    ?>
    <script>
      swal({
        title: "Error",
        text: "All fields are required",
        icon: "error",
        button: "Ok",
      }).then(() => {
        window.location = "receptionist.php";
      });
    </script>
    <?php
  } else {
    // Fetch patient details
    $sqlAge = "SELECT dob, gender, name FROM new_patient WHERE patientID = '$patientId'";
    $resultAge = mysqli_query($conn, $sqlAge);
    if ($resultAge && mysqli_num_rows($resultAge) > 0) {
      $row = mysqli_fetch_assoc($resultAge);
      $dob = $row['dob'];
      $gender = $row['gender'];
      $age = date_diff(date_create($dob), date_create($appointmentDate))->y;
      $patientName = $row['name'];

      // $dobDateTime = new DateTime($dob);
      // $appointmentDateTime = new DateTime($appointmentDate);
      // $ageInterval = $dobDateTime->diff($appointmentDateTime);
      // $age = $ageInterval->y;
      // Fetch the last visit ID
      $last_visit_id_query = "SELECT MAX(visitID) AS max_visit_id FROM patientvisitdetails";
      $last_visit_id_result = mysqli_query($conn, $last_visit_id_query);
      $last_visit_id_row = mysqli_fetch_assoc($last_visit_id_result);
      $last_visit_id = $last_visit_id_row['max_visit_id'];

      if ($last_visit_id === null) {
        $visitID = 1; // If table is empty, set visit ID to 1
      } else {
        $visitID = $last_visit_id + 1; // Otherwise, increment the last visit ID
      }

      // Insert data into the appointed_patient table
      $sql = "INSERT INTO appointed_patient (patientId, patientName, age, gender, doctorId, visitID, date) 
                    VALUES ('$patientId', '$patientName', '$age','$gender', '$doctorId', '$visitID', '$appointmentDate')";
      if (mysqli_query($conn, $sql)) {
        ?>
        <script>
          swal({
            title: "Success",
            text: "Appointment Successful",
            icon: "success",
            button: "Ok",
          });
        </script>
        <?php
      } else {
        ?>
        <script>
          swal({
            title: "Error",
            text: "Failed to make an appointment",
            icon: "error",
            button: "Ok",
          }).then(() => {
            window.location = "receptionist.php";
          });
        </script>
        <?php
      }
    } else {
      ?>
      <script>
        swal({
          title: "Error",
          text: "Patient not found",
          icon: "error",
          button: "Ok",
        });
      </script>
      <?php
    }
  }
}
?>