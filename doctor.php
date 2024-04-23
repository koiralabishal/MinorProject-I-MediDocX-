<?php
// session_name('doctor_session');
session_start();
include 'connection.php';

if (!isset($_SESSION['doctorEmail'])) {
  header('Location:index.php');

}

// $_SESSION['doctor_session'] = bin2hex(random_bytes(16));
// echo $_SESSION['doctor_session'];


// Function to handle logout
function logout()
{
  // Clear session data
  unset($_SESSION['doctorEmail']);
  // Redirect to the login page
  header('Location: index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
  logout();
}




if (isset($_SESSION['doctorEmail'])) {
  $doctorEmail = $_SESSION['doctorEmail'];
  // if (isset($doctorEmail) && !is_null($doctorEmail)) {


  // $email = $_SESSION['email'];

  //for remove div from pending report section




  $sql = "SELECT * FROM hospital WHERE email = '{$doctorEmail}' 
  AND userType ='Doctor'
  ";

  // var_dump($doctorEmail);
  $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$doctorEmail}' ORDER BY a.ID DESC";
  // $sql2 = "SELECT distinct patientName from test_data";
  $sql3 = "SELECT a.* FROM patientvisitdetails a  JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$doctorEmail}' ORDER BY a.ID DESC";


  // session_write_close();

  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  $result3 = mysqli_query($conn, $sql3);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
  }




  $sqlVisits = "SELECT  distinct p.patientID, p.date, p.reportID,p.doctorID , p.visitID, n.name FROM pendingreport p JOIN report r on r.doctorID = p.doctorID JOIN new_patient n ON r.patientID = n.patientID  WHERE r.resultValue = '' AND r.flag = '' AND r.doctorID = '{$row['doctorID']}'  ORDER BY p.date DESC, p.visitID DESC";
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
        // $patientName = "SELECT patientName FROM patientVisitDetails WHERE `visitID = '{$visit['visitID']}' AND date = '{$visit['date']}'";
        // $resultPatientName = mysqli_query($conn, $patientName);
        // if($resultPatientName){
        //   $rowPatientName = mysqli_fetch_array($resultPatientName);

        // }

        echo '<div class="box" id = "report" data-visit-id="' . htmlspecialchars($visit['visitID']) . '" data-date="' . htmlspecialchars($visit['date']) . '">';
        // echo '<div class="box">';
        // echo '<a href="doctorPatientVisit.php?date=' . $visit['date'] . '&visitID=' . $visit['visitID'] . '">';
        echo 'Patient Name: <span class="patientName"' . $visit['name']. '</span><br>';
        echo 'Patient ID: <span class="patientID"' . $visit['patientID'] . '</span><br>';
        // echo 'Visit ID: ' . $visit['visitID'] . '<br>';
        echo 'Date: ' . date('Y-m-d', strtotime($visit['date'])) . '<br>';
        // echo '</a>';
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
    //   } else {
//     $visitsByYear = array();
//     while ($rowVisits = mysqli_fetch_assoc($resultVisits)) {
//       $year = date('Y', strtotime($rowVisits['date']));
//       $month = date('m', strtotime($rowVisits['date']));
//       $halfYear = ($month >= 1 && $month <= 6) ? 'Jan-Jun' : 'Jul-Dec';
//       $visitsByYear[$year][$halfYear][] = $rowVisits;
//       $hasVisitByYear = true;
//     }

    //     function createVisitElements($visits)
//     {

    //       foreach ($visits as $visit) {
//         $patientName = "SELECT patientName FROM patientVisitDetails WHERE `visitID = '{$visit['visitID']}' AND date = '{$visit['date']}'";
//         $resultPatientName = mysqli_query($conn, $patientName);

    // ;
//         echo '<div class="box">';
//         echo '<a href="doctorPatientVisit.php?date=' . $visit['date'] . '&visitID=' . $visit['visitID'] . '">';
//         // echo 'Patient Name: ' . $visit['patientName'] . '<br>';
//         echo 'Patient ID: ' . $visit['patientID'] . '<br>';
//         // echo 'Visit ID: ' . $visit['visitID'] . '<br>';
//         echo 'Date: ' . date('Y-m-d', strtotime($visit['date'])) . '<br>';
//         echo '</a>';
//         echo '</div>';
//       }
//       echo "<style>
//           a{
//            text-decoration:none;
//            color:white;
//           }
//           .box:hover a {
//            color: black;
//           }
//         </style>";
//     }
//   }





    //   if($result2){
//   $rowDoctorID = mysqli_fetch_assoc($result2);
// }
  }
}
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   // Get the JSON data from the request body
//   $data = json_decode(file_get_contents('php://input'), true);

//   // Check if the data contains patientID and patientName (from Appointed Patients section)
//   if (isset($data['patientID']) && isset($data['patientName'])) {
//     $_SESSION['patientID'] = $data['patientID'];
//     $_SESSION['patientName'] = $data['patientName'];
//     $_SESSION['patientAge'] = $data['patientAge'];
//     $_SESSION['patientGender'] = $data['patientGender'];
//     $_SESSION['visitID'] = $data['visitID'];
//   }
//   // Check if the data contains visitID and date (from Pending Reports section)
//   elseif (isset($data['visitID']) && isset($data['date'])) {
//     $_SESSION['visitid'] = $data['visitID'];
//     $_SESSION['date1'] = $data['date'];
//   }

