# عالم النكهات

اسم الواجهة في الصفحات: عالم النكهات. مجلد المشروع: `Aalam Alnakhat`. قاعدة البيانات في `database.php` و`sql/seed.sql`: `aalam_alnakhat`.

## 1. ما هو المشروع

موقع PHP يعرض قائمة أطباق من جدول `dishes`، مع صفحات تعريف وتواصل، وتسجيل مستخدمين، ولوحة إدارة للأطباق. الواجهة عربية واتجاهها `rtl` في ملفات مثل `index.php` و`content.php`.

## 2. لماذا يوجد هذا المشروع

النص في `about.php` يصف المنصة بأنها تجمع ثقافات عبر الطعام، وهدفها تقديم نكهات شرقية وآسيوية وهندية. استنتاج من الكود: المشروع يخدم عرض قائمة أطباق وإدارتها محلياً عبر MySQL.

## 3. من يستخدمه

| الطرف | كيف يظهر في الملفات |
| --- | --- |
| زائر | يتصفح `index.php` و`content.php` و`about.php` و`contact.php` بدون جلسة |
| مستخدم مسجل | `$_SESSION['user_id']` بعد `login.php`، ويصل إلى `profile.php` |
| حساب باسم المستخدم `admin` | يظهر له رابط `admin/index.php` عندما `$_SESSION['username'] === 'admin'` |

عمود دور منفصل في جدول `users`: غير موجود في `sql/seed.sql`.

## 4. ماذا يستطيع النظام أن يفعل

- عرض 6 أطباق في `index.php` عبر `ORDER BY created_at DESC LIMIT 6`.
- عرض كل الأطباق في `content.php` مع بحث وفلترة بالنوع داخل المتصفح (`assets/js/main.js`).
- إنشاء حساب في `register.php` وحفظ كلمة المرور بـ `password_hash`.
- تسجيل الدخول باسم المستخدم أو البريد في `login.php` عبر `password_verify`.
- تعديل الاسم والبريد وكلمة المرور في `profile.php`.
- إرسال رسالة إلى جدول `contacts` من `contact.php`.
- إضافة وتعديل وحذف أطباق وتحديث مسار الصورة من مجلد `admin/`.
- إنشاء الجداول والبيانات من `setup.php` بقراءة `sql/seed.sql`.

الطلب والدفع والحجز: غير موجودة في الملفات الحالية.

## 5. كيف يعمل النظام

```
المتصفح
   |
   |  طلب PHP (GET أو POST)
   v
ملف الصفحة (index.php / login.php / admin/...)
   |
   |  require database.php
   v
PDO -> MySQL قاعدة aalam_alnakhat
   |
   v
HTML عربي RTL + assets/css/style.css
```

`database.php` ينشئ قاعدة `aalam_alnakhat` إن لم تكن موجودة، ثم يتصل بها. `setup.php` ينفذ عبارات `sql/seed.sql` بعد استبعاد `CREATE DATABASE` و`USE`.

## 6. أمثلة واقعية

1. زائر يفتح `content.php`، يكتب في الحقل `#search`، و`main.js` يخفي بطاقات `.dish-card` التي لا يطابق اسمها النص، ويمكنه اختيار نوع من `#filter` (القيم تأتي من عمود `cuisine_type`).
2. مستخدم يرسل النموذج في `contact.php` بالحقول `name` و`email` و`message`، فيُدرج صف في `contacts`.
3. المستخدم `admin` يفتح `admin/dishes_add.php` ويدخل الاسم والسعر والسعرات و`cuisine_type` والوصف ومسار الصورة، فيُدرج صف في `dishes`.

## 7. رحلة المستخدم

1. فتح `index.php` ورؤية الأطباق المميزة.
2. الانتقال إلى `content.php` للبحث والتصفية.
3. إنشاء حساب من `register.php` ثم الدخول من `login.php`.
4. تعديل البيانات من `profile.php`.
5. إن كان اسم المستخدم في الجلسة هو `admin`، الدخول إلى `admin/index.php` لإدارة الأطباق.
6. الخروج عبر `logout.php` الذي يستدعي `session_destroy()`.

## 8. الوحدات والأقسام

