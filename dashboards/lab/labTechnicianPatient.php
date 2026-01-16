<?php



// session_name('lab_technician_session');
session_start();
include '../../config/connection.php';



if (!isset($_SESSION['technicianEmail'])) {
    header('Location:../../index.php');
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo $patientName;

    $reportIDs = $_POST['reportID'];
    $patientID = $_POST['patientID'];
    $doctorID = $_POST['patientID'];
    $resultValues = $_POST['result'];
    $technicianID = $_POST['technicianID'];
    // $flags = $_POST['flag'];
    $testNames = $_POST['testName'];
    // $queries = [];
    $success = true; // Assuming success by default
    foreach ($testNames as $index => $testName) {
        // Get the corresponding values for the current test
        $reportID = $reportIDs[$index];
        // echo $reportID;
        // echo $testName;
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
        // $queries[] = $resultQuery;

        if ($resultQuery) {

            $deleteQuery = "DELETE FROM test_data WHERE patientID = '{$_GET['patientID']}' AND reportID = '$reportID ' AND doctorID = '{$_GET['doctorID']}'";
            $resultDelete = mysqli_query($conn, $deleteQuery);

            if ($resultDelete) {
                ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Success</title>

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
                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

function logout()
{
    // Clear session data
    unset($_SESSION['technicianEmail']);
    // Redirect to the index page
    header('Location: ../../index.php');
    exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
    logout();
}



// if (!isset()) {
//   header('Location: index.php');
// }

// if (!isset($_SESSION['technicianEmail'], $_GET['patientName'], $_GET['patientID'], $_GET['doctorID'], $_GET['reportID'])) {
//     // Redirect to index.php if any of the parameters are missing
//     header('Location: index.php');
//     exit();
// }



if (isset($_SESSION['technicianEmail'])) {

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $data = json_decode(file_get_contents('php://input'), true);

    //         // Store visit data in session if provided in the JSON data or if already set in session
//         if (isset($data['patientName']) || isset($_SESSION['patientName'])) {
//             $_SESSION['patientName'] = $data['patientName'] ?? $_SESSION['patientName'];
//         }
//         if (isset($data['patientID']) || isset($_SESSION['patientID'])) {
//             $_SESSION['patientID'] = $data['patientID'] ?? $_SESSION['patientID'];
//         }
//         if (isset($data['doctorID']) || isset($_SESSION['doctorID'])) {
//             $_SESSION['doctorID'] = $data['doctorID'] ?? $_SESSION['doctorID'];
//         }
//         if (isset($data['reportID']) || isset($_SESSION['reportID'])) {
//             $_SESSION['reportID'] = $data['reportID'] ?? $_SESSION['reportID'];
//         }
//         if (isset($data['visitID']) || isset($_SESSION['visitID'])) {
//             $_SESSION['visitID'] = $data['visitID'] ?? $_SESSION['visitID'];
//         }

    //         // Send success response
//         http_response_code(200);
//         exit;
//     }

    // $patientName = $_SESSION['patientName'] ?? '';
    // $_SESSION['patientName'] = $patientName;
    // $patientID = $_SESSION['patientID'] ?? '';
    // $_SESSION['patientID'] =$patientID;
    // $doctorID = $_SESSION['doctorID'] ?? '';
    // $_SESSION['doctorID'] =$doctorID;
    // $reportID = $_SESSION['reportID'] ?? '';
    // $_SESSION['reportID'] = $reportID;

    // $visitID = $_SESSION['visitID'] ?? '';
    // $_SESSION['visitID'] = $visitID;
    // echo "Patient Name: " . $patientName . "<br />";
    // echo "Patient ID: ". $patientID. "<br />";
    // echo "Patient Age: ". $patientAge. "<br />";
    // echo "Patient Gender: ". $patientGender. "<br />";
    // echo "VisitID: " . $visitID . "<br/>";


    // $patientAge = $_SESSION['patientAge'];
    // $patientGender = $_SESSION['patientGender'];
    // $visitID = $_SESSION['visitID'];

    $email = $_SESSION['technicianEmail'];
    $patientName = $_GET['patientName'];
    $patientID = $_GET['patientID'];
    $doctorID = $_GET['doctorID'];
    $reportID = $_GET['reportID'];
    $visitID = $_GET['visitID'];
    // echo $visitID;
    // echo $reportID;
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
            $sql = "UPDATE images SET image_data = '$image_data' WHERE user_email = '$email'";
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


    $sqlTechnicianID = "SELECT labTechnicianID FROM lab_technician WHERE technicianEmail = '$email'";
    $resultTechnicianID = mysqli_query($conn, $sqlTechnicianID);

    if ($resultTechnicianID) {
        $rowTechnicianID = mysqli_fetch_assoc($resultTechnicianID);
    }

    // $sql5 = "SELECT age, gender FROM patient WHERE patientID = '$patientID'";

    // $result5 = mysqli_query($conn, $sql5);

    // if ($result5) {
    //     $row6 = mysqli_fetch_assoc($result5);
    // }

    $sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Lab Technician'";
    // session_write_close();
    // $sql4 = "SELECT patientID from hospital WHERE userType = 'Patient'";
    // $result4 = mysqli_query($conn, $sql4);

    // if ($result4) {
    //     $row5 = mysqli_fetch_assoc($result4);
    //     $patientID = $row5['patientID'];
    // }


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

    $sqlPatientInfo = "SELECT * FROM patientvisitdetails WHERE patientID = '$patientID' AND referredToDoctorID = '$doctorID' AND visitID = '$visitID'";
    $resultPatientInfo = mysqli_query($conn, $sqlPatientInfo);
    if ($resultPatientInfo) {
        $rowPatientInfo = mysqli_fetch_assoc($resultPatientInfo);
    }
    // while ($row7 = mysqli_fetch_assoc($result7)) {
// $testType = $row7['category'];
    $tests = array();
    $testTypes = array("biochemistry", "haematology");
    // $sql3 = "SELECT category, testName, ReferenceRange, Methods FROM bichemistry WHERE category IN (SELECT DISTINCT category FROM test_data WHERE testTypes = '$testType' AND patientID = '$patientID' AND doctorID = '$doctorID')";
    foreach ($testTypes as $testType) {
        $categoryFilter = ucfirst($testType);
        $query = "SELECT tests.TestName, tests.subCategory, tests.Units, tests.Methods, tests.ReferenceRange
        FROM tests 
        JOIN test_data ON FIND_IN_SET(tests.TestName, REPLACE(test_data.testNames, ', ', ','))
        WHERE test_data.patientID = '{$_GET['patientID']}'
        AND tests.category = '$categoryFilter'
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
    <link rel="stylesheet" href="../../assets/css/style1.css">
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
        <button onclick="labTechnician()">Home</button>
        <form method="post" id="logoutForm">
            <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->

        </form>
        <button type="submit" id="logoutButton">Log out</button>
        <!-- <input type="text" placeholder="Search Patient..." /> -->
    </header>

    <aside>
        <div id="profileInfo">
            <div id="profilePic" class="profile-pic-container">



                <img id="avatar" src="../../api/images/getImageLabTechnician.php" onclick="handleImageUpload()">
                <div class="upload-photo-text">
                    + Upload Photo
                </div>




            </div>
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
        <form id="testForm" method="POST"
            action="labTechnicianPatient.php?patientName=<?php echo $_GET['patientName']; ?> &patientID=<?php echo $_GET['patientID']; ?> &doctorID=<?php echo $_GET['doctorID']; ?> &reportID=<?php echo $_GET['reportID']; ?> &visitID=<?php echo $_GET['visitID']; ?> ">
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
                                            <input type="hidden" name="patientID" value="<?php echo $patientID; ?>" />
                                            <input type="hidden" name="doctorID" value="<?php echo $doctorID; ?>" />
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
                </section>

            <?php } ?>
            <section>
                <div class="sectionTitle">
                    <h2></h2>
                    <button type="submit" name="submit">Send</button>
                    <h2></h2>
                </div>
            </section>
        </form>

    </main>

    <script>
        function labTechnician() {
            window.location = "labTechnician.php";
        }
    </script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener for form submission
            document.getElementById('submitFormButton').addEventListener('click', function () {
                // Prevent the default form submission
                event.preventDefault();

                // Collect form data
                var formData = new FormData(document.getElementById('testForm'));

                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'labTechnician.php', true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Success callback
                            swal({
                                title: "Success",
                                text: "Form submitted successfully!",
                                icon: "success",
                                button: "Ok",
                            }).then(function () {
                                // Optionally, redirect to another page
                                window.location.href = 'labTechnician.php';
                            });
                        } else {
                            // Error callback
                            swal("Error", response.message || "Error occurred while submitting the form!", "error");
                        }
                    } else {
                        // Error callback
                        swal("Error", "Error occurred while submitting the form!", "error");
                    }
                };
                xhr.onerror = function () {
                    // Error callback
                    swal("Error", "Error occurred while submitting the form!", "error");
                };
                xhr.send(formData);
            });
        });
    </script> -->
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
                        swal("Error", "Only JPG, JPEG, and PNG files are allowed.", "error");
                        return;
                    }


                    const maxSizeInBytes = 2 * 1024 * 1024; // 2MB
                    if (file.size > maxSizeInBytes) {
                        swal("Warning", "Image must be less than 2MB.", "warning");
                        return;
                    }

                    const formData = new FormData();
                    formData.append('file', file);

                    // Send the file to the server using fetch API
                    fetch('labTechnicianPatient.php?patientName=<?php echo $_GET['patientName'] ?>&patientID=<?php echo $_GET['patientID'] ?>&doctorID=<?php echo $_GET['doctorID'] ?>&reportID=<?php echo $_GET['reportID'] ?>&visitID=<?php echo $_GET['visitID'] ?>', {
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
                                    window.location = "labTechnicianPatient.php?patientName=<?php echo $_GET['patientName']; ?> &patientID=<?php echo $_GET['patientID']; ?> &doctorID=<?php echo $_GET['doctorID']; ?> &reportID=<?php echo $_GET['reportID']; ?> &visitID=<?php echo $_GET['visitID']; ?>";
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