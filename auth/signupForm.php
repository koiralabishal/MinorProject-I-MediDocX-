<html>

<head>
    <link rel="stylesheet" href="scripts/custom-sweertalert.php">
</head>

<body>


    <div id="signupForm">



        <form action="index.php" method="POST">


            <label>
                <h1>Sign Up</h1>
                <h3>Name</h3>
                <input type="text" name="name"
                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />
            </label>
            <label>
                <h3>Date of Birth</h3>
                <input type="date" name="birthDate"
                    value="<?php echo isset($_POST['birthDate']) ? htmlspecialchars($_POST['birthDate']) : ''; ?>" />
            </label>
            <label id="radioLabel">
                <h3>Gender</h3>
                <label class="radioButtonLabel" style="cursor:pointer">
                    <input class="radio" type="radio" value="Male" name="gender" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'checked' : ''; ?> />Male</label>
                <label class="radioButtonLabel" style="cursor:pointer">
                    <input class="radio" type="radio" value="Female" name="gender" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?> />Female</label>
                <label class="radioButtonLabel" style="cursor:pointer">
                    <input class="radio" type="radio" value="Other" name="gender" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Other') ? 'checked' : ''; ?> />Other</label>
            </label>
            <label>
                <h3>Address</h3>
                <input type="text" name="address"
                    value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
            </label>
            <label>
                <h3>Email</h3>
                <input type="" name="email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
            </label>
            <label>
                <h3>Password</h3>
                <input type="password" name="password" />
            </label>

            <label id="dropdownLabel">
                <div class="custom-dropdown">
                    <div class="dropdown-button" onclick="toggleDropdown()">
                        <span class="dropdown-label">Sign up as a</span>
                        <span class="dropdown-icon"></span>
                    </div>
                    <div class="dropdown-options" id="custom-dropdown-options">
                        <ul>
                            <li class="dropdown-option" onclick="selectOption('Patient')" value="Patient">
                                Patient
                            </li>
                            <li class="dropdown-option" onclick="selectOption('Doctor')" value="Doctor">
                                Doctor
                            </li>
                            <li class="dropdown-option" onclick="selectOption('Lab Technician')" value="Lab Technician">
                                Lab Technician
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Custom dropdown closed -->
                <input type="hidden" value="" name="type" id="selectedType">
            </label>


            <label id="doctorID">
                <h3>Doctor ID</h3>
                <input type="" name="ID1"
                    value="<?php echo isset($_POST['ID']) ? htmlspecialchars($_POST['ID']) : ''; ?>">
                <!-- <input type="hidden" name="type_field" id="type_field"> -->
            </label>

            <label id="patientID">
                <h3>Patient ID</h3>
                <input type="" name="ID2"
                    value="<?php echo isset($_POST['ID']) ? htmlspecialchars($_POST['ID']) : ''; ?>">
                <!-- <input type="hidden" name="type_field" id="type_field"> -->
            </label>


            <label id="labTechnicianID">
                <h3>Lab Technician ID</h3>
                <input type="" name="ID3"
                    value="<?php echo isset($_POST['ID']) ? htmlspecialchars($_POST['ID']) : ''; ?>">
                <!-- <input type="hidden" name="type_field" id="type_field"> -->
            </label>

            <!-- <div id="forgetPwd">Forgot password?</div> -->
            <div class="justText">
                By continuing, you agree to MediDocX's
                <a href="">Terms and Conditions</a> and <a href="">Privacy Policy</a>.
            </div>
            <button type="submit" name="register">Sign Up</button>
            <div class="justText">
                Already have an account? <a href="#" id="loginNow">Log In</a>
            </div>
            <img id="closeSignup" src="assets/img/closeButton.png" alt="" onclick="closeBtn()" />
        </form>

    </div>
</body>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</html>


