<?php
session_start();

// If not logged in → redirect
if (empty($_SESSION['logged_in'])) {
    header("Location: ../html/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
</head>
<body>
  <h2>Welcome, <?php echo $_SESSION['username']; ?> 🎉</h2>
  <p>Email: <?php echo $_SESSION['email']; ?></p>
  <a href="logout.php">Logout</a>
</body>
</html>
