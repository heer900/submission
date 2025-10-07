<?php
session_start();

// Dummy check: verify against stored session values (later: DB)
if ($_POST['username'] === $_SESSION['username'] && password_verify($_POST['password'], $_SESSION['password'])) {
    
    // Set cookie if "remember me" checked
    if (!empty($_POST['remember'])) {
        setcookie("rememberUser", $_SESSION['username'], time() + (86400 * 7), "/"); // 7 days
    }

    $_SESSION['logged_in'] = true;
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid login. <a href='../html/login.html'>Try again</a>";
}
?>
