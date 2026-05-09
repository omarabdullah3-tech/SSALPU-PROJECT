<?php
session_start();

// Set default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Check if a language change was requested
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] == 'ar' ? 'ar' : 'en';
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$lang = $_SESSION['lang'];

// Translation Dictionary
$texts = [
    'en' => [
        'home' => 'Home',
        'search' => 'Search Files',
        'browse' => 'Browse All',
        'upload' => 'Upload Files',
        'logout' => 'Logout',
        'welcome' => 'Welcome, ',
        'upload_title' => 'Upload Files',
        'subject' => 'Subject Name',
        'major' => 'Major',
        'semester' => 'Semester',
        'yt_link' => 'YouTube Link',
        'send' => 'Send Resource',
        'lang_btn' => 'العربية'
    ],
    'ar' => [
        'home' => 'الرئيسية',
        'search' => 'البحث عن ملفات',
        'browse' => 'تصفح الكل',
        'upload' => 'رفع ملفات',
        'logout' => 'تسجيل الخروج',
        'welcome' => 'مرحباً، ',
        'upload_title' => 'رفع الملفات',
        'subject' => 'اسم المادة',
        'major' => 'التخصص',
        'semester' => 'الفصل الدراسي',
        'yt_link' => 'رابط يوتيوب',
        'send' => 'إرسال الملف',
        'lang_btn' => 'English'
    ]
];

$t = $texts[$lang];
$dir = ($lang == 'ar') ? 'rtl' : 'ltr';
?>
