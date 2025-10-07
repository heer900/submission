<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header('Location: login.php'); exit(); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = ($_POST['role'] ?? 'user')==='admin'?'admin':'user';
    $status = ($_POST['status'] ?? 'active')==='inactive'?'inactive':'active';
    $password = $_POST['password'] ?? '';
    if(strlen($username)<3) $errors[]='Username too short';
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Invalid email';
    if(strlen($password)<6) $errors[]='Password too short';
    if(empty($errors)) {
        $hash=password_hash($password,PASSWORD_DEFAULT);
        $stmt=$mysqli->prepare("INSERT INTO users (username,email,role,status,password_hash) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss',$username,$email,$role,$status,$hash);
        if($stmt->execute()) { $stmt->close(); header('Location: admin_dashboard.php'); exit(); }
        else { $errors[]='DB error: '.$stmt->error; $stmt->close(); }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add User</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="admin-shell">
<aside class="sidebar">
<div class="brand"><div class="logo">A</div><h1>Admin Panel</h1></div>
<nav class="nav">
<a href="admin_dashboard.php">Dashboard</a>
<a href="add_user.php" class="active">Add User</a>
<a href="logout.php">Logout</a>
</nav>
</aside>
<main class="main">
<div class="card">
<h2>Add New User</h2>
<?php foreach($errors as $e): ?><p class="error"><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
<form method="post" class="form">
<div class="form-group"><label>Username</label><input name="username" required></div>
<div class="form-group"><label>Email</label><input name="email" type="email" required></div>
<div class="form-group"><label>Password</label><input name="password" type="password" required></div>
<div class="form-group"><label>Role</label><select name="role"><option value="user">User</option><option value="admin">Admin</option></select></div>
<div class="form-group"><label>Status</label><select name="status"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
<button type="submit" class="btn">Add User</button>
<a href="admin_dashboard.php" class="btn secondary">Back</a>
</form>
</div>
</main>
</div>
</body>
</html>
