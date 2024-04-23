<?php
// session_name('lab_technician_session');
session_start();
include 'connection.php';



if (!isset($_SESSION['technicianEmail'])) {
    header('Location: index.php');
}



function logout()
{
    // Clear session data
    unset($_SESSION['technicianEmail']);
    // Redirect to the index page
    header('Location: index.php');
    exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
    logout();
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents('php://input'), true);

// Store visit data in session
// $_SESSION['patientName'] = $data['patientName'];
// $_SESSION['patientID'] = $data['patientID'];
// $_SESSION['doctorID'] = $data['doctorID'];
// $_SESSION['reportID'] = $data['reportID'];
// $_SESSION['visitID'] = $data['visitID'];
// $_SESSION['date'] = $data['date'];

// Send success response
//     http_response_code(200);
//     exit;
// }
// $patientName = $_SESSION['patientName'];
// $patientID = $_SESSION['patientID'];
// $doctorID = $_SESSION['doctorID'];
// $reportID = $_SESSION['reportID'];
// $visitID = $_SESSION['visitID'];
// echo "Patient Name: ". $patientName. "<br />";
// echo "Patient ID: ". $_SESSION['patientID']. "<br />";
// echo "Patient Age: ". $patientAge. "<br />";
// echo "Patient Gender: ". $patientGender. "<br />";
// echo "VisitID: " .$_SESSION['visitID']. "<br/>";


