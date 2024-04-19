<?php
// session_name('session2');
// $sessionName =session_name();

// echo "Session Name: $sessionName";
// session_start();


// Output the session name


$_SESSION['session2']=bin2hex(random_bytes(16));
echo "<br />";
echo $_SESSION['session2'];