| الوحدة | الملفات |
| --- | --- |
| الواجهة العامة | `index.php`, `content.php`, `about.php`, `contact.php` |
| الحساب | `register.php`, `login.php`, `logout.php`, `profile.php` |
| الإدارة | `admin/index.php`, `admin/dishes_add.php`, `admin/dishes_edit.php`, `admin/dishes_delete.php`, `admin/update_images.php`, `admin/reset_admin_password.php` |
| البيانات | `database.php`, `setup.php`, `sql/seed.sql` |
| الواجهة الثابتة | `assets/css/style.css`, `assets/js/main.js`, `assets/fonts/OFL.txt` |

## 9. الشركات والكيانات

كيان مؤسسي أو شركة في الملفات: غير موثق. الاسم الظاهر للمستخدم هو «عالم النكهات». أسعار العرض تُكتب بالريال في `index.php` و`admin/index.php` (`number_format` ثم النص «ريال»).

## 10. الصلاحيات

| الإجراء | الشرط في الكود |
| --- | --- |
| عرض الأطباق والتواصل | متاح بدون جلسة |
| `profile.php` | وجود `$_SESSION['user_id']` وإلا تحويل إلى `login.php` |
| صفحات `admin/` ما عدا `reset_admin_password.php` | `$_SESSION['user_id']` واسم المستخدم في الجلسة يساوي `admin` |
| `admin/reset_admin_password.php` | فحص جلسة: غير موجود في الملف. ينفذ `UPDATE users SET password = ? WHERE username = 'admin'` عند فتحه |

تغيير اسم المستخدم من `profile.php` يحدّث `$_SESSION['username']`. استنتاج من الكود: إذا تغيّر الاسم بعيداً عن `admin` يختفي شرط دخول لوحة الإدارة.

## 11. الأتمتة وسير العمل

مهام مجدولة أو طوابير: غير موجودة في الملفات الحالية.

سير إضافة طبق: نموذج POST في `admin/dishes_add.php` ثم `INSERT INTO dishes`.

سير الحذف: رابط GET `admin/dishes_delete.php?id=` ثم `DELETE FROM dishes` ثم تحويل إلى `admin/index.php`. تأكيد الحذف في الواجهة عبر `confirm()` في `admin/index.php`.

## 12. التكامل بين الوحدات

الصفحات العامة وصفحات الإدارة تشارك `database.php` ونفس جدول `dishes`. قائمة التنقل مكررة داخل كل صفحة PHP (ملف هيدر مشترك: غير موجود). `content.php` يقرأ كل الصفوف، و`index.php` يقرأ آخر 6 صفوف. رسائل `contacts` تُحفظ في القاعدة، وصفحة عرضها في لوحة الإدارة: غير موجودة في الملفات الحالية.

## 13. المصطلحات

| المصطلح | المعنى في هذا المشروع |
| --- | --- |
| طبق | صف في `dishes`: `name`, `price`, `calories`, `cuisine_type`, `description`, `image` |
| نوع المطبخ | قيمة `cuisine_type`. البذرة تستخدم: شرقي، هندي، آسيوي. نموذج الإضافة يعرض هذه القيم الثلاث |
| مستخدم | صف في `users` |
| رسالة تواصل | صف في `contacts` |
| PDO | الاتصال في `database.php` |
| الجلسة | `$_SESSION['user_id']`, `username`, `email` بعد نجاح `login.php` |

## 14. الأسئلة الشائعة

**من أين تأتي الأطباق؟** من جدول `dishes` بعد تنفيذ `setup.php` أو استيراد `sql/seed.sql`.

**هل يلزم حساب لرؤية القائمة؟** عرض `index.php` و`content.php` يعمل بدون جلسة.

**أين تُحفظ رسائل التواصل؟** في جدول `contacts`. إرسال بريد إلكتروني من `contact.php`: غير موجود.

**كيف يُحدَّد المدير؟** بمقارنة اسم المستخدم في الجلسة بالنص `admin`، وليس بعمود دور.

## 15. المعمارية

```
+------------------+       +----------------------+       +------------------+
| المتصفح          | HTTP  | PHP (صفحات جذرية     |  PDO  | MySQL            |
| HTML + main.js   |------>| و admin/)            |------>| aalam_alnakhat   |
| style.css        |<------| database.php         |<------| users, dishes,   |
+------------------+       +----------------------+       | contacts         |
                                                          +------------------+
```

