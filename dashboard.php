<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("location: index.php");
  exit();
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
      <a href="logout.php"><button>Logout</button></a>
    </ul>
  </nav>

  <div id="container">
    <div class="items" id="item-1">
      <h2>Ear</h2>
      <h3>Dr. Neeraj KC</h3>
      Ear is in critical condition. Operation to be performed soon.
    </div>
    <div class="items" id="item-2">
      <h2>Eye</h2>
      <h3>Dr. Mahendra Poudel</h3>
      Eye is in fine condition. Use refresh eye drops for better maintainance
      of your eye.
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
  </div>
</body>

</html>