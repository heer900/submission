<?php
$DB_HOST='localhost';$DB_USER='root';$DB_PASS='';$DB_NAME='userhub';
$mysqli=new mysqli($DB_HOST,$DB_USER,$DB_PASS);
if($mysqli->connect_error)die('MySQL connect error: '.$mysqli->connect_error);
$mysqli->query("CREATE DATABASE IF NOT EXISTS `$DB_NAME` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$mysqli->select_db($DB_NAME);
$create="CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255),
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if(!$mysqli->query($create))die('Table create error: '.$mysqli->error);
$r=$mysqli->query("SELECT COUNT(*) as cnt FROM users");$row=$r->fetch_assoc();
if(intval($row['cnt'])===0){
    $seed=[
        ['admin','admin@example.com','admin','active',password_hash('admin@123',PASSWORD_DEFAULT)],
        ['alice','alice@example.com','user','active',password_hash('alice123',PASSWORD_DEFAULT)],
        ['bob','bob@example.com','user','inactive',password_hash('bob123',PASSWORD_DEFAULT)]
    ];
    $stmt=$mysqli->prepare("INSERT INTO users(username,email,role,status,password_hash) VALUES(?,?,?,?,?)");
    foreach($seed as $u){$stmt->bind_param('sssss',$u[0],$u[1],$u[2],$u[3],$u[4]);$stmt->execute();}
    $stmt->close();
}
$mysqli->set_charset('utf8mb4');
