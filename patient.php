<?php
// session_name('patient_session');
session_start();
include 'connection.php';

if (!isset($_SESSION['patientEmail'])) {
  header('Location:index.php');

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
  header('Location: index.php');
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
  


  // $email = $_SESSION['email'];

  //for remove div from pending report section




  $sql = "SELECT * FROM hospital WHERE email = '{$patientEmail}' AND userType ='Patient'";

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


  $sqlVisits = "SELECT * FROM patientvisitdetails WHERE patientID = {$row['patientID']} ORDER BY date DESC";
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
  <link rel="stylesheet" href="style1.css">
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <!-- <a href="logout.php"><button>Log out</button></a> -->
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout1" value="1"> <!-- Hidden input to identify logout action -->
      <!-- <input type="hidden" name="session_id1" value="<?php echo $_SESSION['patient_session']; ?>"> -->
      <button type="submit" id="logoutButton">Log out</button>
    </form>

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