<?php
session_start();
require_once 'db_connect.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header('Location: login.php');exit();}
$id=intval($_GET['id']??0);
if($id<=0){header('Location: admin_dashboard.php');exit();}
$errors=[];
$stmt=$mysqli->prepare("SELECT username,email,role,status FROM users WHERE user_id=?");
$stmt->bind_param('i',$id);$stmt->execute();$res=$stmt->get_result();
if($res->num_rows===0){$stmt->close();header('Location: admin_dashboard.php');exit();}
$user=$res->fetch_assoc();$stmt->close();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email']??'');
    $role=($_POST['role']??'user')==='admin'?'admin':'user';
    $status=($_POST['status']??'active')==='inactive'?'inactive':'active';
    $newpass=$_POST['password']??'';
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]='Invalid email';
    if(empty($errors)){
        if($newpass!==''){
            $hash=password_hash($newpass,PASSWORD_DEFAULT);
            $u=$mysqli->prepare("UPDATE users SET email=?,role=?,status=?,password_hash=? WHERE user_id=?");
            $u->bind_param('ssssi',$email,$role,$status,$hash,$id);
        }else{
            $u=$mysqli->prepare("UPDATE users SET email=?,role=?,status=? WHERE user_id=?");
            $u->bind_param('sssi',$email,$role,$status,$id);
        }
        if($u->execute()){$u->close();header('Location: admin_dashboard.php');exit();}
        else{$errors[]='Update error: '.$u->error;$u->close();}
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit User</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="admin-shell">
<aside class="sidebar">
<div class="brand"><div class="logo">A</div><h1>Admin Panel</h1></div>
<nav class="nav">
<a href="admin_dashboard.php">Dashboard</a>
<a href="add_user.php">Add User</a>
<a href="logout.php">Logout</a>
</nav>
</aside>
<main class="main">
<div class="card">
<h2>Edit User: <?= htmlspecialchars($user['username']) ?></h2>
<?php foreach($errors as $e): ?><p class="error"><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
<form method="post" class="form">
<div class="form-group"><label>Email</label><input name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" required></div>
<div class="form-group"><label>New Password (leave blank to keep)</label><input name="password" type="password"></div>
<div class="form-group"><label>Role</label>
<select name="role"><option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option><option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option></select></div>
<div class="form-group"><label>Status</label>
<select name="status"><option value="active" <?= $user['status']=='active'?'selected':'' ?>>Active</option><option value="inactive" <?= $user['status']=='inactive'?'selected':'' ?>>Inactive</option></select></div>
<button type="submit" class="btn">Update</button>
<a href="admin_dashboard.php" class="btn secondary">Back</a>
</form>
</div>
</main>
</div>
</body>
</html>