خادم تطبيق منفصل أو إطار عمل: غير موجود في الملفات الحالية. الصفحات تُخدم كملفات PHP مباشرة.

## 16. التقنيات المستخدمة

| التقنية | أين |
| --- | --- |
| PHP | كل ملفات `.php` |
| PDO و MySQL (`utf8mb4`) | `database.php` |
| HTML و CSS | الصفحات و`assets/css/style.css` |
| JavaScript في المتصفح | `assets/js/main.js` |
| `password_hash` / `password_verify` | التسجيل والدخول والملف الشخصي |

Composer و`package.json` وإطار PHP: غير موجودة في الملفات الحالية.

## 17. هيكل المشروع

```
Aalam Alnakhat/
├── index.php
├── content.php
├── about.php
├── contact.php
├── register.php
├── login.php
├── logout.php
├── profile.php
├── database.php
├── setup.php
├── sql/seed.sql
├── admin/
│   ├── index.php
│   ├── dishes_add.php
│   ├── dishes_edit.php
│   ├── dishes_delete.php
│   ├── update_images.php
│   └── reset_admin_password.php
└── assets/
    ├── css/style.css
    ├── js/main.js
    └── fonts/OFL.txt
```

مسارات صور في `sql/seed.sql` تحت `assets/images/`. ملفات الصور نفسها ضمن قائمة الملفات الحالية للمجلد: غير ظاهرة بجانب `style.css` و`main.js` و`OFL.txt`.

## 18. واجهة المستخدم

اتجاه `dir="rtl"` ولغة `ar`. التنقل: الرئيسية، الأطباق، من نحن، تواصل معنا، ثم روابط الحساب حسب الجلسة. بطاقات الأطباق تستخدم الأصناف `dish-card`, `dish-name`, `dish-price`, `dish-calories`, `dish-type`. التذييل في الصفحات يعرض النص «2025 عالم النكهات». وسم `link rel="icon"`: غير موجود في الصفحات المقروءة.

## 19. الخادم

خادم مضمّن في المشروع: غير موجود. `database.php` يتصل بـ `127.0.0.1`. التشغيل المتوقع: خادم PHP مثل Apache مع امتداد PDO MySQL. منفذ التطبيق: غير موثق في الملفات.

## 20. مسار الطلب

1. المتصفح يطلب ملفاً مثل `content.php`.
2. `session_start()` ثم `require database.php`.
3. استعلام `SELECT` أو معالجة `POST`.
4. طباعة HTML. أخطاء PDO في الصفحات تُحوَّل إلى رسائل عربية عامة في `login.php` و`register.php` و`contact.php`.
5. `database.php` عند فشل الاتصال ينهي التنفيذ بالنص «خطأ في الاتصال بقاعدة البيانات.»
6. `setup.php` عند الفشل يطبع `PDOException::getMessage()`.

## 21. قاعدة البيانات

الاسم: `aalam_alnakhat`. الترميز: `utf8mb4` / `utf8mb4_unicode_ci`. المحرك في `seed.sql`: InnoDB.

### users

| العمود | المفتاح |
| --- | --- |
| `id` INT AUTO_INCREMENT | PRIMARY KEY |
| `username` VARCHAR(100) NOT NULL | UNIQUE |
| `email` VARCHAR(150) NOT NULL | UNIQUE |
| `password` VARCHAR(255) NOT NULL | |
| `created_at` DATETIME | |

### dishes

| العمود | المفتاح |
| --- | --- |
| `id` INT AUTO_INCREMENT | PRIMARY KEY |
| `name`, `price` DECIMAL(8,2), `calories`, `cuisine_type` | |
| `description` TEXT, `image` VARCHAR(255), `created_at` | |

مفتاح أجنبي: غير موجود.

### contacts

| العمود | المفتاح |
| --- | --- |
| `id` | PRIMARY KEY |
| `name`, `email`, `message` TEXT NOT NULL, `created_at` | |

البذرة تدرج مستخدماً `admin` بالبريد `admin@example.com` وتجزئة كلمة مرور، و23 طبقاً. كلمة المرور النصية داخل تعليق `seed.sql`: غير موثقة.

