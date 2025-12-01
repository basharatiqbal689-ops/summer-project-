<?php
session_start();
session_destroy(); // Session destroy kar do
header("Location: login.php"); // Login page pe redirect
exit;
?>
