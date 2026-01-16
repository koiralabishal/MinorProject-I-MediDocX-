<?php
// session_name('patient_session');
session_start();
include '../../config/connection.php';

if (!isset($_SESSION['patientEmail'])) {
  header('Location:../../index.php');

}


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
if (isset($_POST['logout'])) {
  // Check if session ID matches
  logout();
}






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
  // Check if download request is received


  // Code for fetching patient details and test data remains unchanged

  // $email = $_SESSION['email'];

  //for remove div from pending report section

  $date = $_GET['date'];
  $visitID = $_GET['visitID'];
  // $patientVisitID = "SELECT visitID FROM report WHERE date = '$date'";
  // $resultPatientVisitID = mysqli_query($conn,$resultPatientVisitID);
  // if ($resultPatientVisitID) {
  //     $rowPatientVisitID = mysqli_fetch_assoc($resultPatientVisitID);
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


  $sqlVisitID = "SELECT visitID FROM patientvisitdetails WHERE date = '$date' AND patientID = '{$row['patientID']} '";
  $resultVisitID = mysqli_query($conn, $sqlVisitID);

  if ($resultVisitID) {
    $rowVisitID = mysqli_fetch_assoc($resultVisitID);
  }


  $sqlPrescription = "SELECT prescriptions FROM prescription WHERE patientID = '{$row['patientID']}' AND visitID = '$visitID'";

  $resultPrescription = mysqli_query($conn, $sqlPrescription);

  if ($resultPrescription) {
    $rowPrescription = mysqli_fetch_assoc($resultPrescription);
  }


  $tests = array();
  $testTypes = array("biochemistry", "haematology");
  // $sql3 = "SELECT category, testName, ReferenceRange, Methods FROM bichemistry WHERE category IN (SELECT DISTINCT category FROM test_data WHERE testTypes = '$testType' AND patientID = '$patientID' AND doctorID = '$doctorID')";
  foreach ($testTypes as $testType) {
    $query = "SELECT $testType.TestName, $testType.subCategory, $testType.Units, $testType.Methods, $testType.ReferenceRange,report.flag, report.resultValue
        FROM $testType 
        JOIN report ON $testType.TestName = report.TestName
        WHERE report.patientID = '{$row['patientID']}'
        -- AND test_data.category = '$testType'
        AND report.visitID = $visitID";

    $result8 = mysqli_query($conn, $query);

    if ($result8) {
      while ($row9 = mysqli_fetch_assoc($result8)) {
        $category = $row9['subCategory'];


        $referenceRanges = explode(',', $row9['ReferenceRange']);

        // Initialize an empty array to store reference range list
        $referenceRangeList = array();

        // Process each part of the reference range
        foreach ($referenceRanges as $range) {
          // Check if the range contains a semicolon
          if (strpos($range, ',;') !== false) {
            // Split range by semicolon to create nested lists
            $nestedRanges = explode(';', $range);
            $nestedList .= '<ul>';
            // for ($i = 1; $i < count($nestedRanges); $i++) {
            //   $nestedList .= "<li>{$nestedRange[$i]}</li>";
            // }
            // foreach ($nestedRanges as $nestedRange) {
            //   // Add nested list items

            //   $nestedList .= "<li>{$nestedRange}</li>";

            // }
            $nestedList .= '</ul>';

            // Add the nested list to the main reference range list
            $referenceRangeList[] = $nestedList;
          } else {
            // Add individual range to the main reference range list
            $referenceRangeList[] = $range;
          }
        }


        if (!isset($tests[$testType][$category])) {
          $tests[$testType][$category] = array();
        }

        $tests[$testType][$category][] = array(
          'testName' => $row9['TestName'],
          'referenceRange' => $referenceRangeList,
          // 'referenceRange' => $ran,
          'resultValue' => $row9['resultValue'],
          'flag' => $row9['flag'],
          'unit' => $row9['Units'],
          'methods' => $row9['Methods']
        );
      }
    }
  }



}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PatientVisit</title>
  <link rel="stylesheet" href="../../assets/css/style1.css" />
  <link rel="stylesheet" href="../../assets/css/style2Tables.css">
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
    <button onclick="patient()">Home</button>
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->

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
        <h2>Prescription</h2>
      </div>
      <?php if (isset($rowPrescription) && !empty($rowPrescription['prescriptions'])): ?>
        <div class="container">
          <div class="boxContainer">
            <div class="box">
              <?php echo nl2br($rowPrescription['prescriptions']); ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </section>
    <section>
      <div class="sectionTitle">
        <h2>Report</h2>

      </div>

      <?php foreach ($tests as $testType => $categories) { ?>

        <section>

          <div class="sectionTitle">
            <h2>
              <?php echo $testType; ?>
            </h2>
          </div>

          <!-- <div class="container"> -->
          <div class="tableContainer">
            <table>
              <tr>
                <th scope="col">Test Name</th>
                <th scope="col">Result</th>
                <th scope="col">Unit</th>
                <th scope="col">Flag</th>
                <th scope="col">Reference Range</th>
                <th scope="col">Method</th>
              </tr>
              <?php foreach ($categories as $category => $testsData) { ?>
                <tr class="testCategoryTitle">
                  <td colspan="6">
                    <?php echo $category; ?>
                  </td>
                  <?php foreach ($testsData as $testData => $Data) { ?>
                  <tr>
                    <td scope="row">
                      <?php echo $Data['testName']; ?>


                    </td>
                    <td><span>
                        <?php echo $Data['resultValue']; ?>
                      </span></td>
                    <td>
                      <?php echo $Data['unit']; ?>
                    </td>
                    <td><span>
                        <?php echo $Data['flag']; ?>
                      </span></td>
                    <td>
                      <?php
                      $referenceRanges = $Data['referenceRange'];
                      if (count($referenceRanges) > 1) {
                        echo '<ul>';
                        foreach ($referenceRanges as $range) {
                          if (strpos($range, ';') !== false) {
                            $nestedRanges = explode(';', $range);
                            echo '<ul>';
                            foreach ($nestedRanges as $nestedRange) {
                              echo "<li>{$nestedRange}</li>";
                            }
                            echo '</ul>';
                          } else {
                            echo "<li>{$range}</li>";
                          }
                        }
                        echo '</ul>';
                      } else {
                        echo $referenceRanges[0];
                      }
                      ?>
                    </td>
                    <td>
                      <?php echo $Data['methods']; ?>
                    </td>
                  </tr>
                <?php } ?>
                </tr>
              <?php } ?>
            </table>
          </div>
          <!-- </div> -->
        </section>

      <?php } ?>
    </section>
    <!-- <section>
        <div class="sectionTitle">
          <h2>Hematology</h2>
        </div>
        <div class="tableContainer">
            <table>
              <tr>
                <th scope="col">Test Name</th>
                <th scope="col">Result</th>
                <th scope="col">Unit</th>
                <th scope="col">Flag</th>
                <th scope="col">Reference Range</th>
                <th scope="col">Method</th>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Complete Blood Count</td>
              </tr>
              <tr>
                <th scope="row">Complete Blood Count</th>
                <td><span class="result"></span></td>
                <td>%</td>
                <td><span class="flag"></span></td>
                <td>
                  <ul>
                    <li>
                      Hemoglobin (Hb):
                      <ul>
                        <li>13.5 - 17.5 g/gL (male)</li>
                        <li>12 - 16 g/dL (female)</li>
                      </ul>
                    </li>
                    <li>
                      Total Leukocyte Count (TLC or WBC): 4,000 - 11,000
                      cells/μL
                    </li>
                    <li>Platelet Count: 150,000 - 450,000 platelets/μL</li>
                  </ul>
                </td>
                <td>Automated cell counting and impedance or flow cytometry</td>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Erythrocyte Sedimentation Rate(ESR)</td>
              </tr>
              <tr>
                <th scope="row">Erythrocyte Sedimentation Rate</th>
                <td><span class="result"></span></td>
                <td>mm/h</td>
                <td><span class="flag"></span></td>
                <td>
                  <ul>
                    <li>0 - 20 mm/h (male)</li>
                    <li>0 - 30 mm/h (female)</li>
                  </ul>
                </td>
                <td>Westergren method or modified Westergren method</td>
              </tr>
            </table>
        </div>
      </section> -->

  </main>
</body>
<script>
  function patient() {
    window.location = "patient.php";
  }
</script>
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
          swal("Error", "Only JPG, JPEG, and PNG files are allowed.", "error").then(() => {
            handleImageUpload();
          });
          return;
        }


        const maxSizeInBytes = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSizeInBytes) {
          swal("Warning", "Image must be less than 2MB.", "warning").then(() => {
            handleImageUpload();
          });
          return;
        }

        const formData = new FormData();
        formData.append('file', file);

        // Send the file to the server using fetch API
        fetch('patientVisit.php?date=<?php echo $_GET['date'] ?>&visitID=<?php echo $_GET['visitID'] ?>', {
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
                window.location = "patientVisit.php?date=<?php echo $_GET['date'] ?>&visitID=<?php echo $_GET['visitID'] ?>";
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