//   // Send success response
//   http_response_code(200);
//   exit;
// }
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   // Get the JSON data from the request body
//   $data = json_decode(file_get_contents('php://input'), true);

//   // Check if patient data is received
//   if (isset($data['patientData'])) {
//     // Store patient data in the PHP session
//     $_SESSION['patientID'] = $data['patientID'];
//     $_SESSION['patientName'] = $data['patientName'];
//     $_SESSION['patientAge'] = $data['patientAge'];
//     $_SESSION['date'] = $data['date'];
//     $_SESSION['visitID'] = $data['visitID'];
//     // Send success response
//     http_response_code(200);
//     exit;
//   }

//   // Check if visit data is received
//   if (isset($data['visitData'])) {
//     // Store visit data in the PHP session
//     $_SESSION['date_visit'] = $data['date_visit'];
//     $_SESSION['visitid'] = $data['visitid'];
//     // Send success response
//     http_response_code(200);
//     exit;
//   }
// }



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
    <!-- <a href="logout.php"><button>Log out</button></a> -->
    <!-- <button id="logoutBtn">Log out</button> -->
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
      <!-- <input type="hidden" name="session_id" value="<?php echo $_SESSION['doctor_session']; ?>"> -->
      <button type="submit" id="logoutButton">Log out</button>
    </form>

    <input type="text" id="searchInput" placeholder="Search Patient..." />

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

            echo '<div class="box" id = "patient" data-patient-id="' . htmlspecialchars($row2['patientID']) . '" data-patient-name="' . htmlspecialchars($row2['patientName']) . '" data-patient-age="' . htmlspecialchars($row2['age']) . '" data-patient-gender="' . htmlspecialchars($row2['gender']) . '" data-visit-id="' . htmlspecialchars($row2['visitID']) . '">';
            // echo '<div class="box" >';
            // echo '<a href="doctorPatient.php?patientID=' . $row2['patientID'] . '&patientName=' . $row2['patientName'] . '&gender=' . $row2['gender'] . '&age=' . $row2['age'] . '&visitID=' . $row2['visitID'] . '">';
            echo 'Name: <span class="patientName">' . $row2['patientName'] . '</span><br />';
            echo 'Patient ID: <span class="patientID">' . $row2['patientID'] . '</span><br />';
            // echo "</a>";
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

      <!-- <form id = "dataForm" action="doctorPatient.php" method = "post">
        <input type="hidden" name = "patientName" id = "patientName">
        <input type="hidden" name = "patientID" id = "patientID">
        <input type="hidden" name = "age" id = "age">
        <input type="hidden" name = "gender" id = "gender">
        <input type="hidden" name = "visitID" id = "visitID">
        <input type="hidden" name = "patientName" id = "patientName">

       </form> -->
      </div>
    </section>
  </main>





</body>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('searchInput');

            // Add event listener to the search input field
            searchInput.addEventListener('input', function () {
                var searchValue = searchInput.value.toLowerCase().trim(); // Get the search input value and convert to lowercase

                // Loop through all box elements and show/hide based on search input
                var boxes = document.querySelectorAll('.box');
                boxes.forEach(function (box) {
                    var patientName = box.querySelector('.patientName').textContent.toLowerCase(); // Get the patient name
                    var patientID = box.querySelector('.patientID').textContent.toLowerCase(); // Get the patient ID

                    // Check if search value matches either patient name or patient ID
                    if (patientName.includes(searchValue) || patientID.includes(searchValue)) {
                        box.style.display = 'block'; // Show the box
                    } else {
                        box.style.display = 'none'; // Hide the box
                    }
                });
            });
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var visits = document.querySelectorAll('#report');
        var patients = document.querySelectorAll('#patient');

        visits.forEach(function (visit) {
            visit.addEventListener('click', function () {
                var visitID = this.getAttribute('data-visit-id');
                var date = this.getAttribute('data-date');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'doctorPatientVisit.php');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the response if needed
                        window.location.href = 'doctorPatientVisit.php'; // Redirect to page 2
                    }
                };

                var data = {
                    visitID: visitID,
                    date: date
                };

                xhr.send(JSON.stringify(data));
            });
        });

        patients.forEach(function (patient) {
            patient.addEventListener('click', function () {
                var patientID = this.getAttribute('data-patient-id');
                var patientName = this.getAttribute('data-patient-name');
                var patientAge = this.getAttribute('data-patient-age');
                var patientGender = this.getAttribute('data-patient-gender');
                var visitID = this.getAttribute('data-visit-id');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'doctorPatient.php');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the response if needed
                        window.location.href = 'doctorPatient.php'; // Redirect to page 3
                    }
                };

                var data = {
                    patientID: patientID,
                    patientName: patientName,
                    patientAge: patientAge,
                    patientGender: patientGender,
                    visitID: visitID
                };

                xhr.send(JSON.stringify(data));
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

</html>