## 22. واجهات البرمجة

واجهة JSON أو مسار `/api`: غير موجود في الملفات الحالية. نقاط الدخول هي ملفات PHP.

| الطريقة | المسار | الغرض | المدخلات | الجلسة | الاستجابة |
| --- | --- | --- | --- | --- | --- |
| GET | `index.php` | أطباق مميزة | | اختيارية | HTML |
| GET | `content.php` | كل الأطباق | | اختيارية | HTML |
| GET | `about.php` | نص تعريفي | | اختيارية | HTML |
| POST | `contact.php` | حفظ رسالة | `name`, `email`, `message` | اختيارية | HTML |
| POST | `register.php` | إنشاء مستخدم | `username`, `email`, `password`, `confirm_password` | | HTML |
| POST | `login.php` | دخول | `username`, `password` | تنشئ الجلسة | تحويل إلى `index.php` أو HTML |
| GET | `logout.php` | خروج | | | تحويل بعد `session_destroy` |
| POST | `profile.php` | تحديث الحساب | `username`, `email`, `password` اختياري | مطلوبة | HTML |
| GET | `admin/index.php` | قائمة أطباق | | مستخدم `admin` | HTML |
| POST | `admin/dishes_add.php` | إضافة | `name`, `price`, `calories`, `cuisine_type`, `description`, `image` | مستخدم `admin` | HTML |
| GET/POST | `admin/dishes_edit.php` | تعديل | `id` في الرابط وحقول الطبق | مستخدم `admin` | HTML |
| GET | `admin/dishes_delete.php` | حذف | `id` | مستخدم `admin` | تحويل إلى `admin/index.php` |
| POST | `admin/update_images.php` | تحديث مسار صورة | `dish_id`, `image_path`, `update_image` | مستخدم `admin` | HTML |
| GET | `admin/reset_admin_password.php` | إعادة تعيين كلمة مرور `admin` | | فحص: غير موجود | HTML نصي |
| GET | `setup.php` | تنفيذ البذرة | | فحص: غير موجود | HTML نصي |

## 23. تسجيل الدخول والصلاحيات

`login.php` يبحث `SELECT * FROM users WHERE username = ? OR email = ?` ثم `password_verify`. عند النجاح تُضبط `user_id` و`username` و`email` ويتم التحويل إلى `index.php`.

التسجيل يرفض الحقول الفارغة، وعدم تطابق التأكيد، وكلمة أقصر من 6 أحرف، وبريداً لا يمر من `filter_var` مع `FILTER_VALIDATE_EMAIL`، والتكرار على `username` أو `email`.

ملفات تعريف ارتباط `HttpOnly` و`Secure` و`SameSite`: غير موثقة في الملفات. رمز CSRF: غير موجود.

## 24. الحماية

- الاستعلامات التي تأخذ مدخلات المستخدم تستخدم `prepare` و`execute` في الصفحات المقروءة.
- كلمات المرور تُخزن عبر `password_hash` وتُفحص بـ `password_verify`.
- مخرجات النماذج المعادة للصفحة تمر عبر `htmlspecialchars` في النماذج المقروءة.
- حذف الطبق يتم بطلب GET بعد جلسة المدير.
- `setup.php` و`admin/reset_admin_password.php` ينفذان تغييراً في القاعدة عند طلبهما، وفحص الجلسة عليهما: غير موجود.
- `setup.php` يعرض رسالة استثناء PDO للمستخدم.
- بيانات الاتصال (`127.0.0.1`, قاعدة `aalam_alnakhat`, مستخدم `root`, قيمة `$pass` فارغة في الملف) مكتوبة داخل `database.php`. ملف `.env`: غير موجود.

## 25. الإعدادات

| الاسم في الكود | الملف | القيمة الظاهرة |
| --- | --- | --- |
| `$host` | `database.php` | `127.0.0.1` |
| `$db` | `database.php` | `aalam_alnakhat` |
| `$user` | `database.php` | `root` |
| `$pass` | `database.php` | سلسلة فارغة في الملف الحالي |
| خيارات PDO | `database.php` | `ERRMODE_EXCEPTION`, `FETCH_ASSOC` |

