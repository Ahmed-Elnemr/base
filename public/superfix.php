<?php

// حل شامل لجميع مشاكل السيرفر
$baseDir = __DIR__ . '/..'; // مجلد purple
$bootstrapCacheDir = $baseDir . '/bootstrap/cache';

echo "<h3>Starting Fixes...</h3>";

// 1. مسح الكاش القديم بالكامل
if (is_dir($bootstrapCacheDir)) {
    $files = scandir($bootstrapCacheDir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && $file !== '.gitignore') {
            unlink($bootstrapCacheDir . '/' . $file);
            echo "Deleted cached file: $file <br>";
        }
    }
}

// 2. إنشاء المجلدات الصحيحة لمشروع purple
$directories = [
    $baseDir . '/storage/framework/views',
    $baseDir . '/storage/framework/cache',
    $baseDir . '/storage/framework/sessions',
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0775, true);
        echo "Created correct directory: $dir <br>";
    }
}

// 3. إصلاح مشكلة مجلد vendor الخاطئ (إذا كان موجوداً داخل public بالخطأ)
$wrongVendor = __DIR__ . '/vendor';
if (is_dir($wrongVendor)) {
    echo "<b style='color:red;'>Found WRONG vendor folder inside public! This is the cause of the issue.</b><br>";
    // لن نقوم بحذفه خوفاً من أي خطأ، لكن سنقوم بإعادة تسميته لكي لا يقرأه السيرفر
    rename($wrongVendor, __DIR__ . '/_vendor_wrong');
    echo "Renamed wrong vendor to _vendor_wrong (You can safely delete it later).<br>";
}

// 4. إنشاء اختصار (Symlink) لـ purpletasks
$target = __DIR__ . '/../purpletasks/public';
$link = __DIR__ . '/tasks';

if (!file_exists($link)) {
    if (file_exists($target)) {
        symlink($target, $link);
        echo "Symlink for 'tasks' created successfully!<br>";
    }
} else {
    echo "Symlink 'tasks' already exists!<br>";
}

echo "<br><b style='color:green; font-size: 20px;'>All Fixes Applied Successfully!</b><br>";
echo "<p>Please visit your website now: <a href='/'>Click Here</a></p>";
