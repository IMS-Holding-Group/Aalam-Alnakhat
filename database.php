<?php
$host = '127.0.0.1';
$db   = 'aalam_alnakhat';
$user = 'root';
$pass = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $dsn = "mysql:host=$host;charset=utf8mb4";
    $pdo_temp = new PDO($dsn, $user, $pass, $options);
    $pdo_temp->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo_temp = null;
    
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('خطأ في الاتصال بقاعدة البيانات.');
}
?>

