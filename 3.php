<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Store visit data in session
    $_SESSION['visitID'] = $data['visitID'];
    $_SESSION['date'] = $data['date'];

    // Send success response
    http_response_code(200);
    exit;
}
$visitID = $_SESSION['visitID'];
$date = $_SESSION['date'];

echo "VisitID: " .$visitID. "<br/>";
echo "Date: ".$date;
