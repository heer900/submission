<?php
session_start();

// Input sanitization
$username = htmlspecialchars(trim($_POST['username']));
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars(trim($_POST['password']));
$confirm = htmlspecialchars(trim($_POST['confirm']));

if ($password !== $confirm) {
    die("Passwords do not match. <a href='../html/signup.html'>Try again</a>");
}

// Hash password before storing
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// For now, store in session (later → DB)
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['password'] = $hashedPassword;

// Redirect to dashboard
header("Location: dashboard.php");
exit();
?>
