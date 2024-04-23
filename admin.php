<?php
session_start();
include 'connection.php';

if(!isset($_SESSION['adminEmail'])){
  header('Location: index.php');
}
function logout()
{
  // Clear session data
  unset($_SESSION['adminEmail']);
  // Redirect to the login page
  header('Location: index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
  logout();
}
// echo $_SESSION['adminEmail'];
if (isset($_SESSION['adminEmail'])) {

  $sqlDoctorNameID = "SELECT name, doctorID FROM hospital WHERE userType = 'Doctor' ORDER BY id DESC";
  $resultDoctorNameID = mysqli_query($conn, $sqlDoctorNameID);

  $sqlTechnicianNameID = "SELECT name, labTechnicianID FROM hospital WHERE userType = 'Lab Technician' ORDER BY id DESC";
  $resultTechnicianNameID = mysqli_query($conn, $sqlTechnicianNameID);

  $sqlPatient = "SELECT name ,patientID FROM new_patient ORDER BY id DESC";
  $resultPatient = mysqli_query($conn, $sqlPatient);

  $adminInfo = "SELECT * from admins WHERE adminEmail = '{$_SESSION['adminEmail']}'";
  $adminInfoResult = mysqli_query($conn,$adminInfo);

  if($adminInfoResult){
    $rowAdminInfo = mysqli_fetch_array($adminInfoResult);
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>admin</title>
  <link rel="stylesheet" href="style1.css" />
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
      <button type="submit" id="logoutButton">Log out</button>
    </form>
    <button onclick="addNewDoctor()">Add New Doctor</button>
    <button onclick="addNewLabTechnician()">Add New Lab Technician</button>
    <input type="text" id="searchInput" placeholder="Search ..." />
  </header>

  <aside>
    <div id="profileInfo">
      <div id="profilePic"></div>
      <div id="details">
        <b> <?php echo $rowAdminInfo['name']; ?> </b><br />
        Admin <br />
        ID: <?php echo $rowAdminInfo['adminID']; ?> <br />
        <!-- M.D. Cardiology -->
      </div>
    </div>
  </aside>

  <main>
    <section>
      <div class="sectionTitle">
        <h2>All Doctors</h2>
      </div>
      <!-- <div class="container"> -->
        <div class="boxContainer">
          <?php
          if ($resultDoctorNameID) {
            while ($rowDoctorNameID = mysqli_fetch_assoc($resultDoctorNameID)) {
              echo '<div class="box">';
              echo 'Name: <span class="name">' . $rowDoctorNameID['name'] . '</span><br />';
              echo 'Doctor ID: <span class = "ID" >' . $rowDoctorNameID['doctorID'] . '</span><br />';
              echo '</div>';
            }
          }
          ?>
          <!-- <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div> -->
        </div>
      <!-- </div> -->
    </section>

    <section>
      <div class="sectionTitle">
        <h2>All Lab Technicians</h2>
      </div>
      <!-- <div class="container"> -->
        <div class="boxContainer">
          <?php
          if ($resultTechnicianNameID) {
            while ($rowTechnicianNameID = mysqli_fetch_assoc($resultTechnicianNameID)) {
              echo '<div class="box">';
              echo 'Name: <span class="name">' . $rowTechnicianNameID['name'] . '</span><br />';
              echo 'Lab Technician ID: <span class="ID">' . $rowTechnicianNameID['labTechnicianID'] . '</span><br />';
              echo '</div>';
            }
          }
          ?>
          <!-- <div class="box" onclick="patient()">
              Name: Bishal Koirala <br />
              Patient ID: 21 <br />
              Referred by: Dr. Nabin Bhattarai
            </div> -->
        </div>
      <!-- </div> -->
    </section>

    <section>
      <div class="sectionTitle">
        <h2>All Lab Patients</h2>
      </div>
      <!-- <div class="container"> -->
        <div class="boxContainer">
          <?php
         
              if ($resultPatient) {
                while ($rowresultPatient = mysqli_fetch_array($resultPatient)) {
                  echo '<div class="box">';
                  echo 'Name: <span class="name">' . $rowresultPatient['name'] . '</span><br/>';
                  echo 'Patient ID: <span class="ID"> ' . $rowresultPatient['patientID'] . '</span><br/>';
                  // echo 'Ref. By: Dr.' . $rowresultPatientNameIDDoctorName['name'] . '<br/>';
                  echo '</div>';
                }
              }

          ?>
          <!-- <div class="box" onclick="patient()">
            Name: Bishal Koirala <br />
            Patient ID: 21 <br />
            Referred by: Dr. Nabin Bhattarai
          </div> -->
        </div>
      <!-- </div> -->
    </section>

  </main>
  <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('searchInput');

            // Add event listener to the search input field
            searchInput.addEventListener('input', function () {
                var searchValue = searchInput.value.toLowerCase().trim(); // Get the search input value and convert to lowercase

                // Loop through all box elements and show/hide based on search input
                var boxes = document.querySelectorAll('.box');
                boxes.forEach(function (box) {
                    var name = box.querySelector('.name').textContent.toLowerCase(); // Get the patient name
                    var ID = box.querySelector('.ID').textContent.toLowerCase(); // Get the patient ID

                    // Check if search value matches either patient name or patient ID
                    if (name.includes(searchValue) || ID.includes(searchValue)) {
                        box.style.display = 'block'; // Show the box
                    } else {
                        box.style.display = 'none'; // Hide the box
                    }
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
  <script>
    function addNewDoctor() {
      window.location.href = "adminAddNewDoctor.php";
    }

    function addNewLabTechnician() {
      window.location.href = "adminAddNewLabTechnician.php";
    }

  </script>
</body>

</html>