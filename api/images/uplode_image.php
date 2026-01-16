<?php
// Check if file is selected
if (isset($_FILES["file"])) {
    $target_dir = "uploads/"; // Directory where uploaded images will be saved
    $target_file = $target_dir . basename($_FILES["file"]["name"]); // Path of the uploaded image file
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file extension

    // Check if the file is an actual image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check === false) {
        echo json_encode(["success" => false, "message" => "File is not an image."]);
        exit();
    }

    // Allow only certain file formats
    $allowed_extensions = array("jpg", "jpeg", "png");
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo json_encode(["success" => false, "message" => "Only JPG, JPEG, and PNG files are allowed."]);
        exit();
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Image uploaded successfully
        echo json_encode(["success" => true, "message" => "Image uploaded successfully", "file_path" => $target_file]);
    } else {
        // Failed to upload image
        echo json_encode(["success" => false, "message" => "Failed to upload image."]);
    }
} else {
    // No file selected
    echo json_encode(["success" => false, "message" => "No file selected."]);
}

