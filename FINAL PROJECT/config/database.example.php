<?php
$servername = "sqlXXX.infinityfree.com";
$username = "if0_XXXXXXXX";
$password = "your-infinityfree-hosting-password";
$database = "if0_XXXXXXXX_database_name";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed.");
}
?>
