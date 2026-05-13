# نظام الإشعارات - المخفض

تم تطبيق نظام إشعارات كامل مطابق لمشروع الألومنيوم في مشروع المخفض.

## 📋 الملفات المُنشأة

### 1. Notification Classes
- **`app/Notifications/CustomNotification.php`**
  - إشعار مخصص يدعم اللغتين العربية والإنجليزية
  - يحفظ الإشعارات في قاعدة البيانات
  - يدعم إضافة `type` و `model_id` للإشعارات

### 2. API Controllers
- **`app/Http/Controllers/Api/NotificationController.php`**
  - `index()` - عرض جميع الإشعارات مع pagination
  - `unreadCount()` - عدد الإشعارات غير المقروءة
  - `deleteNotification($uuid)` - حذف إشعار محدد
  - `deleteAllNotifications()` - حذف جميع الإشعارات

### 3. API Resources
- **`app/Http/Resources/NotificationResource.php`**
  - تحويل بيانات الإشعار إلى JSON
  - تنسيق التاريخ بشكل مقروء
  
- **`app/Http/Resources/NotificationDataResource.php`**
  - عرض محتوى الإشعار حسب اللغة المحددة
  - دعم العنوان والرسالة والنوع ومعرف النموذج

### 4. Filament Resources
- **`app/Filament/Resources/NotificationResource.php`**
  - واجهة إدارة الإشعارات في الداشبورد
  - إرسال للجميع أو لمستخدمين محددين
  - دعم اللغتين في الفورم

- **`app/Filament/Resources/NotificationResource/Pages/ListNotifications.php`**
  - صفحة عرض قائمة الإشعارات

- **`app/Filament/Resources/NotificationResource/Pages/CreateNotification.php`**
  - صفحة إنشاء وإرسال الإشعارات
  - منطق الإرسال للمستخدمين

### 5. Routes
- **`routes/api.php`** - تم إضافة:
  ```php
  Route::middleware('auth:sanctum')->prefix('notifications')->group(function () {
      Route::get('/', [NotificationController::class, 'index']);
      Route::get('/unread', [NotificationController::class, 'unreadCount']);
      Route::delete('/{uuid}', [NotificationController::class, 'deleteNotification']);
      Route::delete('/', [NotificationController::class, 'deleteAllNotifications']);
  });
  ```

### 6. Database Migration
- **`database/migrations/XXXX_create_notifications_table.php`**
  - جدول الإشعارات من Laravel

---

## 🔌 API Endpoints

### 1. عرض جميع الإشعارات
```http
GET /api/v1/notifications
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Notifications loaded successfully.",
  "data": {
    "notifications": {
      "data": [
        {
          "id": "uuid-here",
          "data": {
            "title": "عنوان الإشعار",
            "message": "محتوى الإشعار",
            "type": "custom_notification",
            "model_id": 0
          },
          "is_read": false,
          "created_at": "10:30 pm منذ ساعتين"
        }
      ],
      "current_page": 1,
      "per_page": 10,
      "total": 25
    }
  }
}
```

### 2. عدد الإشعارات غير المقروءة
```http
GET /api/v1/notifications/unread
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Unread notifications count retrieved.",
  "data": {
    "unread_count": 5
  }
}
```

### 3. حذف إشعار محدد
```http
DELETE /api/v1/notifications/{uuid}
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Notification deleted successfully."
}
```

### 4. حذف جميع الإشعارات
```http
DELETE /api/v1/notifications
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "All notifications deleted successfully."
}
```

---

## 🎨 استخدام الإشعارات في الكود

### إرسال إشعار لمستخدم واحد
```php
use App\Models\User;
use App\Notifications\CustomNotification;

$user = User::find(1);

$user->notify(new CustomNotification(
    title: [
        'en' => 'Welcome!',
        'ar' => 'مرحباً!'
    ],
    body: [
        'en' => 'Thank you for joining us.',
        'ar' => 'شكراً لانضمامك إلينا.'
    ],
    type: 'welcome',
    modelId: null
));
```

### إرسال إشعار لعدة مستخدمين
```php
use App\Models\User;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

$users = User::where('status', 1)->get();

Notification::send($users, new CustomNotification(
    title: [
        'en' => 'New Feature Available',
        'ar' => 'ميزة جديدة متاحة'
    ],
    body: [
        'en' => 'Check out our new feature!',
        'ar' => 'تحقق من ميزتنا الجديدة!'
    ],
    type: 'feature_announcement',
    modelId: null
));
```

### إرسال إشعار مرتبط بنموذج معين
```php
use App\Models\User;
use App\Notifications\CustomNotification;

$user = User::find(1);
$orderId = 123;

$user->notify(new CustomNotification(
    title: [
        'en' => 'Order Completed',
        'ar' => 'تم إكمال الطلب'
    ],
    body: [
        'en' => 'Your order #' . $orderId . ' has been completed.',
        'ar' => 'تم إكمال طلبك رقم ' . $orderId
    ],
    type: 'order_completed',
    modelId: $orderId
));
```

