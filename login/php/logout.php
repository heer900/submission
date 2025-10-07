<?php
session_start();
session_unset();
session_destroy();

// Clear cookie
setcookie("rememberUser", "", time() - 3600, "/");

// Redirect to login
header("Location: ../html/login.html");
exit();
?>
