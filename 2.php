<?php
session_start();

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
// $date = $_SESSION['date'];
echo "Patient Name: ". $patientName. "<br />";
echo "Patient ID: ". $patientID. "<br />";
echo "Patient Age: ". $patientAge. "<br />";
echo "Patient Gender: ". $patientGender. "<br />";
echo "VisitID: " .$visitID. "<br/>";
// echo "Date: ".$date;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- page1.php -->
    <div class="visit" data-visit-id="3" data-date="2024-04-14">Visit 1</div>

    <!-- page2.php -->
    <div class="visit" data-visit-id="4" data-date="2024-04-15">Visit 2</div>

</body>
<!-- JavaScript code in page1.php -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var visits = document.querySelectorAll('.visit');
        visits.forEach(function (visit) {
            visit.addEventListener('click', function () {
                var visitID = this.getAttribute('data-visit-id');
                var date = this.getAttribute('data-date');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '3.php');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the response if needed
                        window.location.href = '3.php'; // Redirect to common page
                    }
                };
                xhr.send(JSON.stringify({ visitID: visitID, date: date }));
            });
        });
    });
</script>

</html>