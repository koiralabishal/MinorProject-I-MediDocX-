<?php
session_start();


include 'config/connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("./PHPMailer/PHPMailer.php");
require("./PHPMailer/SMTP.php");
require("./PHPMailer/Exception.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['verifyotp'])) {
    // Verify OTP
    $otp = $_POST['emailotp'];
    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $otp) {
      $hashedOTP = md5($_SESSION['otp']);
      $sqlReceptionistUpdateQuery = "UPDATE receptionist SET isVerified = 1, verificationCode = '$hashedOTP' WHERE receptionistEmail = '{$_SESSION['userEmail']}'";
      if (mysqli_query($conn, $sqlReceptionistUpdateQuery)) {
        echo json_encode(['success' => true]);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
    }
    exit;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['send_otp'])) {
    // Get email from POST data
    $email = $_POST['email'];


    // SQL query to check if email exists in the database
    // $sqlEmailQuery = "SELECT email FROM user WHERE email = '$email'";
    $sqlEmailQuery = "SELECT 'patient' AS tableName, 'patientEmail' AS emailAttr FROM patient WHERE patientEmail = '$email' 
    UNION ALL 
    SELECT 'doctor' AS tableName, 'doctorEmail' AS emailAttr FROM doctor WHERE doctorEmail = '$email' 
    UNION ALL 
    SELECT 'lab_technician' AS tableName, 'technicianEmail' AS emailAttr FROM lab_technician WHERE technicianEmail = '$email'
    UNION ALL 
    SELECT 'receptionist' AS tableName, 'receptionistEmail' AS emailAttr FROM receptionist WHERE receptionistEmail = '$email'
    UNION ALL 
    SELECT 'admins' AS tableName, 'adminEmail' AS emailAttr FROM admins WHERE adminEmail = '$email'";
    ;

    // Execute the query
    $resultEmail = mysqli_query($conn, $sqlEmailQuery);

    // Check for errors in the query execution
    if (!$resultEmail) {
      echo json_encode(['success' => false, 'message' => 'Query execution error: ' . mysqli_error($conn)]);
      exit;
    }


    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['success' => false, 'message' => 'Invalid email format']);
      exit;
    }

    // Check if email exists in the database
    if (mysqli_num_rows($resultEmail) > 0) {
      $row = mysqli_fetch_assoc($resultEmail);
      $tableName = $row['tableName'];
      // echo $tableName;
      $emailAttr = $row['emailAttr'];
      // echo $emailAttr;
      $_SESSION['tableName'] = $tableName;
      $_SESSION['emailAttr'] = $emailAttr;

      // Email exists, proceed with sending OTP
      $otp = rand(100000, 999999);
      $subject = 'Your OTP for password reset';
      $message = '<div style="font-size: 25px;">Your OTP is: <strong>' . $otp . '</strong></div>';

      // Initialize PHPMailer
      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USER') ?: 'koiralabishal3@gmail.com';
        $mail->Password = getenv('SMTP_PASS') ?: 'rtvxlvouimebormx';
        $mail->SMTPSecure = getenv('SMTP_SECURE') ?: 'tls';
        $mail->Port = getenv('SMTP_PORT') ?: 587;

        $mail->setFrom(getenv('SMTP_USER') ?: 'koiralabishal3@gmail.com', 'MediDocX');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send email
        $mail->send();

        // Store OTP and user email in session
        $_SESSION['otp'] = $otp;
        $_SESSION['userEmail'] = $email;

        echo json_encode(['success' => true]);
        exit;
      } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
        exit;
      }
    } else {
      // Email does not exist in the database
      echo json_encode(['success' => false, 'message' => 'Email does not exist']);
      exit;
    }

  } elseif (isset($_POST['verify_otp'])) {
    // Verify OTP
    $otp = $_POST['otp'];
    if ($_SESSION['otp'] == $otp) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
    }
    exit;
  } elseif (isset($_POST['change_password'])) {
    // Update password
    $newPassword = md5($_POST['new_password']);
    // SQL query to update password
    $sqlUpdateQuery = "UPDATE {$_SESSION['tableName']} SET password = '$newPassword' WHERE {$_SESSION['emailAttr']} = '{$_SESSION['userEmail']}'";
    $resultUpdate = mysqli_query($conn, $sqlUpdateQuery);


    if ($resultUpdate) {
      echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
      exit;
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to update password']);
      exit;
    }

  }
}

