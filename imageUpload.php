<?php

session_start();
// Check if file was uploaded without errors
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    // Check if the file extension is allowed
    if (in_array($file_extension, $allowed_extensions)) {
        // Establish a database connection (replace with your database credentials)
        $mysqli = new mysqli("localhost", "root", "", "medidocx");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Get the contents of the uploaded file
        $image_data = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));

        // Prepare and execute SQL query to insert image data into the database
        $sql = "INSERT INTO images (image_data) VALUES ('$image_data')";
        if ($mysqli->query($sql) === TRUE) {
            echo "Image uploaded and inserted into database successfully.";
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




// session_start();

// Check if file was uploaded without errors
// if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
//     $allowed_extensions = array("jpg", "jpeg", "png", "gif");
//     $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

//     // Check if the file extension is allowed
//     if (in_array($file_extension, $allowed_extensions)) {
//         // Define upload directory
//         $upload_dir = "uploads/";

//         // Generate a unique filename for the uploaded image
//         $filename = uniqid() . '.' . $file_extension;

//         // Move the uploaded file to the upload directory
//         if (move_uploaded_file($_FILES["file"]["tmp_name"], $upload_dir . $filename)) {
//             // Return the URL of the uploaded image
//             echo $upload_dir . $filename;
//             exit;
//         } else {
//             echo "Error: Failed to move uploaded file.";
//         }
//     } else {
//         echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
//     }
// }


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <style>
        #avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }
    </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <h2>Click on the avatar to upload an image:</h2>
    <img id="avatar" src="getImage.php" alt="Avatar" onclick="handleImageUpload()">
    <script>
        // Function to handle image upload
        // Function to handle image upload
        // Function to handle image upload
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



                    const formData = new FormData();
                    formData.append('file', file);

                    // Send the file to the server using fetch API
                    fetch('imageUpload.php', {
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
                                    window.location.reload();
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

</body>

</html>