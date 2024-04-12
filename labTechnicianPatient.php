<?php

session_start();
include 'connection.php';

if (isset($_POST['submit'])) {
    $reportIDs = $_POST['reportID'];
    $resultValues = $_POST['result'];
    $technicianID = $_POST['technicianID'];
    // $flags = $_POST['flag'];
    $testNames = $_POST['testName'];
    foreach ($testNames as $index => $testName) {
        // Get the corresponding values for the current test
        $reportID = $reportIDs[$index];
        $resultValue = $resultValues[$index];
        // $flag = $flags[$index];
        // echo $testName;

        $referenceRange = getReferenceRange($conn, $testName);
        // Determine flag based on result value and reference range
        $flag = determineFlag($resultValue, $referenceRange);
        $updateQuery = "UPDATE report 
                        SET resultValue = '$resultValue', flag = '$flag' , technicianID = '$technicianID'
                        WHERE TestName = '$testName' AND ReportID = '$reportID'";

        $resultQuery = mysqli_query($conn, $updateQuery);

        if ($resultQuery) {

            $deleteQuery = "DELETE FROM test_data WHERE patientID = '{$_GET['patientID']}' AND reportID = '{$_GET['reportID']}' AND doctorID = '{$_GET['doctorID']}'";
            $resultDelete = mysqli_query($conn, $deleteQuery);

            if ($resultDelete) {
                ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Success</title>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                </head>

                <body>
                    <script>

                        document.addEventListener('DOMContentLoaded', function () {
                            // Hide the form
                            document.getElementById('testForm').style.display = 'none';

                            // Show success message
                            swal({
                                title: "Success",
                                text: "Sent Successfully",
                                icon: "success",
                                button: "Ok",
                            }).then(function () {
                                // Redirect to labTechnician.php
                                window.location = "labTechnician.php";
                            });
                        });

                    </script>
                </body>

                </html>
                <?php
            }
        }
    }
}

function getReferenceRange($conn, $testName)
{
    $query = "SELECT ReferenceRange FROM tests WHERE TestName = '$testName'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['ReferenceRange'];
    }
    return null;
}

function determineFlag($resultValue, $referenceRange)
{
    if ($resultValue === "") {
        return "P";
    } elseif (!empty($referenceRange)) {
        // Check if reference range has special characters like '<'
        if (strpos($referenceRange, '<') !== false) {
            $referenceValue = floatval(substr($referenceRange, 1)); // Remove '<' and convert to float
            $result = floatval($resultValue);
            if ($result > $referenceValue) {
                return "H";
            } else {
                return ""; //Normal
            }
        } elseif (strpos($referenceRange, '>') !== false) {
            $referenceValue = floatval(substr($referenceRange, 1)); // Remove '<' and convert to float
            $result = floatval($resultValue);
            if ($result < $referenceValue) {
                return "L";
            } else {
                return ""; // Normal
            }
        } elseif (strpos($referenceRange, '-') !== false) {
            // If reference range is expressed as a range
            $ranges = explode("-", $referenceRange);
            $lowerLimit = floatval(trim($ranges[0]));
            $upperLimit = floatval(trim($ranges[1]));
            $result = floatval($resultValue);
            if ($result < $lowerLimit) {
                return "L";
            } elseif ($result > $upperLimit) {
                return "H";
            } else {
                return ""; // Normal
            }
        } else {
            // If reference range is a single value (integer or float)
            $referenceValue = floatval($referenceRange);
            $result = floatval($resultValue);
            if ($result !== $referenceValue) {
                return "High";
            } else {
                return ""; // Normal
            }
        }
    } else {
        return ""; // Reference range not available
    }
}

// if (!isset()) {
//   header('Location: index.php');
// }

if (!isset($_SESSION['technicianEmail'], $_GET['patientName'], $_GET['patientID'], $_GET['doctorID'], $_GET['reportID'])) {
    // Redirect to index.php if any of the parameters are missing
    header('Location: index.php');
    exit();
}