---

## 📱 استخدام الداشبورد (Filament)

1. **الوصول للإشعارات:**
   - افتح الداشبورد
   - اذهب إلى قسم "Management"
   - اضغط على "Notifications"

2. **إنشاء إشعار جديد:**
   - اضغط على "Create"
   - اختر "إرسال للكل" أو حدد مستخدمين معينين
   - أدخل العنوان والمحتوى بالعربية والإنجليزية
   - اضغط "Create"

3. **عرض الإشعارات المرسلة:**
   - يمكنك رؤية جميع الإشعارات المرسلة
   - البحث والفلترة
   - حذف إشعارات محددة

---

## 🎯 أمثلة على أنواع الإشعارات المقترحة

### 1. إشعار طلب جديد
```php
$user->notify(new CustomNotification(
    title: [
        'en' => 'New Order Received',
        'ar' => 'تم استلام طلب جديد'
    ],
    body: [
        'en' => 'You have received a new order #' . $orderId,
        'ar' => 'لديك طلب جديد رقم ' . $orderId
    ],
    type: 'new_order',
    modelId: $orderId
));
```

### 2. إشعار تحديث حالة الطلب
```php
$user->notify(new CustomNotification(
    title: [
        'en' => 'Order Status Updated',
        'ar' => 'تم تحديث حالة الطلب'
    ],
    body: [
        'en' => 'Your order #' . $orderId . ' is now ' . $status,
        'ar' => 'طلبك رقم ' . $orderId . ' الآن ' . $statusAr
    ],
    type: 'order_status_update',
    modelId: $orderId
));
```

### 3. إشعار رسالة جديدة من الدعم
```php
$user->notify(new CustomNotification(
    title: [
        'en' => 'New Support Message',
        'ar' => 'رسالة جديدة من الدعم'
    ],
    body: [
        'en' => 'You have a new message from support team',
        'ar' => 'لديك رسالة جديدة من فريق الدعم'
    ],
    type: 'support_message',
    modelId: $ticketId
));
```

### 4. إشعار عرض خاص
```php
$user->notify(new CustomNotification(
    title: [
        'en' => 'Special Offer!',
        'ar' => 'عرض خاص!'
    ],
    body: [
        'en' => 'Get 20% off on all services this week',
        'ar' => 'احصل على خصم 20% على جميع الخدمات هذا الأسبوع'
    ],
    type: 'promotion',
    modelId: null
));
```

### 5. إشعار تذكير
```php
$user->notify(new CustomNotification(
    title: [
        'en' => 'Reminder',
        'ar' => 'تذكير'
    ],
    body: [
        'en' => 'Your appointment is tomorrow at 10:00 AM',
        'ar' => 'موعدك غداً في الساعة 10:00 صباحاً'
    ],
    type: 'reminder',
    modelId: $appointmentId
));
```

---

## ✅ الميزات المطبقة

- ✅ نظام إشعارات كامل بقاعدة البيانات
- ✅ دعم اللغتين العربية والإنجليزية
- ✅ API endpoints كاملة مع authentication
- ✅ واجهة Filament لإدارة الإشعارات
- ✅ إرسال للجميع أو لمستخدمين محددين
- ✅ عدد الإشعارات غير المقروءة
- ✅ حذف إشعار واحد أو الكل
- ✅ Pagination للإشعارات
- ✅ تنسيق التاريخ بشكل مقروء
- ✅ دعم أنواع مختلفة من الإشعارات
- ✅ ربط الإشعارات بنماذج معينة (model_id)

---

## 📝 ملاحظات مهمة

1. **اللغة التلقائية:** يتم عرض الإشعار حسب لغة التطبيق المحددة (`app()->getLocale()`)

2. **القراءة التلقائية:** عند استدعاء endpoint `/notifications`، يتم تعليم جميع الإشعارات كمقروءة تلقائياً

3. **Pagination:** الإشعارات يتم عرضها 10 في كل صفحة (يمكن تعديله)

4. **الأمان:** جميع endpoints محمية بـ `auth:sanctum` middleware

5. **التوسع:** يمكن إضافة أنواع جديدة من الإشعارات بسهولة عن طريق إنشاء Notification classes جديدة

---

## 🚀 الخطوات التالية المقترحة

   - ربط الإشعارات بالأحداث (Events/Listeners) لتقليل الكود في الـ Controllers.
2. **إضافة Email Notifications** (إرسال الإشعارات عبر البريد أيضاً)
3. **إضافة فلاتر في الداشبورد** (حسب النوع، التاريخ، المستخدم)
4. **إضافة إحصائيات** (عدد الإشعارات المرسلة، معدل القراءة، إلخ)
5. **جدولة الإشعارات** (إرسال إشعارات في وقت محدد)

---

تم التطبيق بنجاح! 🎉
