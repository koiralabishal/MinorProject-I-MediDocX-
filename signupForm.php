<html>

<body>
    <div id="signupForm">
        <form action="">
            <label>
                <h1>Sign Up</h1>
                <h3>Name</h3>
                <input type="
          text" />
            </label>
            <label>
                <h3>Date of Birth</h3>
                <input type="date" />
            </label>
            <label id="radioLabel">
                <h3>Gender</h3>
                <label class="radioButtonLabel">
                    <input class="radio" type="radio" for="Gender" name="Gender" />Male</label>
                <label class="radioButtonLabel">
                    <input class="radio" type="radio" for="Gender" name="Gender" />Female</label>
                <label class="radioButtonLabel"><input class="radio" type="radio" for="Gender"
                        name="Gender" />Other</label>
            </label>
            <label>
                <h3>Address</h3>
                <input type="text">
            </label>
            <label>
                <h3>Email</h3>
                <input type="email" />
            </label>
            <label>
                <h3>Password</h3>
                <input type="password" />
            </label>
            <label>
                <h3>Are you a</h3>
                <label>
                    <select name="role" id="">
                        <option value="Patient">Patient</option>
                        <option value="Doctor">Doctor</option>
                    </select>
                </label>
            </label>
            <div id="forgetPwd">Forgot password?</div>
            <label id="checkboxLabel">
                <input id="checkbox" type="checkbox" />Agree all the terms and
                conditions</label>
            <button type="submit">Sign Up</button>
            <div id="logIn">Already have an account? <a href="">Log In</a></div>
            <img id="closeButton" src="./closeButton.png" alt="" />
        </form>
    </div>
</body>

</html>