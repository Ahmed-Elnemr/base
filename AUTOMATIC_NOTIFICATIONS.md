# 🔔 الإشعارات التلقائية - Automatic Notifications

## ✅ تم التطبيق

تم إضافة نظام إشعارات تلقائي يُرسل للإدارة عند حدوث أحداث مهمة في التطبيق.

---

## 📋 الإشعارات المُفعّلة

### 1. **تسجيل مستخدم جديد** (NewUserRegisteredNotification)
- **متى يُرسل:** عند تسجيل مستخدم جديد (فرد أو شركة)
- **المستلمون:** جميع المشرفين (Admins)
- **المحتوى:**
  - العنوان: "تسجيل مستخدم جديد" / "New User Registered"
  - الرسالة: "تم تسجيل [نوع] جديد: [اسم المستخدم]"
- **الملف:** `app/Notifications/NewUserRegisteredNotification.php`

### 2. **تسجيل دخول مستخدم** (UserLoggedInNotification)
- **متى يُرسل:** عند تسجيل دخول أي مستخدم
- **المستلمون:** جميع المشرفين (Admins)
- **المحتوى:**
  - العنوان: "تسجيل دخول مستخدم" / "User Logged In"
  - الرسالة: "قام [اسم المستخدم] بتسجيل الدخول إلى النظام"
- **الملف:** `app/Notifications/UserLoggedInNotification.php`

### 3. **تحديث الملف الشخصي** (ProfileUpdatedNotification)
- **متى يُرسل:** عند تحديث المستخدم لملفه الشخصي
- **المستلمون:** جميع المشرفين (Admins)
- **المحتوى:**
  - العنوان: "تحديث الملف الشخصي" / "Profile Updated"
  - الرسالة: "قام [اسم المستخدم] بتحديث ملفه الشخصي"
- **الملف:** `app/Notifications/ProfileUpdatedNotification.php`

### 4. **مشاهدة خدمة** (ServiceViewedNotification)
- **متى يُرسل:** عند مشاهدة مستخدم مسجل دخول لتفاصيل خدمة
- **المستلمون:** جميع المشرفين (Admins)
- **المحتوى:**
  - العنوان: "مشاهدة خدمة" / "Service Viewed"
  - الرسالة: "قام [اسم المستخدم] بمشاهدة خدمة: [اسم الخدمة]"
- **الملف:** `app/Notifications/ServiceViewedNotification.php`

---

## 🎯 الملفات المُعدّلة

### 1. **AuthController.php**
```php
app/Http/Controllers/Api/AuthController.php
```
- ✅ إضافة إشعار عند التسجيل (register)
- ✅ إضافة إشعار عند تسجيل الدخول (login)
- ✅ إضافة إشعار عند تحديث البروفايل (updateProfile)

### 2. **ServiceApiController.php**
```php
Modules/Catalog/app/Http/Controllers/ServiceApiController.php
```
- ✅ إضافة إشعار عند مشاهدة خدمة (show)

### 3. **AdminPanelProvider.php**
```php
app/Providers/Filament/AdminPanelProvider.php
```
- ✅ تفعيل `databaseNotifications()`
- ✅ تفعيل `databaseNotificationsPolling('10s')` - التحديث كل 10 ثواني

---

## 🔔 عرض الإشعارات في الداشبورد

### في الـ Navbar
الإشعارات الآن تظهر في الـ navbar العلوي في الداشبورد:
- 🔔 أيقونة الجرس في الأعلى
- عدد الإشعارات غير المقروءة
- تحديث تلقائي كل 10 ثواني
- قائمة منسدلة بآخر الإشعارات

### كيفية الوصول
1. افتح الداشبورد: `admin/`
2. انظر للـ navbar العلوي
3. ستجد أيقونة 🔔 في الأعلى
4. اضغط عليها لرؤية الإشعارات

---

## 📊 كيف يعمل النظام

### 1. عند حدوث الحدث
```php
// مثال: تسجيل دخول
$admins = User::where('client_type', 'admin')->get();
if ($admins->isNotEmpty()) {
    Notification::send($admins, new UserLoggedInNotification($user));
}
```

### 2. تخزين الإشعار
- يُحفظ في جدول `notifications`
- يُربط بالمستخدم المستلم (Admin)
- يحتوي على البيانات (title, body, type, model_id)

### 3. عرض الإشعار
- يظهر في الـ navbar تلقائياً
- يُحدّث كل 10 ثواني
- يمكن قراءته أو حذفه

---

## 🎨 تخصيص الإشعارات

### إضافة إشعار جديد

1. **إنشاء Notification Class:**
```bash
php artisan make:notification YourNotificationName
```

2. **تعديل الـ Class:**
```php
public function toArray(object $notifiable): array
{
    return [
        'title' => [
            'en' => 'English Title',
            'ar' => 'العنوان بالعربية'
        ],
        'body' => [
            'en' => 'English message',
            'ar' => 'الرسالة بالعربية'
        ],
        'type' => 'your_type',
        'model_id' => $this->modelId,
    ];
}
```

3. **إرسال الإشعار:**
```php
$admins = User::where('client_type', 'admin')->get();
Notification::send($admins, new YourNotificationName($data));
```

---

## 🔍 أمثلة إضافية مقترحة

### إشعارات يمكن إضافتها:
- ✅ **طلب جديد** - عند إنشاء طلب
- ✅ **تحديث حالة طلب** - عند تغيير حالة الطلب
- ✅ **رسالة دعم جديدة** - عند استلام رسالة دعم
- ✅ **تقييم جديد** - عند إضافة تقييم
- ✅ **تعليق جديد** - عند إضافة تعليق
- ✅ **دفعة جديدة** - عند إتمام دفعة

---

## 📱 الإشعارات في الـ API

### الـ Endpoints المتوفرة:
```
GET    /api/v1/notifications          - جلب الإشعارات
GET    /api/v1/notifications/unread   - عدد غير المقروءة
DELETE /api/v1/notifications/{uuid}   - حذف إشعار
DELETE /api/v1/notifications          - حذف الكل
```

راجع `NOTIFICATIONS_SYSTEM.md` للتفاصيل الكاملة.

---

## ⚙️ الإعدادات

### تغيير وقت التحديث
في `AdminPanelProvider.php`:
```php
->databaseNotificationsPolling('10s')  // كل 10 ثواني
->databaseNotificationsPolling('30s')  // كل 30 ثانية
->databaseNotificationsPolling('1m')   // كل دقيقة
```

### تعطيل الإشعارات التلقائية
احذف أو علّق على السطور في الـ Controllers:
```php
// $admins = User::where('client_type', 'admin')->get();
// Notification::send($admins, new YourNotification($data));
```

---

## 🎉 النتيجة النهائية

الآن الإدارة ستستلم إشعارات فورية عن:
- ✅ كل مستخدم جديد يسجل
- ✅ كل مستخدم يسجل دخول
- ✅ كل تحديث للبروفايل
- ✅ كل مشاهدة لخدمة من مستخدم مسجل

**الإشعارات تظهر في الـ navbar وتُحدّث تلقائياً!** 🔔✨

---

**تم التطبيق بنجاح!** 🎊
