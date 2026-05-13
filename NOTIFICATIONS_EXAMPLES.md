# أمثلة استخدام الإشعارات

تم إنشاء أمثلة جاهزة للاستخدام في مجلد `app/Notifications/Examples/`

---

## 📁 الأمثلة المتوفرة

### 1. NewOrderNotification
**الاستخدام:**
```php
use App\Notifications\Examples\NewOrderNotification;

$user->notify(new NewOrderNotification(
    orderId: 123,
    orderNumber: 'ORD-2024-001'
));
```

**متى تستخدمه:** عند إنشاء طلب جديد

---

### 2. OrderStatusUpdatedNotification
**الاستخدام:**
```php
use App\Notifications\Examples\OrderStatusUpdatedNotification;

$user->notify(new OrderStatusUpdatedNotification(
    orderId: 123,
    orderNumber: 'ORD-2024-001',
    status: 'Processing',
    statusAr: 'قيد المعالجة'
));
```

**متى تستخدمه:** عند تحديث حالة الطلب

---

### 3. SupportMessageNotification
**الاستخدام:**
```php
use App\Notifications\Examples\SupportMessageNotification;

$user->notify(new SupportMessageNotification(
    ticketId: 456,
    message: 'Your issue has been resolved'
));
```

**متى تستخدمه:** عند استلام رسالة من فريق الدعم

---

## 🎯 كيفية إنشاء إشعار مخصص جديد

### الخطوة 1: إنشاء Notification Class
```bash
php artisan make:notification YourNotificationName
```

### الخطوة 2: تعديل الـ Class
```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class YourNotificationName extends Notification
{
    use Queueable, SerializesModels;

    protected $yourData;

    public function __construct($yourData)
    {
        $this->yourData = $yourData;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => [
                'en' => 'Your English Title',
                'ar' => 'عنوانك بالعربية'
            ],
            'body' => [
                'en' => 'Your English message',
                'ar' => 'رسالتك بالعربية'
            ],
            'type' => 'your_notification_type',
            'model_id' => $this->yourData->id ?? null,
        ];
    }
}
```

### الخطوة 3: استخدام الإشعار
```php
use App\Notifications\YourNotificationName;

$user = User::find(1);
$user->notify(new YourNotificationName($yourData));
```

---

## 💡 نصائح مهمة

### 1. استخدام Queue للإشعارات الكثيرة
إذا كنت ترسل إشعارات لعدد كبير من المستخدمين، استخدم Queue:

```php
class YourNotification extends Notification implements ShouldQueue
{
    use Queueable;
    // ...
}
```

### 2. إرسال لعدة مستخدمين
```php
use Illuminate\Support\Facades\Notification;

$users = User::where('status', 1)->get();
Notification::send($users, new YourNotification($data));
```

### 3. إرسال لجميع المستخدمين
```php
$users = User::all();
Notification::send($users, new YourNotification($data));
```

### 4. إرسال مع شرط
```php
$users = User::where('client_type', 'company')->get();
Notification::send($users, new YourNotification($data));
```

---

## 🔔 أنواع الإشعارات المقترحة

### للعملاء (Customers)
- ✅ طلب جديد تم إنشاؤه
- ✅ تحديث حالة الطلب
- ✅ الطلب جاهز للاستلام
- ✅ تم إلغاء الطلب
- ✅ رسالة من الدعم
- ✅ عرض خاص
- ✅ تذكير بموعد
- ✅ تقييم الخدمة

### للشركات (Companies)
- ✅ طلب جديد من عميل
- ✅ تحديث بيانات الشركة
- ✅ موافقة على الطلب
- ✅ رفض الطلب
- ✅ دفعة جديدة
- ✅ تقييم من عميل

### للإدارة (Admin)
- ✅ تسجيل مستخدم جديد
- ✅ طلب جديد في النظام
- ✅ شكوى جديدة
- ✅ تقرير يومي
- ✅ تحذير أمني

---

## 📊 مثال كامل: نظام الطلبات

```php
// في OrderController أو OrderObserver

use App\Notifications\Examples\NewOrderNotification;
use App\Notifications\Examples\OrderStatusUpdatedNotification;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // إنشاء الطلب
        $order = Order::create($request->validated());
        
        // إرسال إشعار للعميل
        $request->user()->notify(new NewOrderNotification(
            orderId: $order->id,
            orderNumber: $order->order_number
        ));
        
        // إرسال إشعار للإدارة
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewOrderNotification(
            orderId: $order->id,
            orderNumber: $order->order_number
        ));
        
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ]);
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        
        // إرسال إشعار للعميل بتحديث الحالة
        $order->user->notify(new OrderStatusUpdatedNotification(
            orderId: $order->id,
            orderNumber: $order->order_number,
            status: $request->status,
            statusAr: $this->getStatusInArabic($request->status)
        ));
        
        return response()->json([
            'success' => true,
            'message' => 'Order status updated'
        ]);
    }
    
    private function getStatusInArabic(string $status): string
    {
        return match($status) {
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => $status
        };
    }
}
```

---

## 🚀 الخطوات التالية

1. **نسخ الأمثلة من `Examples/` إلى `app/Notifications/`** عند الحاجة
2. **تعديل الأمثلة** حسب احتياجاتك
3. **إنشاء إشعارات جديدة** باستخدام `php artisan make:notification`
4. **اختبار الإشعارات** عبر Postman أو الداشبورد

---

تم! 🎉
