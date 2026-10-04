<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($email)) {
        $message = 'يرجى ملء جميع الحقول';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'البريد الإلكتروني غير صحيح';
        $message_type = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
            $stmt->execute([$username, $email, $_SESSION['user_id']]);
            if ($stmt->fetch()) {
                $message = 'اسم المستخدم أو البريد الإلكتروني موجود مسبقاً';
                $message_type = 'error';
            } else {
                if (!empty($password)) {
                    if (strlen($password) < 6) {
                        $message = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
                        $message_type = 'error';
                    } else {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
                        $stmt->execute([$username, $email, $hashed_password, $_SESSION['user_id']]);
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        $message = 'تم تحديث البيانات بنجاح';
                        $message_type = 'success';
                    }
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
                    $stmt->execute([$username, $email, $_SESSION['user_id']]);
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $message = 'تم تحديث البيانات بنجاح';
                    $message_type = 'success';
                }
            }
        } catch (PDOException $e) {
            $message = 'حدث خطأ أثناء تحديث البيانات';
            $message_type = 'error';
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - عالم النكهات</title>
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
            <h1 style="text-align: center; margin-bottom: 30px; color: #333;">الملف الشخصي</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($user['username']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">كلمة المرور الجديدة (اتركها فارغة إذا لم ترد التغيير)</label>
                    <input type="password" id="password" name="password">
                </div>
                
                <button type="submit" class="btn">تحديث البيانات</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>

