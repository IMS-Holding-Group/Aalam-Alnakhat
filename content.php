<?php
session_start();
require_once 'database.php';

$stmt = $pdo->query("SELECT * FROM dishes ORDER BY created_at DESC");
$all_dishes = $stmt->fetchAll();

$cuisine_types = [];
foreach ($all_dishes as $dish) {
    if (!in_array($dish['cuisine_type'], $cuisine_types)) {
        $cuisine_types[] = $dish['cuisine_type'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأطباق - عالم النكهات</title>
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
        <h1 style="text-align: center; margin-bottom: 30px; color: #333;">قائمة الأطباق</h1>
        
        <div class="search-filter">
            <div class="filter-group">
                <input type="text" id="search" placeholder="ابحث عن طبق...">
                <select id="filter">
                    <option value="">جميع الأنواع</option>
                    <?php foreach ($cuisine_types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="dishes-grid">
            <?php foreach ($all_dishes as $dish): ?>
                <div class="dish-card">
                    <img src="<?php echo htmlspecialchars($dish['image']); ?>" alt="<?php echo htmlspecialchars($dish['name']); ?>">
                    <div class="dish-name"><?php echo htmlspecialchars($dish['name']); ?></div>
                    <div class="dish-price"><?php echo number_format($dish['price'], 2); ?> ريال</div>
                    <div class="dish-calories"><?php echo $dish['calories']; ?> سعر حراري</div>
                    <span class="dish-type"><?php echo htmlspecialchars($dish['cuisine_type']); ?></span>
                    <?php if ($dish['description']): ?>
                        <p style="margin-top: 10px; color: #666; font-size: 14px;"><?php echo htmlspecialchars($dish['description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
    
    <script src="assets/js/main.js"></script>
</body>
</html>