متغيرات بيئة: غير موجودة في الملفات الحالية.

## 26. التكاملات الخارجية

بوابة دفع أو بريد أو تخزين سحابي أو واجهة طرف ثالث: غير موجودة في الملفات الحالية.

## 27. المهام المجدولة

Cron أو مجدول داخل المشروع: غير موجود في الملفات الحالية.

## 28. تخزين الملفات

صور الأطباق تُخزن كمسار نصي في `dishes.image` (مثال من البذرة: `assets/images/1.jpg`). رفع ملف من النموذج: غير موجود. `admin/dishes_add.php` و`dishes_edit.php` و`update_images.php` يأخذون المسار كنص. القيمة الافتراضية عند غياب الصورة: `assets/images/placeholder.jpg`.

## 29. السجلات والمتابعة

نظام logging مستقل: غير موجود. أخطاء الاتصال والعمليات تُعرض كرسائل صفحة. `setup.php` يطبع تفاصيل استثناء PDO.

## 30. التثبيت

1. تشغيل MySQL وخادم PHP يصل إلى مجلد المشروع.
2. التأكد من امتداد PDO MySQL.
3. ضبط `$host` و`$user` و`$pass` في `database.php` إن لزم. القيم الحالية موثقة في القسم 25.
4. فتح `setup.php` مرة واحدة، أو استيراد `sql/seed.sql` من عميل MySQL. `setup.php` يتخطى عبارات `CREATE DATABASE` و`USE` لأن `database.php` ينشئ القاعدة مسبقاً.
5. فتح `index.php` من خادم الويب.

أمر تشغيل موثق داخل المشروع: غير موجود.

## 31. دليل التطوير

- الصفحات العامة تتصل عبر `require_once 'database.php'`.
- صفحات `admin/` تستخدم `require_once '../database.php'`.
- فلترة الأطباق في المتصفح تعتمد على وجود `.dish-name` و`.dish-type` داخل `.dish-card`.
- إضافة نوع مطبخ جديد في الواجهة يتطلب تعديل قائمة `select` في `admin/dishes_add.php` و`admin/dishes_edit.php`. القيم المخزنة مسبقاً في القاعدة تظل قابلة للعرض والفلترة في `content.php` لأنها تُجمع من الصفوف.
- اختبارات آلية: غير موجودة في الملفات الحالية.

## 32. النشر

ملف نشر أو Docker أو إعداد استضافة: غير موجود. للنشر يلزم خادم PHP ونسخة MySQL ونقل المجلد وتعديل `database.php` ثم تنفيذ البذرة. نظام الملفات على خادم مؤقت: غير موثق هنا لأن المشروع يكتب بياناته في MySQL وليس في ملفات محلية للبيانات.

## 33. النسخ الاحتياطي والاستعادة

سكربت نسخ احتياطي: غير موجود. الاستعادة العملية من الملفات الحالية هي إعادة استيراد `sql/seed.sql` (يعيد إنشاء الجداول بـ `CREATE TABLE IF NOT EXISTS` ويعيد إدراج البذرة). أمر `DROP` قبل إعادة الاستيراد: غير موجود في الملف، لذلك تكرار `INSERT` للمستخدم `admin` قد يصطدم بقيد `UNIQUE` على `username`.

## 34. تشخيص المشكلات

| العرض | ما يطابق الملفات |
| --- | --- |
| «خطأ في الاتصال بقاعدة البيانات.» | فشل PDO في `database.php` (خدمة MySQL أو بيانات الاتصال) |
| صفحة الإعداد تطبع استثناء SQL | `setup.php` نفّذ عبارة فشلت، مثل تكرار مفتاح فريد |
| لوحة الإدارة تعيد إلى `login.php` | الجلسة بلا `user_id` أو اسم المستخدم ليس `admin` |
| الصور لا تظهر | المسار في `dishes.image` يشير إلى ملف غير موجود تحت `assets/images/` |
| البحث لا يصفّي | `content.php` يحمّل `assets/js/main.js` في أسفل الصفحة. تعطيل JavaScript يبقي كل البطاقات ظاهرة |

## 35. الاعتماديات