if (isset($_POST['submit'])) {
    $reportIDs = $_POST['reportID'];
    $resultValues = $_POST['result'];
    // $flags = $_POST['flag'];
    $technicianID = $_POST['technicianID'];
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
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script>

                        document.addEventListener('DOMContentLoaded', function () {
                                        Hide the form
                            document.getElementById('testForm').style.display = 'display';

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





// if (!isset($_SESSION['technicianEmail'], $_GET['patientID'], $_GET['doctorID'], $_GET['reportID'])) {
//     // Redirect to index.php if any of the parameters are missing
//     header('Location: index.php');
//     exit();
// }











if (isset($_SESSION['technicianEmail'])) {


    $email = $_SESSION['technicianEmail'];
    // $patientName = $_GET['patientName'];
    $patientID = $_GET['patientID'];
    $doctorID = $_GET['doctorID'];
    $reportID = $_GET['reportID'];
    $visitID = $_GET['visitID'];
    // echo $reportID;



    $sqlTechnicianID = "SELECT labTechnicianID FROM lab_technician WHERE technicianEmail = '$email'";
    $resultTechnicianID = mysqli_query($conn, $sqlTechnicianID);

    if ($resultTechnicianID) {
        $rowTechnicianID = mysqli_fetch_assoc($resultTechnicianID);
    }



    // $sqlPatientName = "SELECT name FROM hospital WHERE patientID = '$patientID'";
    // $resultPatientName = mysqli_query($conn, $sqlPatientName);

    // if ($resultPatientName) {
    //     $rowPatientName = mysqli_fetch_assoc($resultPatientName);
    // }
    $sqlPatientInfo = "SELECT * FROM patientvisitdetails WHERE patientID = '$patientID' AND referredToDoctorID = '$doctorID' AND visitID = '$visitID'";
    $resultPatientInfo = mysqli_query($conn, $sqlPatientInfo);
    if ($resultPatientInfo) {
        $rowPatientInfo = mysqli_fetch_assoc($resultPatientInfo);
    }

    // $sql5 = "SELECT age, gender FROM appointed_patient WHERE patientID = '$patientID'";

    // $result5 = mysqli_query($conn, $sql5);

    // if ($result5) {
    //     $row6 = mysqli_fetch_assoc($result5);
    // }

    $sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Lab Technician'";
    // session_write_close();
//   $sql4 = "SELECT patientID from hospital WHERE userType = 'Patient'";
//   $result4 = mysqli_query($conn, $sql4);

    //   if ($result4) {
//     $row5 = mysqli_fetch_assoc($result4);
//     $patientID = $row5['patientID'];

    //   }


    $sql2 = "SELECT distinct patientName FROM  test_data WHERE patientID = '$patientID'";
    $result2 = mysqli_query($conn, $sql2);
    // $sql2 = "SELECT Distinct h.name FROM hospital h JOIN test_data t ON h.doctorID = t.doctorID";
//   $sql3 = "SELECT distinct t.patientName, t.patientID, h.name, t.doctorID
//         FROM test_data t
//         INNER JOIN hospital h ON t.doctorID = h.doctorID
//         ORDER BY t.id DESC ";

    // $sql3 = "SELECT a.* FROM all_patient a JOIN hospital h on a.referredToDoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC";



    $result = mysqli_query($conn, $sql);

    //   $result3 = mysqli_query($conn, $sql3);
    // $result3 = mysqli_query($conn, $sql3);


    if ($result) {
        $row = mysqli_fetch_assoc($result);
    }


    // $sql7 = "SELECT DISTINCT category FROM test_data WHERE patientID = '$patientID' AND doctorID = '$doctorID'";
// $result7 = mysqli_query($conn, $sql7);

    $tests = array();

    // if ($result7) {


    // while ($row7 = mysqli_fetch_assoc($result7)) {
// $testType = $row7['category'];
    $tests = array();
    $testTypes = array("biochemistry", "haematology");
    // $sql3 = "SELECT category, testName, ReferenceRange, Methods FROM bichemistry WHERE category IN (SELECT DISTINCT category FROM test_data WHERE testTypes = '$testType' AND patientID = '$patientID' AND doctorID = '$doctorID')";
    foreach ($testTypes as $testType) {
        $query = "SELECT $testType.TestName, $testType.subCategory, $testType.Units, $testType.Methods, $testType.ReferenceRange
        FROM $testType 
        JOIN report ON $testType.TestName = report.TestName
        WHERE report.patientID = '{$_GET['patientID']}'
        -- AND test_data.category = '$testType'
        AND report.doctorID = '{$_GET['doctorID']}'
        AND report.ReportID = '{$_GET['reportID']}'
        AND report.flag = 'P'";

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


// session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>labTechnicianPatient</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="style2Tables.css">
</head>

<body>
    <header>
        <img src="MediDocX Logo.JPG" alt="" />
        <form method="post" id="logoutForm">
            <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
            <button type="submit" id="logoutButton">Log out</button>
        </form>
        <input type="text" placeholder="Search Patient..." />
    </header>
    <aside>
        <div id="profileInfo">
            <div id="profilePic"></div>
            <div id="details">
                <b>
                <?php echo $row['name']; ?>
                </b><br>
                <?php echo $row['userType']; ?> <br>
                ID:
                <?php echo $row['labTechnicianID']; ?> <br>
                <?php echo $row['doctorQualification']; ?> <br>
                <?php echo $row['universityCollageCountry']; ?> <br>
            </div>
        </div>
        <div id="reportTemplatesContainer">
            <h3>Patient Info</h3>
            <div class="reportTemplatesAside">Name:
                <?php echo $rowPatientInfo['patientName']; ?>
            </div>
            <div class="reportTemplatesAside">Patient ID:
                <?php echo $rowPatientInfo['patientID']; ?>
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
        <form id="testForm"
            action="pendingTests.php?patientID=<?php echo $_GET['patientID']; ?> &doctorID=<?php echo $_GET['doctorID']; ?> &reportID=<?php echo $_GET['reportID']; ?> &visitID=<?php echo $_GET['visitID']; ?>"
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
                    <!-- <div class="container"> -->
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
                                            <input type="hidden" name="technicianID"
                                                value="<?php echo $rowTechnicianID['labTechnicianID']; ?>" />
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
                    <!-- </div> -->
                </section>

            <?php } ?>
            <button type="submit" name="submit">Submit</button>
        </form>




    </main>
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
</body>


</html>