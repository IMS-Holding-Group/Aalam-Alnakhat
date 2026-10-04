<?php
session_start();
require_once 'database.php';

$stmt = $pdo->query("SELECT * FROM dishes ORDER BY created_at DESC LIMIT 6");
$featured_dishes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عالم النكهات - الرئيسية</title>
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

    <div class="hero">
        <h1>مرحباً بك في عالم النكهات</h1>
        <p>اكتشف نكهات متنوعة من مختلف الثقافات في مكان واحد</p>
    </div>

    <div class="container">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">أطباق مميزة</h2>
        <div class="dishes-grid">
            <?php foreach ($featured_dishes as $dish): ?>
                <div class="dish-card">
                    <img src="<?php echo htmlspecialchars($dish['image']); ?>" alt="<?php echo htmlspecialchars($dish['name']); ?>">
                    <div class="dish-name"><?php echo htmlspecialchars($dish['name']); ?></div>
                    <div class="dish-price"><?php echo number_format($dish['price'], 2); ?> ريال</div>
                    <div class="dish-calories"><?php echo $dish['calories']; ?> سعر حراري</div>
                    <span class="dish-type"><?php echo htmlspecialchars($dish['cuisine_type']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>

