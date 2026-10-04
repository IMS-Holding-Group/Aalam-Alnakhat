<?php
require_once 'database.php';

try {
    $sql = file_get_contents('sql/seed.sql');
    
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && !preg_match('/^(CREATE DATABASE|USE)/i', $statement)) {
            $pdo->exec($statement);
        }
    }
    
    echo "تم إنشاء قاعدة البيانات والجداول بنجاح!<br>";
    echo "<a href='index.php'>الذهاب إلى الصفحة الرئيسية</a>";
} catch (PDOException $e) {
    echo "خطأ: " . $e->getMessage();
}
?>

