<?php
session_start();
require_once '../database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_image'])) {
    $dish_id = $_POST['dish_id'] ?? 0;
    $image_path = trim($_POST['image_path'] ?? '');
    
    if ($dish_id && !empty($image_path)) {
        try {
            $stmt = $pdo->prepare("UPDATE dishes SET image = ? WHERE id = ?");
            $stmt->execute([$image_path, $dish_id]);
            $message = 'تم تحديث مسار الصورة بنجاح';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'حدث خطأ أثناء تحديث مسار الصورة';
            $message_type = 'error';
        }
    } else {
        $message = 'يرجى إدخال مسار الصورة';
        $message_type = 'error';
    }
}

$stmt = $pdo->query("SELECT * FROM dishes ORDER BY id");
$dishes = $stmt->fetchAll();

$image_files = [];
$images_dir = '../assets/images/';
if (is_dir($images_dir)) {
    $files = scandir($images_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
            $image_files[] = $file;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديث مسارات الصور - عالم النكهات</title>
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
                <li><a href="update_images.php">تحديث الصور</a></li>
                <li><a href="../logout.php">تسجيل الخروج</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="admin-panel">
            <h1 style="text-align: center; margin-bottom: 30px; color: #333;">تحديث مسارات الصور</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div style="background: #f5f5f5; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px;">الصور المتاحة في المجلد:</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <?php foreach ($image_files as $file): ?>
                        <div style="padding: 8px 12px; background: #fff; border: 1px solid #ddd; border-radius: 5px;">
                            <code>assets/images/<?php echo htmlspecialchars($file); ?></code>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($image_files)): ?>
                        <p style="color: #666;">لا توجد صور في المجلد</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>اسم الطبق</th>
                        <th>مسار الصورة الحالي</th>
                        <th>تحديث المسار</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dishes as $dish): ?>
                        <tr>
                            <td><?php echo $dish['id']; ?></td>
                            <td><?php echo htmlspecialchars($dish['name']); ?></td>
                            <td><code style="font-size: 12px;"><?php echo htmlspecialchars($dish['image']); ?></code></td>
                            <td>
                                <form method="POST" action="" style="display: flex; gap: 5px; align-items: center;">
                                    <input type="hidden" name="dish_id" value="<?php echo $dish['id']; ?>">
                                    <input type="text" name="image_path" placeholder="assets/images/..." 
                                           value="<?php echo htmlspecialchars($dish['image']); ?>" 
                                           style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; font-size: 12px; min-width: 200px;">
                                    <button type="submit" name="update_image" class="btn btn-secondary" style="padding: 8px 15px; font-size: 14px;">تحديث</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 10px;">
                <h3 style="margin-bottom: 15px;">تعليمات:</h3>
                <ol style="line-height: 2; color: #555;">
                    <li>ضع الصور في مجلد <code>assets/images/</code></li>
                    <li>استخدم المسار الكامل مثل: <code>assets/images/اسم_الصورة.jpg</code></li>
                    <li>يمكنك نسخ اسم الصورة من القائمة أعلاه ولصقه في حقل المسار</li>
                    <li>الصيغ المدعومة: JPG, JPEG, PNG, GIF, WEBP</li>
                </ol>
            </div>
            
            <a href="index.php" class="btn" style="margin-top: 20px;">العودة إلى لوحة الإدارة</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>

