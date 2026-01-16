<?php
// Load local environment variables if available
if (file_exists(__DIR__ . '/env.php')) {
    include __DIR__ . '/env.php';
}

// Detect if running on localhost
$isLocalhost = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1');

if ($isLocalhost) {
    // Default Localhost (XAMPP/WAMP) Settings
    $server = "localhost";
    $port = "3306";
    $user = "root";
    $pass = "";
    $database = "medidocx";
} else {
    // InfinityFree Database (Remote) Settings from env.php/getenv
    $server = getenv('MYSQL_HOST') ?: "sql108.infinityfree.com";
    $port = getenv('MYSQL_PORT') ?: "3306";
    $user = getenv('MYSQL_USER') ?: "if0_40918541";
    $pass = getenv('MYSQL_PASSWORD') ?: "NBs5KCGAda9DMv";
    $database = getenv('MYSQL_DATABASE') ?: "if0_40918541_medidocx";
}

$conn = mysqli_connect($server, $user, $pass, $database, $port);

if (!$conn) {
    // Show detailed error on localhost
    if ($isLocalhost) {
        die("Connection Failure: " . mysqli_connect_error());
    } else {
        die("Connection Failure");
    }
}

mysqli_set_charset($conn, "utf8mb4");