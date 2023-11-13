<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("location: index.php");
  exit();
}


include 'connection.php';

// Get the email of the logged-in user
$email = $_SESSION['email'];

// Query to retrieve information about the logged-in doctor
$sql = "SELECT * FROM doctor WHERE email = '{$email}'";
$result_doctor = mysqli_query($conn, $sql);

//Query to retrieve information about doctor
$sql1 = "SELECT * FROM hospital WHERE email = '{$email}'";
$result_doctor1 = mysqli_query($conn, $sql1);
// Check if the query returned a result
if (mysqli_num_rows($result_doctor) > 0) {
  // Fetch the data of the logged-in doctor
  $doctor_data = mysqli_fetch_assoc($result_doctor);
  $is_doctor = true;
} else {
  $is_doctor = false;
}

if (mysqli_num_rows($result_doctor1) > 0) {
  $doctor_data1 = mysqli_fetch_assoc($result_doctor1);
  $is_doctor1 = true;
} else {

  $is_doctor1 = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Test</title>
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    #title {
      text-align: center;
      font-size: 30px;
      font-weight: bold;
      padding: 8px;
      font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
      background-color: green;
    }

    nav {
      background-color: rgb(43, 43, 83);
      padding: 4px;
    }

    ul {
      display: flex;
      justify-content: center;
    }

    li {
      background-color: pink;
      list-style-type: none;
      font-size: 24px;
      padding: 8px 4px;
      margin: 0 4px;
      border-radius: 4%;
      cursor: pointer;
    }

    li:hover {
      box-shadow: 2px 2px grey;
      background-color: rgb(253, 160, 175);
    }

    li:active {
      box-shadow: 4px 4px grey;
      background-color: rgb(255, 134, 154);
      transform: translateX(-2px);
      transform: translateY(2px);
    }

    #container {
      background-color: silver;
      width: 80%;
      display: flex;
      margin: 48px auto;
      padding: 32px;
    }

    .items {
      background-color: bisque;
      width: 25%;
      padding: 24px;
      margin: 12px;
      cursor: pointer;
      border-radius: 2%;
    }

    .items:hover {
      box-shadow: 2px 2px grey;
      background-color: rgb(241, 241, 194);
    }

    .items:active {
      box-shadow: 4px 4px grey;
      background-color: rgb(220, 220, 160);
      transform: translateX(-4px);
      transform: translateY(4px);
    }
  </style>
</head>

<body>
  <h1 id="title">MediDocx</h1>
  <nav>
    <ul>
      <li>Home</li>
      <li>Disease</li>
      <li>Contact Us</li>
      <li>About</li>
      <li>Recommendation</li>
      <li><a href="logout.php" style="text-decoration:none; color: black;">Logout</a></li>
    </ul>
  </nav>
  <div id="container">
    <?php if ($is_doctor || $is_doctor1) { ?>


      <div class="items" id="item-1">
        <h2>
          <?php echo $doctor_data1['specialization']; ?>
        </h2>
        <h3>
          <?php echo $doctor_data['name']; ?>
        </h3>
        <?php echo $doctor_data1['description']; ?>
      </div>


    <?php } else { ?>
      <div class="items" id="item-2">
        <h2>Nose</h2>
        <h3>
          Dr. Mahendra Poudel
        </h3>
        Nose is in fine condition. Drink hot water for better maintainance
        of your nose.
      </div>
      <div class="items" id="item-3">
        <h2>Heart</h2>
        <h3>Dr. Bishal Dhoni</h3>
        Heart is functioning well. Eat less oily foods.
      </div>
      <div class="items" id="item-4">
        <h2>Kidney</h2>
        <h3>Dr. Bikram Rana</h3>
        Kidney is in critical condition. Operation to be performed soon.
      </div>
      <div class="items" id="item-5">
        <h2>Spine</h2>
        <h3>Dr. IndraRajyaLaxmi Shah</h3>
        Spine is in fine condition. Do morning and evening walks for better
        maintainance of your spine.
      </div>

    <?php } ?>

  </div>

</body>

</html>