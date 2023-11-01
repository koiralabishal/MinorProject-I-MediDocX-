var dropdown = document.querySelector(".custom-dropdown");
var options = document.getElementById("custom-dropdown-options");

// Function to toggle the dropdown
function toggleDropdown() {
  if (options.style.display === "block") {
    options.style.display = "none";
    dropdown.classList.remove("active");
  } else {
    options.style.display = "block";
    dropdown.classList.add("active");
    // Add an event listener to detect clicks outside of the dropdown
    document.addEventListener("click", closeDropdownOnClickOutside);
  }
}

// Function to select an option
function selectOption(option) {
  document.querySelector(".dropdown-label").textContent = option;
  toggleDropdown();
  document.getElementById("selectedType").value = option;
  if (option == "Doctor") {
    document.getElementById("doctorID").style.display = "block";
    

  }else if (option == "Patient") {
    document.getElementById("doctorID").style.display = "none";
    
  }
}

// Function to close the dropdown when clicking outside of it
function closeDropdownOnClickOutside(event) {
  if (!dropdown.contains(event.target)) {
    options.style.display = "none";
    dropdown.classList.remove("active");
    document.removeEventListener("click", closeDropdownOnClickOutside);
  }
}

var loginButton = document.getElementById("loginBtn");
var signupButton = document.getElementById("signupBtn");
var overlay = document.getElementById("overlay");
var loginForm = document.getElementById("loginForm");
var closeLogin = document.getElementById("closeLogin");
var signupNow = document.getElementById("signupNow");
var signupForm = document.getElementById("signupForm");
var loginNow = document.getElementById("loginNow");
var closeSignup = document.getElementById("closeSignup");
// var signup = document.getElementById("signupNow");

loginButton.addEventListener("click", function () {
  loginForm.style.transform = "scale(1)";
  overlay.style.opacity = "1";
  overlay.style.pointerEvents = "auto";
  console.log("Login Button");
});

signupButton.addEventListener("click", function () {
  signupForm.style.transform = "scale(1)";
  overlay.style.opacity = "1";
  overlay.style.pointerEvents = "auto";
  console.log("Signup Button");
});

closeLogin.addEventListener("click", function () {
  loginForm.style.transform = "scale(0)";
  overlay.style.opacity = "0";
  overlay.style.pointerEvents = "none";
});

signupNow.addEventListener("click", function () {
  signupForm.style.transform = "scale(1)";
  loginForm.style.transform = "scale(0)";
});

loginNow.addEventListener("click", function () {
  loginForm.style.transform = "scale(1)";
  signupForm.style.transform = "scale(0)";
});

closeSignup.addEventListener("click", function () {
  signupForm.style.transform = "scale(0)";
  overlay.style.opacity = "0";
  overlay.style.pointerEvents = "none";
});