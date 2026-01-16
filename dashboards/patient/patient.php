<?php
// session_name('patient_session');
session_start();
include '../../config/connection.php';

if (!isset($_SESSION['patientEmail'])) {
  header('Location:../../index.php');

}
// $_SESSION['patient_session'] = bin2hex(random_bytes(16));
// echo $_SESSION['patient_session'];


// Logout function
// Function to handle logout
function logout()
{
  // Clear session data

  unset($_SESSION['patientEmail']);
  // session_destroy();
  // Redirect to the login page
  header('Location: ../../index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout1'])) {
  // Check if session ID matches
  logout();
}






// Generate and store a unique session identifier for this interface


if (isset($_SESSION['patientEmail'])) {
  $patientEmail = $_SESSION['patientEmail'];
  // if (isset($doctorEmail) && !is_null($doctorEmail)) {

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
      $sql = "UPDATE images SET image_data = '$image_data' WHERE user_email = '$patientEmail'";
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

  // $email = $_SESSION['email'];

  //for remove div from pending report section

  // $sqlPatient = "SELECT gender FROM patient WHERE patientEmail = '$patientEmail'";
  // $resultgender = mysqli_query($conn, $sqlPatient);

  // if ($resultgender) {
  //   $rowgender = mysqli_fetch_assoc($resultgender);
  //   $gender = strtolower($rowgender['gender']);
  //   // Define the image source based on the gender
  //   if ($gender === 'male') {
  //     $imageSrc = './Images/maleEmptyAvatar.png';
  //   } elseif ($gender === 'female') {
  //     $imageSrc = './Images/femaleEmptyAvatar.jpg';
  //   }

  // }


  // $sqlImage = "SELECT image_data FROM images WHERE user_email = '$patientEmail' ORDER BY id DESC LIMIT 1"; // Assuming you have an 'images' table with 'image_data' column
  // // $result = $mysqli->query($sql);
  // $resultImage = mysqli_query($conn, $sqlImage);

  // if ($resultImage && mysqli_num_rows($resultImage) > 0) {
  //   // Fetch the image data
  //   $row = mysqli_fetch_assoc($resultImage);
  //   $imageSrc = $row['image_data'];

  //   // Set the appropriate header for image content
  //   header("Content-type: image/jpeg"); // Change the content-type based on your image format

  //   // Output the image data
  //   echo $imageSrc;
  // } else if ($resultgender) {
  //   $rowgender = mysqli_fetch_assoc($resultgender);
  //   $gender = strtolower($rowgender['gender']);
  //   // Define the image source based on the gender
  //   if ($gender === 'male') {
  //     $imageSrc = './Images/maleEmptyAvatar.png';
  //   } elseif ($gender === 'female') {
  //     $imageSrc = './Images/femaleEmptyAvatar.jpg';
  //   }

  // }


  $sql = "SELECT * FROM new_patient WHERE email = '{$patientEmail}'";

  // var_dump($doctorEmail);
  // $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.patientID = h.patientID WHERE h.email = '{$patientEmail}' ORDER BY a.ID DESC";
  // $sql2 = "SELECT distinct patientName from test_data";
  // $sql3 = "SELECT a.* FROM patientVisitDetails a JOIN patient  JOIN hospital h on a.patientID = h.patientID WHERE h.email = '{$patientEmail}' ORDER BY a.ID DESC";


  // session_write_close();

  $result = mysqli_query($conn, $sql);
  // $result2 = mysqli_query($conn, $sql2);
  // $result3 = mysqli_query($conn, $sql3);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
  }


  // $sqlVisits = "SELECT * FROM patientvisitdetails WHERE patientID = {$row['patientID']} ORDER BY date DESC";
  $sqlVisits = "SELECT v.*, h.* FROM patientvisitdetails v JOIN hospital h on v.referredToDoctorID = h.doctorID WHERE v.patientID = {$row['patientID']} ORDER BY v.date DESC, v.visitID DESC";
  $resultVisits = mysqli_query($conn, $sqlVisits);

  $hasVisitByYear = false;
  if ($resultVisits && mysqli_num_rows($resultVisits) > 0) {

    $visitsByYear = array();
    while ($rowVisits = mysqli_fetch_assoc($resultVisits)) {
      $year = date('Y', strtotime($rowVisits['date']));
      $month = date('m', strtotime($rowVisits['date']));
      $halfYear = ($month >= 1 && $month <= 6) ? 'Jan-Jun' : 'Jul-Dec';
      $visitsByYear[$year][$halfYear][] = $rowVisits;
      $hasVisitByYear = true;
    }

    function createVisitElements($visits)
    {
      foreach ($visits as $visit) {
        echo '<div class="box">';
        echo '<a href="patientVisit.php?date=' . $visit['date'] . '&visitID=' . $visit['visitID'] . '">';
        echo 'Referred To: ' . $visit['name'] . '<br>';
        echo 'Date: ' . date('Y-m-d', strtotime($visit['date'])) . '<br>';
        echo 'Visit ID: ' . $visit['visitID'] . '<br>';
        echo '</a>';
        echo '</div>';
      }
      echo "<style>
          a{
           text-decoration:none;
           color:white;
          }
          .box:hover a {
           color: black;
          }
        </style>";
    }
  }





  //   if($result2){
//   $rowDoctorID = mysqli_fetch_assoc($result2);
// }
}
// session_start();
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>patient</title>
  <link rel="stylesheet" href="../../assets/css/style1.css">
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
    <!-- <a href="logout.php"><button>Log out</button></a> -->
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout1" value="1"> <!-- Hidden input to identify logout action -->
      <!-- <input type="hidden" name="session_id1" value="<?php echo $_SESSION['patient_session']; ?>"> -->

    </form>
    <button type="submit" id="logoutButton">Log out</button>
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic" class="profile-pic-container">



        <img id="avatar" src="../../api/images/getImagePatient.php" onclick="handleImageUpload()">
        <div class="upload-photo-text">
          + Upload Photo
        </div>




      </div>
      <div id="details">
        <b>
          <?php echo $row['name']; ?>
        </b><br />
        Patient
        <!-- <?php echo $row['userType']; ?> <br /> -->
        ID:
        <?php echo $row['patientID']; ?> <br />

      </div>
    </div>
  </aside>

  <main>
    <section>
      <div class="sectionTitle">
        <h2>Recent Visits</h2>
      </div>
      <?php if ($hasVisitByYear): ?>
        <?php foreach ($visitsByYear as $year => $halfYears): ?>
          <?php foreach ($halfYears as $halfYear => $visits): ?>
            <div class="container">
              <div class="date"><?php echo $halfYear . ' ' . $year; ?></div>
              <div class="boxContainer">
                <?php createVisitElements($visits); ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </main>

  <script>
    function visit() {
      window.location.href = "PatientVisit.php";
    }

  </script>
</body>
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
        fetch('patient.php', {
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
                window.location = "patient.php";
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