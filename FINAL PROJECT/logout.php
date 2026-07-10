<?php
require 'functions.php';
logActivity($conn, "Logged out");
session_unset();
session_destroy();
session_start();
setFlashMessage("You have been logged out.");
header("Location: index.php");
exit();
?>
