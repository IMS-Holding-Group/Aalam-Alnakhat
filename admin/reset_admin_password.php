<?php
require_once '../database.php';

try {
    $new_password = 'Password123!';
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
    $stmt->execute([$hashed_password]);
    
    echo "تم تحديث كلمة مرور الأدمن بنجاح!<br>";
    echo "اسم المستخدم: admin<br>";
    echo "كلمة المرور: Password123!<br>";
    echo "<br><a href='../login.php'>تسجيل الدخول</a>";
} catch (PDOException $e) {
    echo "حدث خطأ: " . $e->getMessage();
}
?>

