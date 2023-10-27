<html>

<body>
    <div id="signupForm">
        <form action="index.php" method="POST">
            <label>
                <h1>Sign Up</h1>
                <h3>Name</h3>
                <input type="text" name="name" />
            </label>
            <label>
                <h3>Date of Birth</h3>
                <input type="date" name="birthDate" />
            </label>
            <label id="radioLabel">
                <h3>Gender</h3>
                <label class="radioButtonLabel" style="cursor:pointer">
                    <input class="radio" type="radio" value="Male" name="gender" style="cursor:pointer" />Male</label>
                <label class="radioButtonLabel" style="cursor:pointer">
                    <input class="radio" type="radio" value="Female" name="gender"
                        style="cursor:pointer" />Female</label>
                <label class="radioButtonLabel" style="cursor:pointer">
                    <input class="radio" type="radio" value="Other" name="gender" style="cursor:pointer" />Other</label>
            </label>
            <label>
                <h3>Address</h3>
                <input type="text" name="address">
            </label>
            <label>
                <h3>Email</h3>
                <input type="" name="email" />
            </label>
            <label>
                <h3>Password</h3>
                <input type="password" name="password" />
            </label>
            <label>
                <h3>Are you a</h3>
                <label>
                    <select name="type" id="userType" onchange="showDoctorIdField()"
                        style="outline:none; cursor:pointer">
                        <option value="Patient">Patient</option>
                        <option value="Doctor">Doctor</option>
                    </select>
                </label>
            </label>
            <label id="doctorId" style="display:none">
                <h3>Doctor Id</h3>
                <input type="" name="ID">
                <input type="hidden" name="type_field" id="type_field">
            </label>
            <!-- <div id="forgetPwd">Forgot password?</div> -->
            <label id="checkboxLabel">
                <input id="checkbox" type="checkbox" name="checkbox" style="cursor:pointer" />Agree all the terms and
                conditions</label>
            <button type="submit" name="register">Sign Up</button>
            <div id="logIn">Already have an account? <a href="#" id="login-link">Log In</a></div>
            <img id="closeButton" class="closeSignupForm" src="./closeButton.png" alt="" />
        </form>
    </div>
</body>

<script>
    function showDoctorIdField() {
        var selectElement = document.getElementById("userType");
        var doctorIdField = document.getElementById("doctorId");

        if (selectElement.value === "Doctor") {
            doctorIdField.style.display = "block";
        } else {
            doctorIdField.style.display = "none";
        }
    }




    var checkbox = document.getElementById("checkbox");
    var signUpButton = document.querySelector('button[name="register"]');

    signUpButton.addEventListener("click", function (event) {
        if (!checkbox.checked) {
            event.preventDefault(); // Prevent the form from submitting
            swal({
                title: "Error",
                text: "Please agree to the terms and condition",
                // icon: "error",
                button: "Ok",

            });
            document.querySelector('#signupForm').style.display = "block";
        }
    });

</script>

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



    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;

    $sql = "SELECT email FROM patient WHERE email = '$email' UNION SELECT email FROM doctor WHERE email = '$email'";



    $result = mysqli_query($conn, $sql);



    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid.";
        ?>
        <script>
            swal({
                title: "Error",
                text: "<?php echo $errors['email']; ?>",
                // icon: "error",
                button: "Ok",
            });
            document.querySelector('#signupForm').style.display = "block";
        </script>
        <?php
    } elseif (mysqli_num_rows($result) > 0) {
        $errors["email"] = "Email is already in use.";
        ?>
        <script>
            swal({
                title: "Error",
                text: "<?php echo $errors['email']; ?>",
                // icon: "error",
                button: "Ok",
            });
            document.querySelector('#signupForm').style.display = "block";
        </script>
        <?php
    }



    if (strlen($password) < 8) {
        $errors['password'] = "Password must be 8 characters long";
        ?>
        <script>
            swal({
                title: "Error",
                text: "<?php echo $errors['password']; ?>\n" +
                    "Please enter the correct Id provided by the hospital administrator",
                // icon: "error",
                button: "Ok",

            });
            document.querySelector('#signupForm').style.display = "block";
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
                // icon: "error",
                button: "Ok",

            });
            document.querySelector('#signupForm').style.display = "block";
        </script>

        <?php
    }

    if ($type === "Doctor") {
        $enteredDoctorName = $_POST["name"];

        // Fetch valid doctor IDs from the hospital table based on the doctor's first name
        $hospitalQuery = "SELECT id FROM hospital WHERE name = '{$enteredDoctorName}'";
        $hospitalResult = mysqli_query($conn, $hospitalQuery);

        if (mysqli_num_rows($hospitalResult) > 0) {
            $row = mysqli_fetch_assoc($hospitalResult);
            $validDoctorID = $row["id"];

            if ($ID != $validDoctorID) {
                $errors['id'] = "Invalid Doctor ID.";
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "<?php echo $errors['id']; ?>",
                        // icon: "error",
                        button: "Ok",
                    });
                    document.querySelector('#signupForm').style.display = "block";
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
                    // icon: "error",
                    button: "Ok",
                });
                document.querySelector('#signupForm').style.display = "block";
            </script>
            <?php
        }
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

                document.querySelector('#signupForm').style.display = "none";
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