CREATE DATABASE IF NOT EXISTS aalam_alnakhat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aalam_alnakhat;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    calories INT NOT NULL,
    cuisine_type VARCHAR(50) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (username, email, password) VALUES 
('admin', 'admin@example.com', '');

INSERT INTO dishes (name, price, calories, cuisine_type, description, image) VALUES 
('كبسة لحم شرقية', 45.00, 900, 'شرقي', 'كبسة لحم شرقية شهية مع أرز طويل الحبة', 'assets/images/1.jpg'),
('برياني دجاج هندي', 42.50, 850, 'هندي', 'برياني دجاج هندي مع بهارات مميزة', 'assets/images/chicken-beryani.webp'),
('نودلز آسيوي بالخضار', 32.00, 600, 'آسيوي', 'نودلز آسيوي مع خضار طازجة', 'assets/images/photo.jpg'),
('منسف لحم أردني', 55.00, 1100, 'شرقي', 'منسف لحم تقليدي مع لبن وجميد', 'assets/images/mansaf.webp'),
('مقلوبة دجاج فلسطينية', 48.00, 950, 'شرقي', 'مقلوبة دجاج مع أرز وباذنجان', 'assets/images/photo2.jpg'),
('شاورما لحم', 35.00, 750, 'شرقي', 'شاورما لحم مع خبز صاج وصلصات', 'assets/images/R.jpg'),
('فتوش لبناني', 25.00, 350, 'شرقي', 'سلطة فتوش لبنانية مع خبز محمص', 'assets/images/fattouch-salad-lebanese-copy.webp'),
('حمص بالطحينة', 18.00, 280, 'شرقي', 'حمص كريمي مع طحينة وزيت زيتون', 'assets/images/photo3.webp'),
('كباب مشوي', 40.00, 800, 'شرقي', 'كباب لحم مشوي مع أرز وبصل', 'assets/images/كباب_مشوي.jpg'),
('مشاوي مشكلة', 50.00, 1000, 'شرقي', 'مشكلة من الكباب والكفتة والشيش طاووق', 'assets/images/طريقة-عمل-مشاوي-مشكلة.jpg'),
('برياني لحم هندي', 46.00, 920, 'هندي', 'برياني لحم مع أرز بسمتي وبهارات', 'assets/images/12063619_1007015339384411_4236698068904259244_n.jpg'),
('تندوري دجاج', 38.00, 680, 'هندي', 'دجاج تندوري مع أرز وناان', 'assets/images/for-web-6360.jpg'),
('دجاج بالزبدة', 44.00, 850, 'هندي', 'دجاج بالزبدة مع أرز بسمتي', 'assets/images/755e58594861fd3cdd5161c7a6f16ee1.jpg'),
('ساموسا هندية', 15.00, 200, 'هندي', 'ساموسا محشوة بالخضار والبهارات', 'assets/images/maxresdefault.jpg'),
('دال عدس هندي', 28.00, 450, 'هندي', 'دال عدس مع أرز وروتي', 'assets/images/دال-عدس.jpeg'),
('كاري خضار', 32.00, 520, 'هندي', 'كاري خضار مع أرز بسمتي', 'assets/images/كاري.jpg'),
('سوشي سلمون', 65.00, 450, 'آسيوي', 'سوشي سلمون طازج مع أرز', 'assets/images/088FA97A76CB7923E7622156271DA6CF.jpg'),
('رامين ياباني', 38.00, 650, 'آسيوي', 'رامين ياباني مع بيض وخضار', 'assets/images/730b8751-778d-4c80-b150-bcdecdb5e152.jpg'),
('تيرياكي دجاج', 42.00, 720, 'آسيوي', 'دجاج تيرياكي مع أرز وخضار', 'assets/images/Glazed-Teriyaki-Chicken-Wings-close-up-photo-on-white-plate.webp'),
('بوكي سلمون', 48.00, 580, 'آسيوي', 'بوكي سلمون مع أرز وخضار', 'assets/images/9d575a0ee62c472b563c435432764e94.jpeg'),
('سبرينغ رولز', 22.00, 180, 'آسيوي', 'سبرينغ رولز محشوة بالخضار', 'assets/images/mkt22-01.png'),
('باد تاي تايلندي', 36.00, 680, 'آسيوي', 'نودلز باد تاي مع دجاج وخضار', 'assets/images/386652-yaai-thai-pad-thai-au-poulet.jpg'),
('كيمتشي كوري', 28.00, 120, 'آسيوي', 'كيمتشي كوري تقليدي', 'assets/images/236312682_1418966218475551_7138263614941858573_n.jpg');