if (isset($_SESSION['technicianEmail'])) {

    $email = $_SESSION['technicianEmail'];
    $patientName = $_GET['patientName'];
    $patientID = $_GET['patientID'];
    $doctorID = $_GET['doctorID'];
    $reportID = $_GET['reportID'];
    $visitID = $_GET['visitID'];
    echo $visitID;
    // echo $reportID;


    $sqlTechnicianID = "SELECT labTechnicianID FROM lab_technician WHERE technicianEmail = '$email'";
    $resultTechnicianID = mysqli_query($conn,$sqlTechnicianID);

    if ($resultTechnicianID){
        $rowTechnicianID = mysqli_fetch_assoc($resultTechnicianID);
    }

    // $sql5 = "SELECT age, gender FROM patient WHERE patientID = '$patientID'";

    // $result5 = mysqli_query($conn, $sql5);

    // if ($result5) {
    //     $row6 = mysqli_fetch_assoc($result5);
    // }

    $sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Lab Technician'";
    // session_write_close();
    $sql4 = "SELECT patientID from hospital WHERE userType = 'Patient'";
    $result4 = mysqli_query($conn, $sql4);

    if ($result4) {
        $row5 = mysqli_fetch_assoc($result4);
        $patientID = $row5['patientID'];
    }


    // $sql2 = "SELECT distinct patientName FROM  test_data WHERE patientID = '$patientID'";
    // $result2 = mysqli_query($conn, $sql2);
    // $sql2 = "SELECT Distinct h.name FROM hospital h JOIN test_data t ON h.doctorID = t.doctorID";
    $sql3 = "SELECT distinct t.patientName, t.patientID, h.name, t.doctorID
        FROM test_data t
        INNER JOIN hospital h ON t.doctorID = h.doctorID
        ORDER BY t.id DESC ";

    // $sql3 = "SELECT a.* FROM all_patient a JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC";


    $result = mysqli_query($conn, $sql);

    $result3 = mysqli_query($conn, $sql3);
    // $result3 = mysqli_query($conn, $sql3);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    }

    // $sql7 = "SELECT DISTINCT category FROM test_data WHERE patientID = '$patientID' AND doctorID = '$doctorID'";
// $result7 = mysqli_query($conn, $sql7);

    $tests = array();

    // if ($result7) {

        $sqlPatientInfo = "SELECT * FROM patientVisitDetails WHERE patientID = '$patientID' AND referredToDoctorID = '$doctorID' AND visitID = '$visitID'";
        $resultPatientInfo = mysqli_query($conn,$sqlPatientInfo);
        if($resultPatientInfo){
            $rowPatientInfo = mysqli_fetch_assoc($resultPatientInfo);
        }
    // while ($row7 = mysqli_fetch_assoc($result7)) {
// $testType = $row7['category'];
    $tests = array();
    $testTypes = array("Biochemistry", "Haematology");
    // $sql3 = "SELECT category, testName, ReferenceRange, Methods FROM bichemistry WHERE category IN (SELECT DISTINCT category FROM test_data WHERE testTypes = '$testType' AND patientID = '$patientID' AND doctorID = '$doctorID')";
    foreach ($testTypes as $testType) {
        $query = "SELECT $testType.TestName, $testType.subCategory, $testType.Units, $testType.Methods, $testType.ReferenceRange
        FROM $testType 
        JOIN test_data ON FIND_IN_SET($testType.testName, REPLACE(test_data.testNames, ', ', ','))
        WHERE test_data.patientID = '{$_GET['patientID']}'
        AND test_data.category = '$testType'
        AND test_data.doctorID = '{$_GET['doctorID']}'
        AND test_data.reportID = '{$_GET['reportID']}'";

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
    <title>labTechnicianPatient</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="style2Tables.css">
</head>

<body>
    <header>
        <img src="MediDocX Logo.JPG" alt="" />
        <input type="text" placeholder="Search Patient..." />
    </header>

    <aside>
        <div id="profileInfo">
            <div id="profilePic"></div>
            <div id="details">
                <?php echo $row['name']; ?>
                </b><br>
                <?php echo $row['userType']; ?> <br>
                ID:
                <?php echo $row['labTechnicianID']; ?> <br>
            </div>
        </div>
        <div id="reportTemplatesContainer">
            <h3>Patient Info</h3>
            <div class="reportTemplatesAside">Name:
                <?php echo $rowPatientInfo['patientName']; ?>
            </div>
            <div class="reportTemplatesAside">Patient ID:
                <?php echo $patientID; ?>
            </div>
            <div class="reportTemplatesAside">Age:
                <?php echo $rowPatientInfo['age']; ?>
            </div>
            <div class="reportTemplatesAside">Gender:
                <?php echo $rowPatientInfo['gender'] ?>
            </div>
        </div>
    </aside>

    <main>
    <form id = "testForm"
      action="labTechnicianPatient.php?patientName=<?php echo $patientName; ?>&patientID=<?php echo $_GET['patientID'] ?>&doctorID=<?php echo $doctorID; ?>&reportID=<?php echo $reportID; ?>&visitID=<?php echo $visitID; ?>"
      method="POST">
      <!-- <label for="recordID">Record ID</label>
      <input type="text" name="recordID">
      <label for="date">Date</label>
      <input type="date" name="date"> -->
      <?php foreach ($tests as $testType => $categories) { ?>


        <section>

          <div class="sectionTitle">
            <h2>
              <?php echo $testType; ?>
            </h2>
          </div>
            <div class="tableContainer">
              <table>
                <tr>
                  <th scope="col">Test Name</th>
                  <th scope="col">Result</th>
                  <th scope="col">Unit</th>
                  <!-- <th scope="col">Flag</th> -->
                  <th scope="col">Reference Range</th>
                  <th scope="col">Method</th>
                </tr>
                <?php foreach ($categories as $category => $testsData) { ?>
                  <tr class="testCategoryTitle">
                    <td colspan="5">
                      <?php echo $category; ?>
                    </td>
                    <?php foreach ($testsData as $testData => $Data) { ?>
                    <tr>
                      <td scope="row">
                        <?php echo $Data['testName']; ?>
                        <input type="hidden" name="reportID[]" value="<?php echo $reportID; ?>" />
                        <input type="hidden" name="technicianID" value="<?php echo $rowTechnicianID['labTechnicianID']; ?>" />
                        <input type="hidden" name="testName[]" value="<?php echo $Data['testName']; ?>" />

                      </td>
                      <td><input type="text" name="result[]" class="result" /></td>
                      <td>
                        <?php echo $Data['unit']; ?>
                      </td>
                      <!-- <td><input type="text" name="flag[]" class="flag" /></td> -->
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
        </section>

      <?php } ?>
      <button type="submit" name="submit">Submit</button>
    </form>

  </main>

    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>