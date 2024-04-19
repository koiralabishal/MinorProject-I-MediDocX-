<?php
session_start();
include ('connection.php');

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log out</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <script>
        // Show SweetAlert confirmation dialog when the page is loaded
        
        
        window.onload = function () {
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: ["Cancel", "Yes"], // Customize the buttons
                dangerMode: true, // Highlight the "Yes" button in red
            }).then((willLogout) => {
                if (willLogout) {
                    window.location.href = 'index.php'; // Redirect to index.php
                } else {
                    // Do nothing or display a message
                    swal("You can continue browsing!", {
                        icon: "success",
                    });
                }
            });
        };
        
    </script>
</body>

</html>