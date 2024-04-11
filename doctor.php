<?php
session_start();

if (!isset($_SESSION['doctorEmail'])) {
  header('Location:index.php');

}

if (isset($_SESSION['doctorEmail'])) {
  $doctorEmail = $_SESSION['doctorEmail'];
  // if (isset($doctorEmail) && !is_null($doctorEmail)) {
  include 'connection.php';

  // $email = $_SESSION['email'];

  //for remove div from pending report section




  $sql = "SELECT * FROM hospital WHERE email = '{$doctorEmail}' AND userType ='Doctor'";

  // var_dump($doctorEmail);
  $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$doctorEmail}' ORDER BY a.ID DESC";
  // $sql2 = "SELECT distinct patientName from test_data";
  $sql3 = "SELECT a.* FROM patientVisitDetails a JOIN patient  JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$doctorEmail}' ORDER BY a.ID DESC";


  // session_write_close();

  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  $result3 = mysqli_query($conn, $sql3);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
  }


  $sqlVisits = "SELECT distinct p.patientID, p.date, p.reportID,p.doctorID  FROM pendingReport p JOIN report r on p.doctorID = r.doctorID   WHERE r.resultValue = '' AND r.flag = '' ORDER BY p.date DESC";
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
        echo '<a href="doctorPatientVisit.php?date=' . $visit['date'] . '">';
        echo 'Date: ' . date('Y-m-d', strtotime($visit['date'])) . '<br>';
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
  <title>doctor</title>
  <link rel="stylesheet" href="style1.css" />
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <a href="logout.php"><button>Log out</button></a>

    <input type="text" placeholder="Search Patient..." />
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic"></div>
      <div id="details">
        <b>
          <?php echo $row['name']; ?>
        </b><br />
        <?php echo $row['userType']; ?> <br />
        ID:
        <?php echo $row['doctorID']; ?> <br />
        <?php echo $row['doctorQualification']; ?> <br />

        (
        <?php echo $row['universityCollageCountry']; ?>)
      </div>
    </div>
  </aside>

  <main>
    <section>
      <div class="sectionTitle">
        <h2>Appointed Patients</h2>
      </div>
      <!-- <div class="container"> -->
      <div class="boxContainer">
        <?php

        if ($result2) {

          while ($row2 = mysqli_fetch_array($result2)) {

            echo '<div class="box" >';
            echo '<a href="doctorPatient.php?patientID=' . $row2['patientID'] . '&patientName=' . $row2['patientName'] . '&gender=' . $row2['gender'] . '&age=' . $row2['age'] . '&visitID=' . $row2['visitID'] . '">';
            echo "Name: " . $row2['patientName'] . "</br >";
            echo "Patient ID: " . $row2['patientID'] . "<br />";
            echo "</a>";
            echo " </div>";
          }
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
        ?>
      </div>
      <!-- </div> -->
    </section>

    <section>
      <div class="sectionTitle">
        <h2>Pending Reports</h2>
      </div>
      <!-- <?php if ($hasJanJunVisits): ?>
            <div class="container">
                <div class="date">Jan-Jun</div>
                <div class="boxContainer">
                <?php createVisitElements($janJunVisits); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($hasJulDecVisits): ?>
            <div class="container">
                <div class="date">Jul-Dec</div>
                <div class="boxContainer">
                <?php createVisitElements($julDecVisits); ?>
                </div>
            </div>
            <?php endif; ?> -->
      <?php if ($hasVisitByYear): ?>
        <?php foreach ($visitsByYear as $year => $halfYears): ?>
          <?php foreach ($halfYears as $halfYear => $visits): ?>
            <div class="container">
              <div class="date">
                <?php echo $halfYear . ' ' . $year; ?>
              </div>
              <div class="boxContainer">
                <?php createVisitElements($visits); ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php endif; ?>


      </div>
    </section>
  </main>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>

</html>