<?php
session_start();
include 'connection.php';

// if(!isset($_SESSION['doctorEmail'])){
//   header('Location:index.php');
// }

if (!isset($_SESSION['doctorEmail'], $_SESSION['patientID'], $_SESSION['age'], $_SESSION['gender'])) {
    header('Location:index.php');
}

// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $patientage = $_GET['age'];
// $patientgender = $_GET['gender'];

$email = $_SESSION['doctorEmail'];
$patientName = $_SESSION['patientName'];
$patientID = $_SESSION['patientID'];
$patientage = $_SESSION['age'];
$patientgender = $_SESSION['gender'];
// $visitID = $_SESSION['visitID'];
$visitID = $_GET['visitID'];
$_SESSION['visitID'] = $visitID;
$date = $_GET['date'];
$_SESSION['date'] = $date;

// $reportID  = $_GET['reportID'] ;
// $_SESSION['reportID'] = $reportID;
// echo $visitID;
// $_SESSION['patientName'] = $patientName;
// $_SESSION['patientID'] = $patientID;
// $_SESSION['age'] = $patientage;
// $_SESSION['gender'] = $patientgender;

$sqlVisitID = "SELECT visitID FROM patientVisitDetails WHERE date = '$date'";
$resultVisitID = mysqli_query($conn, $sqlVisitID);

// if ($resultVisitID) {
//     $rowVisitID = mysqli_fetch_assoc($resultVisitID);
// }




//for profile section
$sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Doctor'";
// $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

$result = mysqli_query($conn, $sql);
// $result2 = mysqli_query($conn, $sql2);

if ($result) {
    $row = mysqli_fetch_assoc($result);
}

// if ($result2) {
//   $row2 = mysqli_fetch_assoc($result2);
// }



//for prescription section

$sqlPrescription = "SELECT prescriptions FROM prescription WHERE patientID = '$patientID'
AND doctorID = {$row['doctorID']}
AND visitID = '$visitID'";

$resultPrescription = mysqli_query($conn, $sqlPrescription);

if($resultPrescription){
    $rowPrescription = mysqli_fetch_assoc($resultPrescription);
}



$tests = array();
$testTypes = array("Biochemistry", "Haematology");
// $sql3 = "SELECT category, testName, ReferenceRange, Methods FROM bichemistry WHERE category IN (SELECT DISTINCT category FROM test_data WHERE testTypes = '$testType' AND patientID = '$patientID' AND doctorID = '$doctorID')";
foreach ($testTypes as $testType) {
    $query = "SELECT $testType.TestName, $testType.subCategory, $testType.Units, $testType.Methods, $testType.ReferenceRange,report.flag, report.resultValue
        FROM $testType 
        JOIN report ON $testType.TestName = report.TestName
        WHERE report.patientID = '$patientID'
        -- AND test_data.category = '$testType'
        AND report.doctorID = '{$row['doctorID']}'
        AND report.visitID = {$visitID}
        AND report.date = '$date'";

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



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>doctorPatientVisit</title>
    <link rel="stylesheet" href="style1.css" />
    <link rel="stylesheet" href="style2Tables.css">
    <style>

    </style>
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
        <div id="reportTemplatesContainer">
            <h3>Patient Info</h3>
            <div class="reportTemplatesAside">Name:
                <?php echo $patientName; ?>
            </div>
            <div class="reportTemplatesAside">Patient ID:
                <?php echo $patientID; ?>
            </div>
            <div class="reportTemplatesAside">Age:
                <?php echo $patientage; ?>
            </div>
            <div class="reportTemplatesAside">Gender:
                <?php echo $patientgender; ?>
            </div>
        </div>
    </aside>

    <main>
        <section>
            <div class="sectionTitle">
                <h2>Prescription</h2>
                <button onclick="addPrescription()">Add Prescription</button>
                <button onclick="requestationLetter()">Request Letter</button>
            </div>
            <?php if(isset($rowPrescription) && !empty($rowPrescription['prescriptions'])): ?>
            <div class="container">
                <div class="boxContainer">
                    <div class="box">
                       <?php echo nl2br($rowPrescription['prescriptions']); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </section>


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
                                    <td><span class="result">
                                            <?php echo $Data['resultValue']; ?>
                                        </span></td>
                                    <td>
                                        <?php echo $Data['unit']; ?>
                                    </td>
                                    <td><span class="flag">
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





        <!-- 
        <section>
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

    <script>
        function addPrescription() {
            window.location.href = "addPrescription.php";
        }

        function requestationLetter() {
            window.location.href = "requestationLetter.php";
        }

    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>