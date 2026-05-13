<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

/**
 * إشعار تحديث الملف الشخصي للمستخدم نفسه
 * يُرسل للمستخدم عند تحديث ملفه الشخصي
 */
class UserProfileUpdatedNotification extends Notification
{
    use Queueable, SerializesModels;

    protected array $updatedFields;

    public function __construct(array $updatedFields = [])
    {
        $this->updatedFields = $updatedFields;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $fieldsText = $this->getFieldsText();
        
        return [
            'title' => [
                'en' => 'Profile Updated Successfully',
                'ar' => 'تم تحديث الملف الشخصي بنجاح'
            ],
            'body' => [
                'en' => 'Your profile has been updated successfully.' . ($fieldsText['en'] ? ' Updated fields: ' . $fieldsText['en'] : ''),
                'ar' => 'تم تحديث ملفك الشخصي بنجاح.' . ($fieldsText['ar'] ? ' الحقول المحدثة: ' . $fieldsText['ar'] : '')
            ],
            'type' => 'user_profile_update',
            'model_id' => $notifiable->id,
            'updated_fields' => $this->updatedFields,
        ];
    }

    protected function getFieldsText(): array
    {
        if (empty($this->updatedFields)) {
            return ['en' => '', 'ar' => ''];
        }

        $fieldNames = [
            'name' => ['en' => 'Name', 'ar' => 'الاسم'],
            'email' => ['en' => 'Email', 'ar' => 'البريد الإلكتروني'],
            'phone' => ['en' => 'Phone', 'ar' => 'الهاتف'],
            'city' => ['en' => 'City', 'ar' => 'المدينة'],
            'profile_image' => ['en' => 'Profile Image', 'ar' => 'صورة الملف الشخصي'],
            'password' => ['en' => 'Password', 'ar' => 'كلمة المرور'],
            'company_name' => ['en' => 'Company Name', 'ar' => 'اسم الشركة'],
            'company_bio' => ['en' => 'Company Bio', 'ar' => 'نبذة عن الشركة'],
            'commercial_register' => ['en' => 'Commercial Register', 'ar' => 'السجل التجاري'],
        ];

        $enFields = [];
        $arFields = [];

        foreach ($this->updatedFields as $field) {
            if (isset($fieldNames[$field])) {
                $enFields[] = $fieldNames[$field]['en'];
                $arFields[] = $fieldNames[$field]['ar'];
            }
        }

        return [
            'en' => implode(', ', $enFields),
            'ar' => implode('، ', $arFields)
        ];
    }
}
