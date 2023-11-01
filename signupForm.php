<html>

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
                        </ul>
                    </div>
                </div>
                <!-- Custom dropdown closed -->
                <input type="hidden" value="" name="type" id="selectedType">
            </label>


            <label id="doctorID">
                <h3>Doctor ID</h3>
                <input type="" name="ID"
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
            <img id="closeSignup" src="./closeButton.png" alt="" onclick="closeBtn()" />
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
    include 'connection.php';
    $name = $_POST["name"];
    $email = $_POST["email"];
    $type = $_POST["type"];
    $ID = $_POST["ID"];
    $birthDate = $_POST["birthDate"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;

    $address = $_POST["address"];
    $password = $_POST["password"];

    $passwordHash = md5($password);
    $errors = array();
    $errors1 = array();


    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;

    $sql = "SELECT email FROM patient WHERE email = '$email' UNION SELECT email  FROM doctor WHERE email = '$email'";
    $sql1 = "SELECT doctorID FROM doctor WHERE doctorID = '$ID'";


    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_query($conn, $sql1);


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

        // Fetch valid doctor IDs from the hospital table based on the doctor's first name
        $hospitalQuery = "SELECT doctorID FROM hospital WHERE email = '{$enteredDoctorEmail}'";
        $hospitalResult = mysqli_query($conn, $hospitalQuery);

        if (mysqli_num_rows($hospitalResult) > 0) {
            $row = mysqli_fetch_assoc($hospitalResult);
            $validDoctorID = $row["doctorID"];

            if ($ID != $validDoctorID) {
                $errors['id'] = "Invalid Doctor ID.";
                $errors1['id'] = "Please enter the correct Id provided by the hospital administrator";
                ?>
                <script>

                    swal({
                        title: "Error",
                        text: "<?php echo $errors['id']; ?>\n" + "<?php echo $errors1['id']; ?>",
                        icon: "error",
                        button: "Ok",
                    });

                </script>
                <?php
            }
        } else {
            $errors['id'] = "Doctor not found in the hospital records.";
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
        if (empty($ID)) {
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



   

    if ($type === "Doctor") {

        ?>

        <script>
            document.querySelector('#doctorID').style.display = 'block';
            document.querySelector('.dropdown-label').textContent = 'Doctor';
        </script>
        <?php
    } else if ($type === "Patient") {
        ?>

            <script>
                document.querySelector('#doctorID').style.display = 'none';
                document.querySelector('.dropdown-label').textContent = 'Patient';
            </script>
        <?php
    }




    // Validate form fields
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





    if ($errors || $errors1) {
        ?>
        <script>
            document.querySelector('#signupForm').style.transform = 'scale(1)';

        </script>

        <?php

       

    }












    if (count($errors) == 0) {
        // Define the SQL query to insert data into the appropriate table

        $v_code = bin2hex(random_bytes(16));
        $_SESSION['v_code'] = $v_code;






        if ($type === "Patient") {
            $query = "INSERT INTO patient (name, email, birthDate,gender, address, password, verificationCode, isVerified)
                    VALUES ('$name', '$email', '$birthDate', '$gender','$address','$passwordHash', '$v_code', '0')";
        } elseif ($type === "Doctor") {
            $query = "INSERT INTO doctor (name, email, doctorID, birthDate, gender, address, password, verificationCode, isVerified)
                    VALUES ('$name', '$email', '$ID', '$birthDate','$gender','$address', '$passwordHash', '$v_code', '0')";
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

                document.querySelector('#signupForm').style.transform = "scale(0)";
            </script>
            <?php




        }
        require("./PHPMailer/PHPMailer.php");
        require("./PHPMailer/SMTP.php");
        require("./PHPMailer/Exception.php");

        $mail = new PHPMailer(true);


        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'koiralabishal3@gmail.com';
            $mail->Password = 'rtvxlvouimebormx';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('koiralabishal3@gmail.com', 'MediDocX');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Email verification from MediDocX Team';
            $mail->Body = "<p style='font-size: 25px;'>Hi, {$_SESSION['name']}. Thanks for registration! <br />
                        Click the link below to verify the email address. <br />
                        <b><i><a href = 'http://localhost/dashboard/MinorProject-I-MediDocX-/index.php?email=$email&v_code=$v_code'>Verify</a></i></b></p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}
?>