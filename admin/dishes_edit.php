<?php
session_start();
require_once '../database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM dishes WHERE id = ?");
$stmt->execute([$id]);
$dish = $stmt->fetch();

if (!$dish) {
    header('Location: index.php');
    exit;
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $calories = trim($_POST['calories'] ?? '');
    $cuisine_type = trim($_POST['cuisine_type'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? 'assets/images/placeholder.jpg');
    
    if (empty($name) || empty($price) || empty($calories) || empty($cuisine_type)) {
        $message = 'يرجى ملء جميع الحقول المطلوبة';
        $message_type = 'error';
    } elseif (!is_numeric($price) || $price <= 0) {
        $message = 'السعر يجب أن يكون رقماً موجباً';
        $message_type = 'error';
    } elseif (!is_numeric($calories) || $calories <= 0) {
        $message = 'السعرات الحرارية يجب أن تكون رقماً موجباً';
        $message_type = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE dishes SET name = ?, price = ?, calories = ?, cuisine_type = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $price, $calories, $cuisine_type, $description, $image, $id]);
            $message = 'تم تحديث الطبق بنجاح';
            $message_type = 'success';
            $stmt = $pdo->prepare("SELECT * FROM dishes WHERE id = ?");
            $stmt->execute([$id]);
            $dish = $stmt->fetch();
        } catch (PDOException $e) {
            $message = 'حدث خطأ أثناء تحديث الطبق';
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
    <title>تعديل طبق - عالم النكهات</title>
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
        <div class="form-container">
            <h1 style="text-align: center; margin-bottom: 30px; color: #333;">تعديل طبق</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">اسم الطبق *</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($dish['name']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="price">السعر (ريال) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required value="<?php echo htmlspecialchars($dish['price']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="calories">السعرات الحرارية *</label>
                    <input type="number" id="calories" name="calories" min="0" required value="<?php echo htmlspecialchars($dish['calories']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="cuisine_type">نوع المطبخ *</label>
                    <select id="cuisine_type" name="cuisine_type" required>
                        <option value="">اختر النوع</option>
                        <option value="شرقي" <?php echo $dish['cuisine_type'] === 'شرقي' ? 'selected' : ''; ?>>شرقي</option>
                        <option value="هندي" <?php echo $dish['cuisine_type'] === 'هندي' ? 'selected' : ''; ?>>هندي</option>
                        <option value="آسيوي" <?php echo $dish['cuisine_type'] === 'آسيوي' ? 'selected' : ''; ?>>آسيوي</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">الوصف</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($dish['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">مسار الصورة</label>
                    <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($dish['image']); ?>" placeholder="assets/images/اسم_الصورة.jpg">
                    <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">ضع الصورة في مجلد assets/images ثم أدخل المسار</small>
                </div>
                
                <button type="submit" class="btn">تحديث الطبق</button>
                <a href="index.php" class="btn btn-secondary" style="margin-right: 10px;">العودة</a>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 عالم النكهات. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>

