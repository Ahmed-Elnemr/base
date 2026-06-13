# 🚀 دليل رفع المشروع على السيرفر - Deployment Guide

## 📋 الخطوات المطلوبة بعد رفع الكود

بعد رفع الكود على السيرفر، يجب تنفيذ الخطوات التالية بالترتيب:

---

## 1️⃣ تحديث الـ Dependencies

### Composer
```bash
composer install --optimize-autoloader --no-dev
```

**ملاحظة:** استخدم `--no-dev` في بيئة الإنتاج لتجنب تثبيت الحزم التطويرية.

### NPM (إذا كان هناك frontend)
```bash
npm install
npm run build
```

---

## 2️⃣ إعداد ملف البيئة (.env)

تأكد من تحديث ملف `.env` بالإعدادات الصحيحة للسيرفر:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

---

## 3️⃣ تشغيل الـ Migrations

### تشغيل جميع الـ Migrations
```bash
php artisan migrate --force
```

**ملاحظة:** الـ `--force` مطلوب في بيئة الإنتاج.

### إذا كنت تريد إعادة بناء قاعدة البيانات من الصفر (⚠️ خطر!)
```bash
php artisan migrate:fresh --force --seed
```

**تحذير:** هذا الأمر سيحذف جميع البيانات! استخدمه فقط في أول نشر أو في بيئة تطوير.

---

## 4️⃣ تشغيل الـ Seeders (الإعدادات الأساسية)

### تشغيل seeder الإعدادات فقط
```bash
php artisan db:seed --class="Modules\Setting\database\seeders\SettingDatabaseSeeder" --force
```

هذا سيضيف:
- اللوجو (عربي/إنجليزي)
- سياسة الخصوصية
- الشروط والأحكام
- روابط السوشيال ميديا

---

## 5️⃣ تحسين الأداء (Performance Optimization)

### Cache التكوينات
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### تحسين Composer Autoloader
```bash
composer dump-autoload --optimize
```

---

## 6️⃣ إعداد الصلاحيات (Permissions)

تأكد من أن السيرفر لديه صلاحيات الكتابة على المجلدات التالية:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

**ملاحظة:** `www-data` هو المستخدم الافتراضي لـ Apache/Nginx. قد يختلف حسب السيرفر.

---

## 7️⃣ إنشاء Symbolic Link للملفات العامة

```bash
php artisan storage:link
```

هذا مطلوب لعرض الصور والملفات المرفوعة (اللوجو، صور الخدمات، إلخ).

---

## 8️⃣ إعداد الـ Queue Worker (اختياري ولكن موصى به)

إذا كنت تستخدم Queues (للإشعارات أو المهام الثقيلة):

### باستخدام Supervisor (موصى به)
أنشئ ملف `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

ثم:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

### أو باستخدام Cron Job (بديل أبسط)
أضف إلى crontab:
```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 9️⃣ تشغيل Laravel Scheduler (للمهام المجدولة)

أضف إلى crontab:
```bash
crontab -e
```

ثم أضف:
```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔟 التحقق من التثبيت

### تحقق من حالة التطبيق
```bash
php artisan about
```

### تحقق من الـ Migrations
```bash
php artisan migrate:status
```

### تحقق من الإعدادات
```bash
php artisan tinker --execute="print_r(Modules\Setting\app\Models\Setting::all(['key'])->pluck('key')->toArray())"
```

يجب أن ترى:
```
Array
(
    [0] => logo_ar
    [1] => logo_en
    [2] => privacy_policy
    [3] => terms_conditions
    [4] => social_facebook
    [5] => social_twitter
    [6] => social_instagram
    [7] => social_snapchat
    [8] => social_tiktok
)
```

---

## ⚠️ ملاحظات مهمة

### 1. الإشعارات (Notifications)
- جدول `notifications` تم إنشاؤه تلقائياً عبر الـ migration.
- الإشعارات التلقائية ستعمل فوراً بعد رفع الكود.
- تأكد من أن `databaseNotifications()` مفعّل في `AdminPanelProvider`.

### 2. الإعدادات (Settings)
- **مهم جداً:** قم بتشغيل الـ seeder للإعدادات لإنشاء المفاتيح الأساسية.
- لا تحذف أي إعداد من الداشبورد (محمي بالفعل).
- يمكنك تعديل القيم فقط من `admin/settings`.

### 3. الخدمات (Services)
- التعديلات على الخدمات تدعم الآن اللغة الواحدة فقط.
- لن تحتاج لإرسال اللغتين معاً عند التحديث.

### 4. الأمان
- تأكد من `APP_DEBUG=false` في الإنتاج.
- غيّر `APP_KEY` إذا لم يكن موجوداً: `php artisan key:generate --force`
- استخدم HTTPS دائماً.

---

## 📝 Checklist سريع

- [ ] `composer install --optimize-autoloader --no-dev`
- [ ] تحديث ملف `.env`
- [ ] `php artisan migrate --force`
- [ ] `php artisan db:seed --class="Modules\Setting\database\seeders\SettingDatabaseSeeder" --force`
- [ ] `php artisan storage:link`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `chmod -R 775 storage bootstrap/cache`
- [ ] إعداد Supervisor أو Cron للـ Queue
- [ ] إعداد Cron للـ Scheduler
- [ ] `php artisan about` للتحقق

---

## 🆘 استكشاف الأخطاء

### خطأ في الصلاحيات
```bash
sudo chown -R www-data:www-data /path/to/project
sudo chmod -R 775 storage bootstrap/cache
```

### خطأ في الـ Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### خطأ في الـ Autoload
```bash
composer dump-autoload
```

### الصور لا تظهر
```bash
php artisan storage:link
```

---

## 🎯 الخلاصة

**الأوامر الأساسية بالترتيب:**

```bash
# 1. التثبيت
composer install --optimize-autoloader --no-dev

# 2. قاعدة البيانات
php artisan migrate --force
php artisan db:seed --class="Modules\Setting\database\seeders\SettingDatabaseSeeder" --force

# 3. الروابط والصلاحيات
php artisan storage:link
chmod -R 775 storage bootstrap/cache

# 4. التحسين
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. التحقق
php artisan about
```

**تم! المشروع جاهز للعمل على السيرفر 🚀**
