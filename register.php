<?php
session_start();
require_once 'database.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($username) || empty($email) || empty($password)) {
        $message = 'يرجى ملء جميع الحقول';
        $message_type = 'error';
    } elseif ($password !== $confirm_password) {
        $message = 'كلمات المرور غير متطابقة';
        $message_type = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'البريد الإلكتروني غير صحيح';
        $message_type = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $message = 'اسم المستخدم أو البريد الإلكتروني موجود مسبقاً';
                $message_type = 'error';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $hashed_password]);
                $message = 'تم إنشاء الحساب بنجاح. يمكنك تسجيل الدخول الآن';
                $message_type = 'success';
                $_POST = [];
            }
        } catch (PDOException $e) {
            $message = 'حدث خطأ أثناء إنشاء الحساب';
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - عالم النكهات</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">عالم النكهات</div>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="content.php">الأطباق</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li><a href="contact.php">تواصل معنا</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">الملف الشخصي</a></li>
                    <?php if ($_SESSION['username'] === 'admin'): ?>
                        <li><a href="admin/index.php">لوحة الإدارة</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">تسجيل الخروج</a></li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                    <li><a href="register.php">إنشاء حساب</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="form-container">
            <h1 style="text-align: center; margin-bottom: 30px; color: #333;">إنشاء حساب جديد</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">تأكيد كلمة المرور</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn">إنشاء حساب</button>
                <p style="text-align: center; margin-top: 20px;">
                    لديك حساب بالفعل؟ <a href="login.php" style="color: #FF8A65;">تسجيل الدخول</a>
                </p>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>

