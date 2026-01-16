<?php
session_start();

include '../../config/connection.php';

$mysqli = $conn;

if (isset($_SESSION['doctorEmail'])) {
    $doctorEmail = $_SESSION['doctorEmail'];

    // Check if the email exists in the database
    // Check if the email exists in the database and image_data is not blank
    $sqlCheckEmail = "SELECT COUNT(*) as count FROM images WHERE user_email = '$doctorEmail' AND image_data IS NOT NULL AND image_data != ''";

    $resultCheckEmail = $mysqli->query($sqlCheckEmail);

    if ($resultCheckEmail && $resultCheckEmail->num_rows > 0) {
        $rowCheckEmail = $resultCheckEmail->fetch_assoc();
        $count = $rowCheckEmail['count'];

        if ($count > 0) {
            // Retrieve the image data from the database
            $sql = "SELECT image_data FROM images WHERE user_email ='$doctorEmail'"; // Assuming you have an 'images' table with 'image_data' column
            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                // Fetch the image data
                $row = $result->fetch_assoc();
                $image_data = $row['image_data'];

                // Set the appropriate header for image content
                header("Content-type: image/jpeg"); // Change the content-type based on your image format

                // Output the image data
                echo $image_data;
            } else {
                // Image not found or database error
                // Output a default avatar based on gender
                displayDoctorDefaultAvatar($mysqli, $doctorEmail);
            }
        } else {
            // User's email does not exist in the database
            // Output a default avatar based on gender
            displayDoctorDefaultAvatar($mysqli, $doctorEmail);
        }
    } else {
        // Error checking user's email in the database
        // Output a default avatar based on gender
        displayDoctorDefaultAvatar($mysqli, $doctorEmail);
    }
}else {
    // User's email is not set in the session
    echo "Error: User's email not set in the session.";
} 


function displayDoctorDefaultAvatar($mysqli, $doctorEmail)
{
    // Retrieve the gender from the patient table
    $sqlDoctor = "SELECT gender FROM doctor WHERE doctorEmail = '$doctorEmail'";
    $resultgender = $mysqli->query($sqlDoctor);

    if ($resultgender && $resultgender->num_rows > 0) {
        $rowgender = $resultgender->fetch_assoc();
        $gender = strtolower($rowgender['gender']);
        // Define the image source based on the gender
        if ($gender === 'male') {
            $imageSrc = '../../assets/img/maleEmptyAvatar.png';
        } elseif ($gender === 'female') {
            $imageSrc = '../../assets/img/femaleEmptyAvatar.jpg';
        }

        // Set the appropriate header for image content
        header("Content-type: image/jpeg"); // Change the content-type based on your image format

        // Output the default avatar image
        readfile($imageSrc);
    } else {
        // Error fetching gender from the patient table
        echo "Error: Gender not found or database error.";
    }
}
