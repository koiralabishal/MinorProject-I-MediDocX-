<html>

<body>
    <div id="loginForm">
        <form action="index.php" method="POST">
            <h1>Log In</h1>
            <label>
                <h3>Email</h3>
                <input type="" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"/>
            </label>
            <label>
                <h3>Password</h3>
                <input type="password" name="password" />
            </label>
            <div id="forgetPwd">Forgot password?</div>
            <button type="submit" name="login">Log In</button>
            <div id="signUp">Don't have an account? <a href="#" id="signupNow">Sign Up</a></div>
            <img id="closeLogin" src="./closeButton.png" alt="" />
        </form>
    </div>
</body>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</html>


<?php


if (isset($_POST['login'])) {
    include 'connection.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = md5($password);



    $_SESSION['email'] = $email;

    $sql = "SELECT * FROM patient WHERE email = '{$email}'";
    $sql1 = "SELECT * FROM doctor WHERE email = '{$email}'";

    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $password = $row['password'];
        $dbemail = $row['email'];
        if ($row['isVerified'] == 1) {
            if ($password === $passwordHash) {
                ?>
                <script>
                    // Redirect to dashboard.php on successful login
                    window.location.href = "dashboard.php";
                </script>
                <?php

            } else {
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Invalid password ",
                        icon: "error",
                        button: "Ok",
                    });
                    document.querySelector('#loginForm').style.display = "block";
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                swal({
                    title: "Error",
                    text: "Email is not verified.\n" +
                        "Please verify your email",
                    icon: "error",
                    button: "Ok",
                });
                document.querySelector('#loginForm').style.display = "block";
            </script>
            <?php
        }
    } else if (mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $password = $row['password'];
        $dbemail = $row['email'];
        if ($row['isVerified'] == 1) {
            if ($password === $passwordHash) {

                ?>
                    <script>
                        // Redirect to dashboard.php on successful login
                        window.location.href = "dashboard.php";
                    </script>
                <?php

            } else {
                ?>
                    <script>
                        swal({
                            title: "Error",
                            text: "Invalid password",
                            icon: "error",
                            button: "Ok",
                        });
                        document.querySelector('#loginForm').style.display = "block";
                    </script>
                <?php
            }
        } else {
            ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Email is not verified.\n" +
                            "Please verify your email",
                        icon: "error",
                        button: "Ok",
                    });
                    document.querySelector('#loginForm').style.display = "block";
                </script>
            <?php
        }
    } else {
        ?>
            <script>
                swal({
                    title: "Error",
                    text: "User not found",
                    icon: "error",
                    button: "Ok",
                });
                document.querySelector('#loginForm').style.display = "block";
            </script>
        <?php
    }


}

?>