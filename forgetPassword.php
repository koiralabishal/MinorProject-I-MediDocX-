<?php
session_start();
include 'dbConnect.php';
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ("./PHPMailer/PHPMailer.php");
require ("./PHPMailer/SMTP.php");
require ("./PHPMailer/Exception.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['send_otp'])) {
        // Get email from POST data
        $email = $_POST['email'];


        // SQL query to check if email exists in the database
        $sqlEmailQuery = "SELECT 'user' AS tableName, 'email' AS emailAttr FROM user WHERE email = '$email'";

        // Execute the query
        $resultEmail = mysqli_query($conn, $sqlEmailQuery);

        // Check for errors in the query execution
        if (!$resultEmail) {
            echo json_encode(['success' => false, 'message' => 'Query execution error: ' . mysqli_error($conn)]);
            exit;
        }


        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Invalid email format']);
            exit;
        }

        // Check if email exists in the database
        if (mysqli_num_rows($resultEmail) > 0) {
            $row = mysqli_fetch_assoc($resultEmail);
            $tableName = $row['tableName'];
            // echo $tableName;
            $emailAttr = $row['emailAttr'];
            $_SESSION['tableName'] = $tableName;
            $_SESSION['emailAttr'] = $emailAttr;
            // Email exists, proceed with sending OTP
            $otp = rand(100000, 999999);
            $subject = 'Your OTP for password reset';
            $message = '<div style="font-size: 25px;">Your OTP is: <strong>' . $otp . '</strong></div>';

            // Initialize PHPMailer
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'koiralabishal3@gmail.com';
                $mail->Password = 'rtvxlvouimebormx';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('koiralabishal3@gmail.com', 'MediDocX');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message;

                // Send email
                $mail->send();

                // Store OTP and user email in session
                $_SESSION['otp'] = $otp;
                $_SESSION['userEmail'] = $email;

                echo json_encode(['success' => true]);
                exit;
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
                exit;
            }
        } else {
            // Email does not exist in the database
            echo json_encode(['success' => false, 'message' => 'Email does not exist']);
            exit;
        }

    } elseif (isset($_POST['verify_otp'])) {
        // Verify OTP
        $otp = $_POST['otp'];
        if ($_SESSION['otp'] == $otp) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
        }
        exit;
    } elseif (isset($_POST['change_password'])) {
        // Update password
        $newPassword = $_POST['new_password'];



        // SQL query to update password
        $sqlUpdateQuery = "UPDATE {$_SESSION['tableName']} SET password = '$newPassword' WHERE {$_SESSION['emailAttr']} = '{$_SESSION['userEmail']}'";
        $resultUpdate = mysqli_query($conn, $sqlUpdateQuery);

        if ($resultUpdate) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update password']);
            exit;
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<script>
    function sendOTP() {
        swal("Enter your email:", {
            content: "input",
            buttons: {
                cancel: true,
                confirm: {
                    text: "Send OTP",
                    closeModal: false,
                },
            },
        }).then((value) => {
            if (value !== null) {
                if (value) {
                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'email=' + encodeURIComponent(value) + '&send_otp=1',
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                swal("OTP Sent", "An OTP has been sent to your email. Please check your inbox.", "success")
                                    .then(() => {
                                        enterOTP();
                                    });
                            } else {
                                swal("Error", data.message || "Failed to send OTP", "error")
                                    .then(() => {
                                        sendOTP();
                                    });
                            }
                        });
                } else {
                    // Display error message if email is empty
                    swal("Error", "Please enter an email", "error")
                        .then(() => {
                            sendOTP();
                        });
                }
            }
        });
    }

    function enterOTP() {
        swal("Enter OTP:", {
            content: "input",
            buttons: {
                cancel: true,
                confirm: {
                    text: "Verify OTP",
                    closeModal: false,
                },
            },
        }).then((value) => {
            if (value !== null) {
                if (value) {
                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'otp=' + encodeURIComponent(value) + '&verify_otp=1',
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                swal("OTP Verified", "You have successfully verified your OTP.", "success")
                                    .then(() => {
                                        changePassword();
                                    });

                            } else {
                                swal("Error", data.message || "Invalid OTP", "error")
                                    .then(() => {
                                        enterOTP();
                                    });

                            }
                        });
                } else {
                    // Display error message if email is empty
                    swal("Error", "Please enter an OTP", "error")
                        .then(() => {
                            enterOTP();
                        });
                }
            }
        });
    }
    function changePassword() {
        swal({
            title: 'Enter New Password:',
            content: {
                element: "input",
                attributes: {
                    type: "password",
                    id: "new_password",
                    placeholder: "New Password"
                }
            },
            buttons: {
                cancel: true,
                confirm: {
                    text: "Next",
                    closeModal: false,
                }
            },
        }).then((newPassword) => {
            if (newPassword !== null) {
                if (newPassword) {
                    if (newPassword.length >= 8) {
                        swal({
                            title: 'Confirm New Password:',
                            content: {
                                element: "input",
                                attributes: {
                                    type: "password",
                                    id: "confirm_password",
                                    placeholder: "Confirm Password"
                                }
                            },
                            buttons: {
                                cancel: true,
                                confirm: {
                                    text: "Change Password",
                                    closeModal: false,
                                }
                            },
                        }).then((confirmPassword) => {
                            if (confirmPassword !== null) {
                                if (confirmPassword) {
                                    if (newPassword === confirmPassword) {
                                        fetch(window.location.href, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            },
                                            body: 'new_password=' + encodeURIComponent(newPassword) + '&change_password=1',
                                        })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    swal("Password Changed", data.message, "success");
                                                } else {
                                                    swal("Error", data.message || "Failed to change password", "error");
                                                }
                                            });
                                    } else {
                                        swal("Error", "Passwords do not match", "error")
                                            .then(() => {
                                                changePassword();
                                            });
                                    }
                                } else {
                                    swal("Error", "Please confirm password", "error")
                                        .then(() => {
                                            changePassword();
                                        });
                                }
                            }
                        });
                    } else {
                        swal("Error", "Passwords must be 8 character long", "error")
                            .then(() => {
                                changePassword();
                            });
                    }
                } else {
                    swal("Error", "Please enter new password", "error")
                        .then(() => {
                            changePassword();
                        });
                }

            }
        });

    }
</script>
<button onclick="sendOTP()">Forget Password</button>

</html>