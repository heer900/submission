<?php
session_start();
require_once 'db_connect.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header('Location: login.php');exit();}
$id=intval($_GET['id']??0);
if($id>0){
    $stmt=$mysqli->prepare("DELETE FROM users WHERE user_id=?");
    $stmt->bind_param('i',$id);$stmt->execute();$stmt->close();
}
header('Location: admin_dashboard.php');exit();
