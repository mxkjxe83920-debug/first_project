<?php
$host = 'localhost';
$db   = 'my_school_db';
$user = 'student'; // غيرنا الاسم هنا
$pass = '123456';  // أضفنا كلمة المرور هنا

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال: " . $e->getMessage());
}
?>
