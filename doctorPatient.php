<?php
// session_name('doctor_session');
session_start();
include 'connection.php';

if (!isset($_SESSION['doctorEmail'])) {
    header('Location:index.php');
}


// if (!isset($_SESSION['patientName'], $_GET['patientID'], $_GET['age'], $_GET['gender'], $_GET['visitID'])) {
//     header('Location:index.php');
// }

// if (!isset($_SESSION['patientID'], $_SESSION['age'], $_SESSION['gender'])) {
//   header('Location:index.php');
// }

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Store visit data in session
        $_SESSION['patientName'] = $data['patientName'];
        $_SESSION['patientID'] = $data['patientID'];
        $_SESSION['patientGender'] = $data['patientGender'];
        $_SESSION['patientAge'] = $data['patientAge'];
        $_SESSION['visitID'] = $data['visitID'];
        $_SESSION['date'] = $data['date'];

        // Send success response
        http_response_code(200);
        exit;
    }
    $patientName = $_SESSION['patientName'];
    $patientID = $_SESSION['patientID'];
    $patientAge = $_SESSION['patientAge'];
    $patientGender = $_SESSION['patientGender'];
    $visitID = $_SESSION['visitID'];

    // $patientName = $_GET['patientName'];
    // $patientID = $_GET['patientID'];
    // $patientage = $_GET['age'];
    // $patientgender = $_GET['gender'];
    // $visitID = $_GET['visitID'];
    // $patientID = $_SESSION['patientID'] ?? '';
    // $patientName = $_SESSION['patientName'] ?? '';
    // $patientage = $_SESSION['patientAge'] ?? '';
    // $patientgender = $_SESSION['patientGender'] ?? '';
    // $visitID = $_SESSION['visitID'] ?? '';



    // $patientName = isset($_POST['patientName']) ? $_POST['patientName'] : '';
    // $patientID = isset($_POST['patientID']) ? $_POST['patientID'] : '';
    // $patientage = isset($_POST['age']) ? $_POST['age'] : '';
    // $patientgender = isset($_POST['gender']) ? $_POST['gender'] : '';
    // $visitID = isset($_POST['visitID']) ? $_POST['visitID'] : '';
    $doctorEmail = $_SESSION['doctorEmail'];


    // $_SESSION['patientName'] = $patientName;
    // $_SESSION['patientID'] = $patientID;
    // $_SESSION['age'] = $patientage;
    // $_SESSION['gender'] = $patientgender;
    // $_SESSION['visitID'] = $visitID;

    $sql = "SELECT * FROM hospital WHERE email = '{$doctorEmail}' AND userType ='Doctor'";
    // $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

    $result = mysqli_query($conn, $sql);
    // $result2 = mysqli_query($conn, $sql2);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        // echo $row['doctorID'];
    }


    $sqlVisits = "SELECT * FROM patientvisitdetails WHERE patientID = $patientID AND referredToDoctorID = {$row['doctorID']} ORDER BY date DESC, visitID DESC";
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
                echo '<div class="box" id = "visit" data-visit-id="' . htmlspecialchars($visit['visitID']) . '" data-date="' . htmlspecialchars($visit['date']) . '">';
                // echo '<div class="box">';
                // echo '<a href="doctorPatientVisit.php?date=' . $visit['date'] . '&visitID=' . $visit['visitID'] . '">';
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
    }

    // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'], $_POST['visitID'])) {
    //     $_SESSION['visit_date'] = $_POST['date'];
    //     $_SESSION['visit_id'] = $_POST['visitID'];
    //     header('Location: doctorPatientVisit.php');
    //     exit;
    // }


    // if ($result2) {
//   $row2 = mysqli_fetch_assoc($result2);
// }
}
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Get the JSON data from the request body
//     $data = json_decode(file_get_contents('php://input'), true);

//     // Store data in the PHP session
//     // $_SESSION['patientID'] = $data['patientID'];
//     // $_SESSION['patientName'] = $data['patientName'];
//     // $_SESSION['patientAge'] = $data['patientAge'];
//     $_SESSION['date'] = $data['date'];
//     $_SESSION['visitID'] = $data['visitID'];
//     // Send success response
//     http_response_code(200);
//     exit;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>doctorPatient</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <header>
        <img src="MediDocX Logo.JPG" alt="" />
        <form method="post" id="logoutForm">
            <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
            <button type="submit" id="logoutButton">Log out</button>
        </form>

        <input type="text" placeholder="Search Patient...">
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
                <?php echo $patientAge; ?>
            </div>
            <div class="reportTemplatesAside">Gender:
                <?php echo $patientGender; ?>
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
                                <!-- <?php foreach ($visits as $visit): ?>
                                    <div class="box"
                                        onclick="visit('<?php echo $visit['date']; ?>', '<?php echo $visit['visitID']; ?>')">
                                        Date: <?php echo date('Y-m-d', strtotime($visit['date'])); ?>
                                    </div>
                                <?php endforeach; ?> -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </section>
        <!-- <form id="dataForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" id="date" name="date">
            <input type="hidden" id="visitID" name="visitID">
        </form> -->
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var visits = document.querySelectorAll('#visit');
            // var patients = document.querySelectorAll('#patient');

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
</body>

</html>