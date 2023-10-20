<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MedidocX</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* font-size: 2vw; */
      }

      body {
        background-color: azure;
      }
      #title {
        background-color: lightblue;
        width: 100%;
        height: auto;
        padding: 1vh;
        display: flex;
        justify-content: space-around;
      }

      #invisibleDiv {
        flex: 0 2 30vw;
        /* background-color: blueviolet; */
      }
      #titleText {
        /* background-color: green; */
        flex: 0 0 30vw;
        padding: 1%;
        text-align: center;
        font-size: 1.5rem;
        color: rgb(38, 43, 39);
      }

      /* @media only screen and (max-width: 640px) {
        #invisibleDiv {
          display: none;
        }

        #titleText {
        }
      }

      @media only screen and (max-width: 320px) {
        #title {
          flex-direction: column;
        }
      } */

      #titleButtons {
        /* background-color: pink; */
        flex: 0 0 30vw;
        display: flex;
        justify-content: space-evenly;
        padding: 1%;
      }

      #titleButtons button {
        background-color: rgb(56, 169, 56);
        border-radius: 12px;
        border: none;
        flex: 0 0 auto;
        padding: 2% 6%;
        font: 1.2rem Arial;
        color: white;
        box-shadow: 0px 4px 4px rgb(186, 248, 186) inset, 1px 2px 4px darkgrey;
        cursor: pointer;
      }

      #titleButtons :nth-child(1) {
        background-color: transparent;
        padding: 0px;
        flex: 0 2 8%;
        box-shadow: 0px 0px;
      }

      #loginForm {
        width: 36vw;
        /* background-color: rgb(210, 210, 210); */
        background-color: rgb(232, 232, 252);
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        margin: 4vh auto;
        padding: 2%;
        /* padding-top: 0; */
        border-radius: 8px;
        box-shadow: 2px 2px 8px 4px silver;
        display: none;
      }

      #loginForm h1 {
        text-align: center;
        font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
        font-weight: lighter;
      }

      #loginForm label {
        display: block;
        margin: 6%;
      }

      #loginForm h3 {
        font-weight: lighter;
        font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
        color: rgb(38, 38, 38);
        margin: 1%;
      }

      #loginForm input {
        width: 100%;
        /* height: 16px; */
        margin-top: 2%;
        border: none;
        background-color: transparent;
        border-bottom: 1px solid rgb(38, 38, 38);
      }

      #loginForm #forgetPwd {
        margin-top: -2%;
        margin-left: 6%;
        color: rgb(52, 84, 125);
        cursor: pointer;
      }

      #loginForm #checkboxLabel {
        margin-top: 1%;
        color: rgba(0, 0, 0, 0.78);
      }

      #loginForm #checkbox {
        width: auto;
        margin-right: 2%;
      }

      #loginForm button {
        background-color: rgb(48, 48, 220);
        padding: 2% 6%;
        border-radius: 8px;
        border: none;
        color: white;
        font-size: 1.2rem;
        display: block;
        margin: auto auto;
        margin-top: -2%;
        box-shadow: 0px 4px 4px rgb(170, 170, 226) inset;
        cursor: pointer;
      }

      #loginForm #signUp {
        margin: 0 6%;
        margin-top: 4%;
      }

      #loginForm #signUp a {
        color: rgb(52, 84, 125);
        text-decoration: none;
      }

      #loginForm #closeButton {
        position: absolute;
        width: 6%;
        top: 2%;
        right: 2%;
        cursor: pointer;
      }

      #signupForm {
        width: 36vw;
        background-color: rgb(232, 232, 252);
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        margin: 4vh auto;
        padding: 2%;
        padding-top: 0;
        border-radius: 8px;
        box-shadow: 2px 2px 8px 4px silver;
        /* display: none; */
      }

      #signupForm h1 {
        text-align: center;
        font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
        font-weight: lighter;
      }

      #signupForm label {
        display: block;
        margin: 6%;
      }

      #signupForm h3 {
        font-weight: lighter;
        font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
        color: rgb(38, 38, 38);
        margin: 1%;
      }

      #signupForm input {
        width: 100%;
        /* height: 16px; */
        margin-top: 2%;
        border: none;
        background-color: transparent;
        border-bottom: 1px solid silver;
      }

      #signupForm #forgetPwd {
        margin-top: -2%;
        margin-left: 6%;
        color: rgb(52, 84, 125);
        cursor: pointer;
      }

      #signupForm #radioLabel {
        margin-top: 1%;
        color: rgba(0, 0, 0, 0.78);
      }

      #signupForm #radioLabel .radioButtonLabel{
        display: inline;
      }

      #signupForm .radio {
        width: auto;
        margin-right: 2%;
      }

      #signupForm #checkboxLabel {
        margin-top: 1%;
        color: rgba(0, 0, 0, 0.78);
      }

      #signupForm #checkbox {
        width: auto;
        margin-right: 2%;
      }

      #signupForm button {
        background-color: rgb(48, 48, 220);
        padding: 2% 6%;
        border-radius: 8px;
        border: none;
        color: white;
        font-size: 1.2rem;
        display: block;
        margin: auto auto;
        margin-top: -2%;
        box-shadow: 0px 4px 4px rgb(170, 170, 226) inset;
        cursor: pointer;
      }

      #signupForm #logIn {
        margin: 0 6%;
        margin-top: 4%;
      }

      #signupForm #logIn a {
        color: rgb(52, 84, 125);
        text-decoration: none;
      }

      #signupForm #closeButton {
        position: absolute;
        width: 6%;
        top: 2%;
        right: 2%;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <nav id="title">
      <div id="invisibleDiv"></div>
      <div id="titleText">
        <h1>MediDocX</h1>
      </div>
      <div id="titleButtons">
        <button></button>
        <button>Log In</button>
        <button>Sign Up</button>
      </div>
    </nav>
    <!-- <div id="loginForm">
      <form action="">
        <h1>Log In</h1>
        <label>
          <h3>Email</h3>
          <input type="email" />
        </label>
        <label>
          <h3>Password</h3>
          <input type="password" />
        </label>
        <div id="forgetPwd">Forgot password?</div>
        <button type="submit">Log In</button>
        <div id="signUp">Don't have an account? <a href="">Sign Up</a></div>
        <img id="closeButton" src="./closeButton.png" alt="" />
      </form>
    </div> -->
    <?php include "loginForm.php" ?>

    <!-- <div id="signupForm">
      <form action="">
        <label>
          <h1>Sign Up</h1>
          <h3>Name</h3>
          <input
            type="
          text"
          />
        </label>
        <label>
          <h3>Date of Birth</h3>
          <input type="date" />
        </label>
        <label id="radioLabel">
          <h3>Gender</h3>
          <label class="radioButtonLabel">
            <input
              class="radio"
              type="radio"
              for="Gender"
              name="Gender"
            />Male</label
          >
          <label class="radioButtonLabel">
            <input
              class="radio"
              type="radio"
              for="Gender"
              name="Gender"
            />Female</label
          >
          <label class="radioButtonLabel"
            ><input
              class="radio"
              type="radio"
              for="Gender"
              name="Gender"
            />Other</label
          >
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
        <div id="forgetPwd">Forgot password?</div>
        <label id="checkboxLabel">
          <input id="checkbox" type="checkbox" />Agree all the terms and
          conditions</label
        >
        <button type="submit">Sign Up</button>
        <div id="logIn">Already have an account? <a href="">Log In</a></div>
        <img id="closeButton" src="./closeButton.png" alt="" />
      </form>
    </div> -->
    <?php include "signupForm.php" ?>
  </body>
</html>
