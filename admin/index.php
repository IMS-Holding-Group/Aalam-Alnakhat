<?php
session_start();
require_once '../database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM dishes ORDER BY created_at DESC");
$dishes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - عالم النكهات</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">عالم النكهات - لوحة الإدارة</div>
            <ul>
                <li><a href="../index.php">الرئيسية</a></li>
                <li><a href="index.php">لوحة الإدارة</a></li>
                <li><a href="dishes_add.php">إضافة طبق</a></li>
                <li><a href="../logout.php">تسجيل الخروج</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="admin-panel">
            <h1 style="text-align: center; margin-bottom: 30px; color: #333;">إدارة الأطباق</h1>
            
            <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="dishes_add.php" class="btn">إضافة طبق جديد</a>
                <a href="update_images.php" class="btn btn-secondary">تحديث مسارات الصور</a>
            </div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>السعرات</th>
                        <th>النوع</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dishes as $dish): ?>
                        <tr>
                            <td><?php echo $dish['id']; ?></td>
                            <td><?php echo htmlspecialchars($dish['name']); ?></td>
                            <td><?php echo number_format($dish['price'], 2); ?> ريال</td>
                            <td><?php echo $dish['calories']; ?></td>
                            <td><?php echo htmlspecialchars($dish['cuisine_type']); ?></td>
                            <td>
                                <a href="dishes_edit.php?id=<?php echo $dish['id']; ?>" class="btn btn-secondary" style="padding: 8px 15px; font-size: 14px;">تعديل</a>
                                <a href="dishes_delete.php?id=<?php echo $dish['id']; ?>" class="btn btn-danger" style="padding: 8px 15px; font-size: 14px;" onclick="return confirm('هل أنت متأكد من حذف هذا الطبق؟')">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>

