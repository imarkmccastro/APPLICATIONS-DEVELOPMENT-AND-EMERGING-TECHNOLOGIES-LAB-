<?php
require 'functions.php';
logActivity($conn, "Logged out");
session_destroy();
header("Location: index.php");
exit();
?>