اعتماديات PHP من المستودع (`composer.json`): غير موجودة. المطلوب تشغيلياً من الكود: PHP مع PDO MySQL، وخادم ويب أو مفسر PHP، وMySQL أو متوافق يقبل الصيغة في `seed.sql`. JavaScript خارجي: غير مستورد في `main.js`.

## 36. القيود المعروفة

- صلاحية الإدارة مربوطة باسم المستخدم `admin` وليس بدور في الجدول.
- `admin/reset_admin_password.php` و`setup.php` بلا فحص جلسة.
- حذف الطبق بطلب GET.
- رسائل `contacts` بلا شاشة إدارة.
- السلة والطلب والدفع: غير موجودة.
- أيقونة المتصفح: غير موجودة في الصفحات.
- صور البذرة مشار إليها بالنص وقد لا تكون الملفات ضمن المجلد الحالي.

## 37. حالة النظام الحالية

الملفات الموجودة تغطي العرض والتسجيل والتواصل وإدارة الأطباق. لوحة لرسائل التواصل، ونظام طلب، وملف `.env`، و`.htaccess`، واختبارات: غير موجودة. رقم إصدار منتج في ملف إعداد: غير موجود. التذييل يعرض سنة 2025 كنص ثابت.

## 38. قرارات المعمارية

| القرار الظاهر في الملفات | الأثر |
| --- | --- |
| صفحات PHP منفصلة بلا موجه | كل عنوان يطابق ملفاً |
| PDO مع عبارات محضرة للمدخلات | قيم النماذج لا تُدمج كنص SQL مباشر في الصفحات المقروءة |
| فلترة القائمة في المتصفح | البحث لا يرسل طلباً جديداً إلى الخادم |
| إنشاء القاعدة داخل `database.php` | أول اتصال ناجح بمستخدم يملك صلاحية `CREATE DATABASE` ينشئ `aalam_alnakhat` |
| المدير = اسم المستخدم | عمود `role`: غير موجود |

## 39. سجل التغييرات

ملف سجل إصدارات أو Git موثق داخل المشروع: غير موجود في الملفات الحالية.

## System Overview

عالم النكهات موقع PHP/MySQL لعرض أطباق (`dishes`) وإدارة حسابات (`users`) ورسائل (`contacts`). الصفحة الرئيسية تعرض آخر 6 أطباق. صفحة الأطباق تعرض الكل مع بحث محلي. الإدارة متاحة لحساب الجلسة الذي اسمه `admin`.

## Quick Reference

| البند | القيمة |
| --- | --- |
| القاعدة | `aalam_alnakhat` |
| الاتصال | `database.php` |
| البذرة | `sql/seed.sql` عبر `setup.php` |
| الجداول | `users`, `dishes`, `contacts` |
| المدير | اسم المستخدم `admin` |
| البريد في البذرة | `admin@example.com` |
| التنسيق | `assets/css/style.css` |
| السلوك | `assets/js/main.js` |

## Quick Start

1. شغّل MySQL وخادم PHP على مجلد المشروع.
2. راجع `database.php`.
3. افتح `setup.php` مرة واحدة.
4. افتح `index.php`.
5. ادخل بحساب `admin` إن كانت كلمة المرور المعروفة لديك تطابق التجزئة في `users`، أو افتح `admin/reset_admin_password.php` وهو يعرض كلمة المرور الجديدة في الصفحة (الملف بلا فحص جلسة).

## For Non-Technical Users

الموقع يعرض أطباقاً بأسعار وسعرات ونوع مطبخ. يمكن البحث في صفحة الأطباق وكتابة رسالة من صفحة التواصل. إنشاء حساب يسمح بتعديل الاسم والبريد. إدارة الأطباق تظهر لصاحب حساب المدير فقط. شراء الأطباق من الموقع: غير موجود في الصفحات الحالية.

## For Developers

ابدأ من `database.php` ثم `sql/seed.sql`. كل صفحة تكرر شريط التنقل. شرط الإدارة في الصفحات: `$_SESSION['username'] === 'admin'`. أضف عموداً أو صفحة جديدة بجانب هذا النمط لأن موجه مسارات مركزي غير موجود. تجنب طباعة كلمات المرور في التوثيق، وتجنب ترك `setup.php` و`reset_admin_password.php` متاحين على خادم عام كما هما الآن.
