<?php
session_start();
require_once 'db_connect.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $errors[] = 'Provide username and password.';
    } else {
        $stmt = $mysqli->prepare("SELECT user_id, password_hash, role, status FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute(); $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($uid, $hash, $role, $status);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                if ($status !== 'active') $errors[] = 'Account inactive. Contact admin.';
                else {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $uid;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    header('Location: admin_dashboard.php'); exit();
                }
            } else $errors[] = 'Invalid credentials.';
        } else $errors[] = 'Invalid credentials.';
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="admin-shell">
  <main class="main">
    <div class="card" style="max-width:400px;margin:auto;margin-top:5rem;">
      <h2>Login</h2>
      <?php foreach ($errors as $e): ?>
        <p class="error"><?= htmlspecialchars($e) ?></p>
      <?php endforeach; ?>
      <form method="post" class="form">
        <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
        <button type="submit" class="btn">Login</button>
      </form>
      <p style="margin-top:1rem;">Use <strong>admin/admin@123</strong> to login as admin.</p>
    </div>
  </main>
</div>
</body>
</html>
