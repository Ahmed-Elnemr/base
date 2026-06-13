<?php

$arPath = __DIR__ . '/resources/lang/ar.json';
$enPath = __DIR__ . '/resources/lang/en.json';

$arContent = json_decode(file_get_contents($arPath), true);
$enContent = json_decode(file_get_contents($enPath), true);

$newTranslations = [
    'User' => 'مستخدم',
    'Users' => 'المستخدمين',
    'Users Management' => 'إدارة المستخدمين',
    'Task' => 'مهمة',
    'Tasks' => 'المهام',
    'Tasks Management' => 'إدارة المهام',
    'Attendance' => 'حضور',
    'Attendances' => 'سجلات الحضور',
    'Attendances Management' => 'إدارة الحضور',
    'Total Users' => 'إجمالي المستخدمين',
    'Active Now' => 'نشط الآن',
    'Pending Tasks' => 'المهام المعلقة',
    'Completed Today' => 'منجز اليوم',
    'Title' => 'العنوان',
    'Assigned To' => 'مسند إلى',
    'Priority' => 'الأولوية',
    'Due Date' => 'تاريخ التسليم',
    'Due From' => 'تاريخ الاستحقاق من',
    'Due To' => 'تاريخ الاستحقاق إلى',
    'Start Time' => 'وقت البدء',
    'End Time' => 'وقت الانتهاء',
    'Total Hours' => 'إجمالي الساعات',
    'Status' => 'الحالة',
    'Achievement Report' => 'تقرير الإنجاز',
    'Deduction Value' => 'قيمة الخصم',
    'Deduction Reason' => 'سبب الخصم',
    'Pending' => 'قيد الانتظار',
    'In Progress' => 'جاري العمل',
    'Completed' => 'مكتمل',
    'Active' => 'نشط',
    'Inactive' => 'غير نشط',
    'Low' => 'منخفض',
    'Medium' => 'متوسط',
    'High' => 'عالي',
    'Description' => 'الوصف',
    'From Date' => 'من تاريخ',
    'To Date' => 'إلى تاريخ',
    'Project Tasks' => 'مهام المشروع',
    'Attendance Trends' => 'مؤشرات الحضور',
    'Active Users' => 'المستخدمين النشطين',
    'New This Month' => 'جديد هذا الشهر',
    'Dashboard Stats' => 'إحصائيات النظام'
];

$arContent = array_merge($arContent, $newTranslations);
ksort($arContent);

$enContent = array_merge($enContent, array_combine(array_keys($newTranslations), array_keys($newTranslations)));
ksort($enContent);

file_put_contents($arPath, json_encode($arContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents($enPath, json_encode($enContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Translations updated.\n";
