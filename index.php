<?php
session_start();


include 'connection.php';


if (isset($_GET['email']) && isset($_GET['v_code'])) {
  // $sql = "SELECT * FROM patient WHERE email = '$_GET[email]' AND verificationCode = '$_GET[v_code]'";
  $sql = "SELECT * FROM patient WHERE email = '$_GET[email]' AND verificationCode = '$_GET[v_code]'";
  $sql1 = "SELECT * FROM doctor WHERE email = '$_GET[email]' AND verificationCode = '$_GET[v_code]'";

  $result = mysqli_query($conn, $sql);
  $result1 = mysqli_query($conn, $sql1);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['isVerified'] == 0) {
      $update = "UPDATE patient SET isVerified = 1 WHERE email = '$row[email]'";
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
      $update1 = "UPDATE doctor SET isVerified = 1 WHERE email = '$row[email]'";
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
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      /* font-size: 2vw; */
    }

    body {
      background-color: azure;
    }

    #overlay {
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background-color: rgba(0, 0, 0, 0.6);
      opacity: 0;
      transition: opacity 0.4s ease-in-out;
      z-index: 11;
      pointer-events: none;
    }

    #title {
      background-color: lightblue;
      width: 100%;
      height: auto;
      padding: 1vh;
      display: flex;
      justify-content: space-around;
    }

    #invisibleDiv {
      flex: 0 2 30vw;
      /* background-color: blueviolet; */
    }

    #titleText {
      /* background-color: green; */
      flex: 0 0 30vw;
      padding: 1%;
      text-align: center;
      font-size: 1.5rem;
      color: rgb(38, 43, 39);
    }

    /* @media only screen and (max-width: 640px) {
        #invisibleDiv {
          display: none;
        }

        #titleText {
        }
      }

      @media only screen and (max-width: 320px) {
        #title {
          flex-direction: column;
        }
      } */

    #titleButtons {
      /* background-color: pink; */
      flex: 0 0 30vw;
      display: flex;
      justify-content: space-evenly;
      padding: 1%;
    }

    #titleButtons button {
      background-color: rgb(56, 169, 56);
      border-radius: 12px;
      border: none;
      flex: 0 0 auto;
      padding: 2% 6%;
      font: 1.2rem Arial;
      color: white;
      box-shadow: 0px 4px 4px rgb(186, 248, 186) inset, 1px 2px 4px darkgrey;
      cursor: pointer;
    }

    #titleButtons :nth-child(1) {
      background-color: transparent;
      padding: 0px;
      flex: 0 2 8%;
      box-shadow: 0px 0px;
    }

    #loginForm {
      width: 36vw;
      background-color: rgb(232, 232, 252);
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      margin: 4vh auto;
      padding: 2%;
      border-radius: 8px;
      box-shadow: 2px 2px 8px 4px silver;
      z-index: 12;
      transform: scale(0);
      transition: all .2s ease-in-out;
    }

    #loginForm h1 {
      text-align: center;
      font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
      font-weight: lighter;
    }

    #loginForm label {
      display: block;
      margin: 6%;
    }

    #loginForm h3 {
      font-weight: lighter;
      font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
      color: rgb(38, 38, 38);
      margin: 1%;
    }

    #loginForm input {
      width: 100%;
      /* height: 16px; */
      margin-top: 2%;
      border: none;
      background-color: transparent;
      border-bottom: 1px solid rgb(38, 38, 38);
    }

    #loginForm #forgetPwd {
      margin-top: -2%;
      margin-left: 6%;
      color: rgb(52, 84, 125);
      cursor: pointer;
    }

    #loginForm #checkboxLabel {
      margin-top: 1%;
      color: rgba(0, 0, 0, 0.78);
    }

    #loginForm #checkbox {
      width: auto;
      margin-right: 2%;
    }

    #loginForm button {
      background-color: rgb(48, 48, 220);
      padding: 2% 6%;
      border-radius: 8px;
      border: none;
      color: white;
      font-size: 1.2rem;
      display: block;
      margin: auto auto;
      margin-top: -2%;
      box-shadow: 0px 4px 4px rgb(170, 170, 226) inset;
      cursor: pointer;
    }

    #loginForm #signUp {
      margin: 0 6%;
      margin-top: 4%;
    }

    #loginForm #signUp a {
      color: rgb(52, 84, 125);
      text-decoration: none;
    }

    #loginForm #closeLogin {
      position: absolute;
      width: 6%;
      top: 2%;
      right: 2%;
      cursor: pointer;
    }

    #signupForm {
      width: 36vw;
      background-color: rgb(232, 232, 252);
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      margin: 4vh auto;
      padding: 2%;
      padding-top: 0;
      border-radius: 8px;
      box-shadow: 2px 2px 8px 4px silver;
      z-index: 12;
      transform: scale(0);
      transition: all .2s ease-in-out;
    }

    #signupForm h1 {
      font-size: 28px;
      text-align: center;
      font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
      font-weight: lighter;
    }

    #signupForm label {
      display: block;
      margin: 6%;
    }

    #signupForm h3 {
      font-size: 14px;
      font-weight: lighter;
      font-family: Arial, Helvetica, sans-serif;
      /* font-family: sans-serif; */
      color: rgb(38, 38, 38);
      margin: 1%;
    }

    #signupForm input {
      font-size: 1rem;
      color: rgb(38, 38, 38);
      width: 100%;
      /* height: 16px; */
      margin-top: 2%;
      text-indent: 1%;
      border: none;
      outline: none;
      background-color: transparent;
      border-bottom: 1px solid silver;
    }

    #signupForm #radioLabel {
      margin-top: 1%;
      color: rgba(0, 0, 0, 0.78);
    }

    #signupForm #radioLabel .radioButtonLabel {
      display: inline;
    }

    #signupForm .radio {
      width: auto;
      margin-right: 2%;
    }

    /* Dropdown container */
    .custom-dropdown {
      position: relative;
      width: 200px;
      font-family: Arial, sans-serif;
    }

    /* Dropdown button */
    .dropdown-button {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      background-color: #fff;
      color: #333;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
    }

    /* Dropdown arrow icon */
    .dropdown-icon::after {
      content: "\25BC";
      /* Unicode character for down arrow */
    }

    /* Dropdown options container */
    .dropdown-options {
      display: none;
      position: absolute;
      width: 100%;
      max-height: 200px;
      overflow-y: auto;
      border: 1px solid #ccc;
      border-top: none;
      border-radius: 0 0 4px 4px;
      background-color: #fff;
    }

    /* Individual dropdown option */
    .dropdown-option {
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .dropdown-option:hover {
      background-color: #f0f0f0;
    }

    /* Show the options when the dropdown button is clicked */
    .custom-dropdown.active .dropdown-options {
      display: block;
    }

    #signupForm #doctorID {
      display: none;
    }

    #signupForm button {
      background-color: rgb(48, 48, 220);
      padding: 2% 6%;
      border-radius: 8px;
      border: none;
      color: white;
      font-size: 1.2rem;
      display: block;
      margin: auto auto;
      margin-top: -2%;
      box-shadow: 0px 4px 4px rgb(170, 170, 226) inset;
      cursor: pointer;
    }

    #signupForm .justText {
      margin: 4% 6%;
      /* margin-top: 4%; */
      /* background-color: red; */
      color: #333;
      font-family: sans-serif;
      font-size: 0.8rem;
    }

    #signupForm .justText a {
      color: rgb(52, 84, 125);
      text-decoration: none;
    }

    #signupForm #closeSignup {
      position: absolute;
      width: 6%;
      top: 2%;
      right: 2%;
      cursor: pointer;
    }
  </style>
</head>

<body>
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
  <?php include "./loginForm.php" ?>
  <?php include "./signupForm.php" ?>
</body>
<script src="./script.js"></script>
</html>