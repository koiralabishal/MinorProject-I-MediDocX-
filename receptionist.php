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
  <title>receptionist</title>
  <link rel="stylesheet" href="style1.css" />
    <link rel="stylesheet" href="form.css">
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
      <button type="submit" id="logoutButton">Log out</button>
    </form>
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
include 'connection.php';

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