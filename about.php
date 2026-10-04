<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من نحن - عالم النكهات</title>
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
            <h1 style="text-align: center; margin-bottom: 30px; color: #333;">من نحن</h1>
            <p style="text-align: right; line-height: 1.8; color: #555; margin-bottom: 20px;">
                عالم النكهات هو منصة تجمع بين ثقافات متنوعة من خلال الطعام. نحن نؤمن بأن الطعام هو لغة عالمية تجمع الناس من مختلف الخلفيات والثقافات.
            </p>
            <p style="text-align: right; line-height: 1.8; color: #555; margin-bottom: 20px;">
                هدفنا هو تقديم تجربة طعام فريدة تدمج بين النكهات الشرقية والآسيوية والهندية وغيرها من المطابخ العالمية. كل طبق في قائمتنا يحمل قصة ثقافية مميزة.
            </p>
            <p style="text-align: right; line-height: 1.8; color: #555;">
                نقدم أطباقاً متنوعة مصنوعة بعناية من مكونات طازجة، مع التركيز على الجودة والنكهات الأصيلة. انضم إلينا في رحلة استكشاف عالم النكهات!
            </p>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>

