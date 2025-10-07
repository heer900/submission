<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); exit();
}
$result = $mysqli->query("SELECT * FROM users ORDER BY created_at DESC");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="admin-shell">
<aside class="sidebar">
  <div class="brand"><div class="logo">A</div><h1>Admin Panel</h1></div>
  <nav class="nav">
    <a href="admin_dashboard.php" class="active">Dashboard</a>
    <a href="add_user.php">Add User</a>
    <a href="logout.php">Logout</a>
  </nav>
</aside>
<main class="main">
  <div class="topbar"><h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2></div>
  <div class="card">
    <div class="card-header"><h3>Users List</h3><a href="add_user.php" class="btn">+ Add New User</a></div>
    <table class="data-table">
      <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
      <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= intval($row['user_id']) ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['role']) ?></td>
          <td><span class="badge <?= $row['status']=='active'?'success':'danger' ?>"><?= htmlspecialchars($row['status']) ?></span></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td>
            <a href="edit_user.php?id=<?= intval($row['user_id']) ?>" class="btn secondary">Edit</a>
            <a href="delete_user.php?id=<?= intval($row['user_id']) ?>" onclick="return confirm('Delete this user?')" class="btn secondary">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
</div>
</body>
</html>
