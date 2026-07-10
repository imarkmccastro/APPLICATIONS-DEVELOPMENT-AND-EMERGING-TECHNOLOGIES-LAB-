<?php
$servername = "127.0.0.1";
$username = "root";
$password = "mypassword";
$database = "final_project_db";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