if (isset($_GET['email']) && isset($_GET['v_code'])) {
  // $sql = "SELECT * FROM patient WHERE email = '$_GET[email]' AND verificationCode = '$_GET[v_code]'";
  $sql = "SELECT * FROM patient WHERE patientEmail = '$_GET[email]' AND verificationCode = '$_GET[v_code]'";
  $sql1 = "SELECT * FROM doctor WHERE doctorEmail = '$_GET[email]' AND verificationCode = '$_GET[v_code]'";
  $sql2 = "SELECT * FROM lab_technician WHERE technicianEmail = '$_GET[email]' AND verificationCode = '$_GET[v_code]'";

  $result = mysqli_query($conn, $sql);
  $result1 = mysqli_query($conn, $sql1);
  $result2 = mysqli_query($conn, $sql2);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['isVerified'] == 0) {
      $update = "UPDATE patient SET isVerified = 1 WHERE patientEmail = '$row[patientEmail]'";
      // $update1 = "UPDATE doctor SET isVerified = 1 WHERE email = '$row[email]'";
      if (mysqli_query($conn, $update)) {
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Email Verification</title>
          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        </head>

        <body>

          <script>

            swal({
              title: "Success",
              text: "Email verification successful",
              icon: "success",
              button: "Ok",
            }).then(function () {
              window.location = "index.php"; // Redirect to index.php after OK button is clicked.
            });

          </script>
        </body>

        </html>
        <?php
      }
    } else {
      ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Verification</title>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      </head>

      <body>
        <script>

          swal({
            title: "Warning",
            text: "Email is already verified",
            icon: "warning",
            button: "Ok",
          }).then(function () {
            window.location = "index.php"; // Redirect to index.php after OK button is clicked.
          });


        </script>
      </body>

      </html>
      <?php
    }
  } else if (mysqli_num_rows($result1) > 0) {
    $row = mysqli_fetch_assoc($result1);
    if ($row['isVerified'] == 0) {
      // $update = "UPDATE patient SET isVerified = 1 WHERE email = '$row[email]'";
      $update1 = "UPDATE doctor SET isVerified = 1 WHERE doctorEmail = '$row[doctorEmail]'";
      if (mysqli_query($conn, $update1)) {
        ?>

          <!DOCTYPE html>
          <html lang="en">

          <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Email Verification</title>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
          </head>

          <body>

            <script>

              swal({
                title: "Success",
                text: "Email verification successful",
                icon: "success",
                button: "Ok",
              }).then(function () {
                window.location = "index.php"; // Redirect to index.php after OK button is clicked.
              });

            </script>
          </body>

          </html>
        <?php
      }
    } else {
      ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Email Verification</title>
          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        </head>

        <body>
          <script>

            swal({
              title: "Warning",
              text: "Email is already verified",
              icon: "warning",
              button: "Ok",
            }).then(function () {
              window.location = "index.php";  // Redirect to index.php after OK button is clicked.

            });


          </script>

        </body>

        </html>
      <?php
    }
  } else if (mysqli_num_rows($result2) > 0) {
    $row = mysqli_fetch_assoc($result2);
    if ($row['isVerified'] == 0) {
      // $update = "UPDATE patient SET isVerified = 1 WHERE email = '$row[email]'";
      $update2 = "UPDATE lab_technician SET isVerified = 1 WHERE technicianEmail = '$row[technicianEmail]'";
      if (mysqli_query($conn, $update2)) {
        ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Email Verification</title>
              <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            </head>

            <body>

              <script>

                swal({
                  title: "Success",
                  text: "Email verification successful",
                  icon: "success",
                  button: "Ok",
                }).then(function () {
                  window.location = "index.php"; // Redirect to index.php after OK button is clicked.
                });

              </script>
            </body>

            </html>
        <?php
      }
    } else {
      ?>
          <!DOCTYPE html>
          <html lang="en">

          <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Email Verification</title>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
          </head>

          <body>
            <script>



              swal({
                title: "Warning",
                text: "Email is already verified",
                icon: "warning",
                button: "Ok",
              }).then(function () {
                window.location = "index.php";  // Redirect to index.php after OK button is clicked.




              });


            </script>

          </body>

          </html>
      <?php
    }
  } else {
    ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Email Verification</title>
          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        </head>

        <body>
          <script>

            swal({
              title: "Warning",
              text: "No data found!",
              icon: "warning",
              button: "Ok",
            }).then(function () {
              window.location = "index.php"; // Redirect to index.php after OK button is clicked.
            });
          </script>
        </body>

        </html>
    <?php
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MedidocX</title>
  <link rel="stylesheet" href="assets/css/indexForm.css" />
  <link rel="stylesheet" href="assets/css/index2.css" />
</head>

<body>
  <?php include "auth/loginForm.php" ?>
  <?php include "auth/signupForm.php" ?>
  <div id="overlay"></div>
  <nav id="title">
    <div id="invisibleDiv"></div>
    <div id="titleText">
      <h1>MediDocX</h1>

    </div>

    <div id="titleButtons">
      <button></button>
      <button id="loginBtn">Log In</button>
      <button id="signupBtn">Sign Up</button>
    </div>
  </nav>
  <main>
    <section>
      <article>
        <div class="indexImage">
          <img src="assets/img/2.jpg" alt="MediDocX Hero Image" style="width: 100%; height: 100%; border-radius: 24px; object-fit: cover;">
        </div>
      </article>
      <article>
        <h1>MediDocX</h1>
        <p>
          Welcome to MediDocX, your comprehensive healthcare management
          solution. At MediDocX, we are committed to revolutionizing
          healthcare by providing seamless coordination between patients,
          doctors, lab technicians, receptionists, and administrators. Our
          user-friendly interfaces cater to every aspect of healthcare
          delivery, from patient appointments and medical records to
          laboratory tests and administrative tasks. With MediDocX, healthcare
          professionals can streamline their workflows, enhance patient care,
          and ensure efficient communication across all levels of the
          healthcare system. Join us in shaping the future of healthcare
          management with MediDocX.
        </p>
      </article>
    </section>

    <section id="ourServices">
      <h2>Our Services</h2>
      <article>
        <div class="ourServices">
          <h3>Patient Appointments</h3>
          <p>
            Schedule appointments conveniently online, ensuring efficient use
            of time and resources for both patients and healthcare providers.
          </p>
        </div>
        <div class="ourServices">
          <h3>Medical Record Management</h3>
          <p>
            Securely store and manage patient medical records electronically,
            enabling easy access and retrieval when needed for accurate
            diagnosis and treatment.
          </p>
        </div>
        <div class="ourServices">
          <h3>Laboratory Tests</h3>
          <p>
            Facilitate laboratory test requests, tracking, and reporting,
            streamlining the diagnostic process and ensuring timely results
            for informed decision-making.
          </p>
        </div>
        <div class="ourServices">
          <h3>Prescription Management</h3>
          <p>
            Manage prescriptions electronically, from initial prescription to
            refill requests, promoting medication adherence and reducing
            errors.
          </p>
        </div>
        <div class="ourServices">
          <h3>Healthcare Professional Coordination</h3>
          <p>
            Foster seamless communication and collaboration among healthcare
            professionals, enhancing patient care outcomes and treatment
            planning.
          </p>
        </div>
      </article>
    </section>


</body>
<script src="scripts/script.php"></script>

</html>