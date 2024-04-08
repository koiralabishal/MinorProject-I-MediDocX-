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

// $_SESSION['patientName'] = $patientName;
// $_SESSION['patientID'] = $patientID;
// $_SESSION['age'] = $patientage;
// $_SESSION['gender'] = $patientgender;

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
            <div class="container">
                <div class="boxContainer">
                    <div class="box">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident
                        nobis delectus a quisquam sunt rem alias ad aperiam odio? Vero
                        illo ut illum quasi dolores reprehenderit dicta optio id sunt.
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="sectionTitle">
                <h2>BioChemistry</h2>
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
                        <td colspan="6">Complete BioChemistry Profile</td>
                    </tr>

                    <tr>
                        <th scope="row">RBS</th>
                        <td><span class="result"></span></td>
                        <td>mg/dL</td>
                        <td><span class="flag"></span></td>
                        <td>70 - 140</td>
                        <td>Glucose oxidase-peroxidase</td>
                    </tr>

                    <tr>
                        <th scope="row">FBS</th>
                        <td><span class="result"></span></td>
                        <td>mg/dL</td>
                        <td><span class="flag"></span></td>
                        <td>70 - 100</td>
                        <td>Glucose oxidase-peroxidase</td>
                    </tr>

                    <tr>
                        <th scope="row">PPBS</th>
                        <td><span class="result"></span></td>
                        <td>mg/dL</td>
                        <td><span class="flag"></span></td>
                        <td>&lt; 140 (postprandial)</td>
                        <td>Glucose oxidase-peroxidase</td>
                    </tr>

                    <tr class="testCategoryTitle">
                        <td colspan="6">Liver Function Tests</td>
                    </tr>

                    <tr>
                        <th scope="row">LFT</th>
                        <td><span class="result"></span></td>
                        <td>IU/L</td>
                        <td><span class="flag"></span></td>
                        <td>
                            <ul>
                                <li>Total Bilirubin: 0.2 - 1.2 mg/ dL</li>
                                <li>Alanine aminotransferase (ALR or SGPT): 7 - 56 IU/ L</li>
                                <li>
                                    Aspartate aminotransferase (AST or SGOT): 5 - 40 IU/ L
                                </li>
                            </ul>
                        </td>
                        <td>Various enzymatic and colorimetric methods</td>
                    </tr>
                    <tr>
                        <th scope="row">Total Bilirubin</th>
                        <td><span class="result"></span></td>
                        <td>mg/dL</td>
                        <td><input type="text" class="flag" /></td>
                        <td>0.3 - 1.2</td>
                        <td>Diazo Method</td>
                    </tr>

                </table>
            </div>
        </section>

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
        </section>

    </main>

    <script>
        function addPrescription() {
            window.location.href = "addPrescription.html";
        }

        function requestationLetter() {
            window.location.href = "requestationLetter.html";
        }

        function biochemistry() {
            window.location.href = "bioChemistry.html";
        }

        function haematology() {
            window.location.href = "haematology.html";
        }

        function echocardiography() {
            window.location.href = "echocardiography.html";
        }
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>