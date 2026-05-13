#!/bin/bash

# 🚀 سكريبت رفع المشروع على السيرفر
# Laravel Deployment Script

echo "🚀 بدء عملية رفع المشروع..."
echo "================================"

# 1. تحديث Dependencies
echo ""
echo "📦 1. تثبيت Composer Dependencies..."
composer install --optimize-autoloader --no-dev

# 2. تشغيل Migrations
echo ""
echo "🗄️  2. تشغيل Database Migrations..."
php artisan migrate --force

# 3. تشغيل Seeders للإعدادات
echo ""
echo "🌱 3. إضافة الإعدادات الأساسية..."
php artisan db:seed --class="Modules\Setting\database\seeders\SettingDatabaseSeeder" --force

# 4. إنشاء Symbolic Link
echo ""
echo "🔗 4. إنشاء Storage Link..."
php artisan storage:link

# 5. تحسين الأداء
echo ""
echo "⚡ 5. تحسين الأداء (Caching)..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. تحسين Autoloader
echo ""
echo "🔧 6. تحسين Composer Autoloader..."
composer dump-autoload --optimize

# 7. إعداد الصلاحيات
echo ""
echo "🔐 7. إعداد الصلاحيات..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# 8. التحقق من التثبيت
echo ""
echo "✅ 8. التحقق من حالة التطبيق..."
php artisan about

echo ""
echo "================================"
echo "✨ تم رفع المشروع بنجاح!"
echo "================================"
echo ""
echo "📋 الخطوات التالية:"
echo "  1. تأكد من إعدادات ملف .env"
echo "  2. راجع صلاحيات المجلدات (www-data)"
echo "  3. إعداد Supervisor للـ Queue (اختياري)"
echo "  4. إعداد Cron للـ Scheduler"
echo ""
echo "🎉 المشروع جاهز للعمل!"