<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["register"])) {
    include __DIR__ . '/../config/connection.php';
    $name = $_POST["name"];
    $email = $_POST["email"];
    $type = $_POST["type"];
    $ID1 = $_POST["ID1"];
    $ID2 = $_POST["ID2"];
    $ID3 = $_POST["ID3"];
    $birthDate = $_POST["birthDate"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;

    $address = $_POST["address"];
    $password = $_POST["password"];

    $passwordHash = md5($password);
    $errors = array();
    $errors1 = array();


    $_SESSION['name'] = $name;
    // $_SESSION['email'] = $email;
    $_SESSION['ID1'] = $ID1;

    session_write_close();

    $sql = "SELECT patientEmail FROM patient WHERE patientEmail = '$email' UNION SELECT doctorEmail  FROM doctor WHERE doctorEmail = '$email' UNION SELECT technicianEmail  FROM lab_technician WHERE technicianEmail = '$email'";
    $sql1 = "SELECT doctorID FROM doctor WHERE doctorID = '$ID1'";
    $sql2 = "SELECT patientID FROM patient WHERE patientID = '$ID2'";
    $sql3 = "SELECT labTechnicianID FROM lab_technician WHERE labTechnicianID = '$ID3'";


    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);
    $result3 = mysqli_query($conn, $sql3);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid.";
        ?>
        <script>
            swal({
                title: "Error",
                text: "<?php echo $errors['email']; ?>",
                icon: "error",
                button: "Ok",
            });

        </script>
        <?php
    } elseif (mysqli_num_rows($result) > 0) {
        $errors["email"] = "Email is already in use.";
        ?>
        <script>
            swal({
                title: "Error",
                text: "<?php echo $errors['email']; ?>",
                icon: "error",
                button: "Ok",
            });

        </script>
        <?php
    }








    if (strlen($password) < 8) {
        $errors['password'] = "Password must be 8 characters long";
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




    if ($type === "Doctor") {

        $enteredDoctorEmail = $_POST["email"];


        $hospitalQuery = "SELECT doctorID FROM hospital WHERE email = '{$enteredDoctorEmail}' AND userType = 'Doctor'";



        $hospitalResult = mysqli_query($conn, $hospitalQuery);


        if (mysqli_num_rows($hospitalResult) > 0) {
            $row = mysqli_fetch_assoc($hospitalResult);
            $validDoctorID = $row["doctorID"];

            if ($ID1 != $validDoctorID) {
                $errors['id'] = "Invalid Doctor ID.";
                ?>
                <script>

                    swal({
                        title: "Error",
                        text: "<?php echo $errors['id']; ?>",
                        icon: "error",
                        button: "Ok",
                    });

                </script>
                <?php
            }
        } else {
            $errors['id'] = "ID not found in the hospital records.";
            ?>
            <script>
                swal({
                    title: "Error",
                    text: "<?php echo $errors['id']; ?>",
                    icon: "error",
                    button: "Ok",
                });

            </script>
            <?php
        }
    } else if ($type === "Patient") {

        $enteredPatientEmail = $_POST["email"];


        $hospitalQuery1 = "SELECT patientID FROM new_patient WHERE email = '{$enteredPatientEmail}'";



        $hospitalResult1 = mysqli_query($conn, $hospitalQuery1);
        if (mysqli_num_rows($hospitalResult1) > 0) {
            $row1 = mysqli_fetch_assoc($hospitalResult1);
            $validPatientID = $row1["patientID"];

            if ($ID2 != $validPatientID) {
                $errors['id'] = "Invalid Patient ID.";

                ?>
                    <script>

                        swal({
                            title: "Error",
                            text: "<?php echo $errors['id']; ?> ",
                            icon: "error",
                            button: "Ok",
                        });

                    </script>
                <?php
            }
        } else {
            $errors['id'] = "ID not found in the hospital records.";
            ?>
                <script>
                    swal({
                        title: "Error",
                        text: "<?php echo $errors['id']; ?>",
                        icon: "error",
                        button: "Ok",
                    });

                </script>
            <?php
        }
    } else if ($type === "Lab Technician") {

        $enteredLabTechnicianEmail = $_POST["email"];


        $hospitalQuery2 = "SELECT labTechnicianID FROM hospital WHERE email = '{$enteredLabTechnicianEmail}' AND userType = 'Lab Technician'";



        $hospitalResult2 = mysqli_query($conn, $hospitalQuery2);
        if (mysqli_num_rows($hospitalResult2) > 0) {
            $row2 = mysqli_fetch_assoc($hospitalResult2);
            $validLabTechnicianID = $row2["labTechnicianID"];

            if ($ID3 != $validLabTechnicianID) {
                $errors['id'] = "Invalid Lab Technician ID.";

                ?>
                        <script>

                            swal({
                                title: "Error",
                                text: "<?php echo $errors['id']; ?>",
                                icon: "error",
                                button: "Ok",
                            });

                        </script>
                <?php
            }
        } else {
            $errors['id'] = "ID not found in the hospital records.";
            ?>
                    <script>
                        swal({
                            title: "Error",
                            text: "<?php echo $errors['id']; ?>",
                            icon: "error",
                            button: "Ok",
                        });

                    </script>
            <?php
        }
    }



    if ($type === "Doctor") {
        if (empty($ID1)) {
            ?>
            <script>

                swal({
                    title: "Error",
                    text: "Doctor ID is required",
                    icon: "error",
                    button: "Ok",
                });



            </script>
            <?php
        } else if (mysqli_num_rows($result1) > 0) {
            ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Doctor ID is already in use",
                        icon: "error",
                        button: "Ok",
                    });

                </script>
            <?php
        }
    } else if ($type === "Patient") {
        if (empty($ID2)) {
            ?>
                <script>

                    swal({
                        title: "Error",
                        text: "Patient ID is required",
                        icon: "error",
                        button: "Ok",
                    });



                </script>
            <?php
        } else if (mysqli_num_rows($result2) > 0) {
            ?>
                    <script>
                        swal({
                            title: "Error",
                            text: "Patient ID is already in use",
                            icon: "error",
                            button: "Ok",
                        });

                    </script>
            <?php
        }
    } else if ($type === "Lab Technician") {
        if (empty($ID3)) {
            ?>
                    <script>

                        swal({
                            title: "Error",
                            text: "Lab Technician ID is required",
                            icon: "error",
                            button: "Ok",
                        });



                    </script>
            <?php
        } else if (mysqli_num_rows($result3) > 0) {
            ?>
                        <script>
                            swal({
                                title: "Error",
                                text: "Lab Technician ID is already in use",
                                icon: "error",
                                button: "Ok",
                            });

                        </script>
            <?php
        }

    }


    if (empty($name) || empty($gender) || empty($email) || empty($birthDate) || empty($address) || empty($password)) {
        $errors['empty'] = "All fields are required";
        ?>
        <script>

            swal({
                title: "Error",
                text: "<?php echo $errors['empty']; ?>",
                icon: "error",
                button: "Ok",

            });


        </script>
        <?php
    }













    if (empty($type)) {
        $errors["type"] = "Please select user type";
        ?>
        <script>
            swal({
                title: "Error",
                text: "<?php echo $errors["type"]; ?>",
                icon: "error",
                button: "Ok",

            });

        </script>

        <?php
    }















    if (count($errors) == 0) {
        // Define the SQL query to insert data into the appropriate table

        $v_code = bin2hex(random_bytes(16));
        $_SESSION['v_code'] = $v_code;






        if ($type === "Patient") {
            $query = "INSERT INTO patient (name, patientEmail, birthDate,gender, address, patientID, password, verificationCode, isVerified)
            VALUES ('$name', '$email', '$birthDate', '$gender','$address', '$ID2', '$passwordHash', '$v_code', '0')";
        } elseif ($type === "Doctor") {
            $query = "INSERT INTO doctor (name, doctorEmail, doctorID, birthDate, gender, address, password, verificationCode, isVerified)
            VALUES ('$name', '$email', '$ID1', '$birthDate','$gender','$address', '$passwordHash', '$v_code', '0')";
        } elseif ($type === "Lab Technician") {
            $query = "INSERT INTO lab_technician (name, technicianEmail, labTechnicianID, birthDate, gender, address, password, verificationCode, isVerified)
            VALUES ('$name', '$email', '$ID3', '$birthDate','$gender','$address', '$passwordHash', '$v_code', '0')";
        }

        if (mysqli_query($conn, $query)) {



            ?>
            <script>
                swal({
                    title: "Registration Successful",
                    text: "Verification link is sent to your email\n" +
                        "Please check your email",
                    icon: "success",
                    button: "Ok",
                });

                // document.querySelector('#signupForm').style.transform = "scale(0)";
            </script>
            <?php




        }
        // require("./PHPMailer/PHPMailer.php");
        // require("./PHPMailer/SMTP.php");
        // require("./PHPMailer/Exception.php");

        $mail = new PHPMailer(true);


        try {

            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER') ?: 'koiralabishal3@gmail.com';
            $mail->Password = getenv('SMTP_PASS') ?: 'rtvxlvouimebormx';
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPSecure = getenv('SMTP_SECURE') ?: 'tls';
            $mail->Port = getenv('SMTP_PORT') ?: 587;


            $mail->setFrom(getenv('SMTP_USER') ?: 'koiralabishal3@gmail.com', 'MediDocX');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Email verification from MediDocX Team';
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            // If we are on localhost, include the subdirectory path. Otherwise (on Vercel), assume root.
            $path = ($host === 'localhost') ? '/dashboard/MinorProject-I-MediDocX-' : '';
            $actual_link = "$protocol://$host$path/index.php?email=$email&v_code=$v_code";

            $mail->Body = "<p style='font-size: 25px;'>Hi, {$_SESSION['name']}. Thanks for registration! <br />
                           Click the link below to verify the email address. <br />
                           <b><i><a href = '$actual_link'>Verify</a></i></b></p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}

?>