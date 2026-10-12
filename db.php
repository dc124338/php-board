<?php
$dsn = '';
$user = '';
$password='';
$date=date("Y/m/d H:i:s");
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
$sql="CREATE TABLE IF NOT EXISTS test5(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(32),
    comment TEXT,
    date DATETIME,
    pass VARCHAR(20)
    );";
$pdo->query($sql);