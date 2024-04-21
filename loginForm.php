
<html>


<body>
    <div id="loginForm">
        <form action="index.php" method="POST">
            <h1>Log In</h1>
            <label>
                <h3>Email</h3>
                <input type="" name="email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
            </label>
            <label>
                <h3>Password</h3>
                <input type="password" name="password" />
            </label>
            <div id="forgetPwd" onclick = "sendOTP()">Forgot password?</div>
            <button type="submit" name="login">Log In</button>
            <div id="signUp">Don't have an account? <a href="#" id="signupNow">Sign Up</a></div>
            <img id="closeLogin" src="./closeButton.png" alt="" />
        </form>
    </div>
</body>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

</html>


<?php


if (isset($_POST['login'])) {
    //    session_start();
    include 'connection.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = md5($password);
    $errors = array();
    $errors1 = array();




    $sql = "SELECT * FROM patient WHERE patientEmail = '{$email}'";
    $sql1 = "SELECT * FROM doctor WHERE doctorEmail = '{$email}'";
    $sql2 = "SELECT * FROM lab_technician WHERE technicianEmail = '{$email}'";

    



    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $password = $row['password'];
        $patientEmail = $row['patientEmail'];
        $_SESSION['patientEmail'] = $patientEmail;
        if ($row['isVerified'] == 1) {
            if ($password === $passwordHash) {
                $_SESSION['name'] = $row['name'];
                // $_SESSION['email'] = $row['email'];
                // $_SESSION['name'] = $row['email'];
                // $_SESSION['role'] = 'patient';
                // $_SESSION['email'] = '$email'

                ?>
                <script>
                    // Redirect to patient.php on successful login
                    window.location.href = "patient.php";
                </script>
                <?php

            } else {
                $errors['password'] = 'Invalid password';
                ?>

                <script>
                    swal({
                        title: "Error",
                        text: "<?php echo $errors['password']; ?>",
                        icon: "error",
                        button: "Ok",
                    });

                </script>
                <?php
            }
        } else {
            $errors['email'] = 'Email is not verified';
            $errors1['email'] = 'Please verify your email';
            ?>
            <script>
                swal({
                    title: "Error",
                    text: "<?php echo $errors['email']; ?>\n" +
                        "<?php echo $errors1['email']; ?>",
                    icon: "error",
                    button: "Ok",
                });

            </script>
            <?php
        }
    } else if (mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $password = $row['password'];
        $doctorEmail = $row['doctorEmail'];
        $_SESSION['doctorEmail'] = $doctorEmail;
        if ($row['isVerified'] == 1) {
            if ($password === $passwordHash) {
                $_SESSION['name'] = $row['name'];
                // $_SESSION['email'] = $email;
                // $_SESSION['role'] = 'doctor';

                ?>
                    <script>
                        // Redirect to doctor.php on successful login
                        window.location.href = "doctor.php";
                    </script>
                <?php

            } else {
                $errors['password'] = 'Invalid password';
                ?>

                    <script>
                        swal({
                            title: "Error",
                            text: "<?php echo $errors['password']; ?>",
                            icon: "error",
                            button: "Ok",
                        });

                    </script>
                <?php
            }
        } else {
            $errors['email'] = 'Email is not verified';
            $errors1['email'] = 'Please verify your email';
            ?>
                <script>
                    swal({
                        title: "Error",
                        text: "<?php echo $errors['email']; ?>\n" +
                            "<?php echo $errors1['email']; ?>",
                        icon: "error",
                        button: "Ok",
                    });

                </script>
            <?php
        }
    } else if (mysqli_num_rows($result2) > 0) {
        $row = mysqli_fetch_assoc($result2);
        $password = $row['password'];
        $technicianEmail = $row['technicianEmail'];
        $_SESSION['technicianEmail'] = $technicianEmail;
        if ($row['isVerified'] == 1) {
            if ($password === $passwordHash) {
                $_SESSION['name'] = $row['name'];
                // $_SESSION['email'] = $row['email'];
                // $_SESSION['role'] = 'labTechnician';

                ?>
                        <script>
                            // Redirect to labTechnician.php on successful login
                            window.location.href = "labTechnician.php";
                        </script>
                <?php

            } else {
                $errors['password'] = 'Invalid password';
                ?>

                        <script>
                            swal({
                                title: "Error",
                                text: "<?php echo $errors['password']; ?>",
                                icon: "error",
                                button: "Ok",
                            });

                        </script>
                <?php
            }
        } else {
            $errors['email'] = 'Email is not verified';
            $errors1['email'] = 'Please verify your email';
            ?>
                    <script>
                        swal({
                            title: "Error",
                            text: "<?php echo $errors['email']; ?>\n" +
                                "<?php echo $errors1['email']; ?>",
                            icon: "error",
                            button: "Ok",
                        });

                    </script>
            <?php
        }
    } else {
        $errors['account'] = 'User not registered yet';

        ?>
                <script>
                    swal({
                        title: "Error",
                        text: "<?php echo $errors['account']; ?>",


                        icon: "error",
                        button: "Ok",

                    });
                </script>

        <?php
    }







}



?>