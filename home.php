<?php
session_start();

// حماية الصفحة: إذا لم يسجل المستخدم دخوله، يتم طرده لصفحة الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الرئيسية</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .home-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            padding: 50px;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2);
            max-width: 500px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            background: #23d5ab;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            box-shadow: 0 0 20px rgba(35, 213, 171, 0.5);
        }

        h1 { font-weight: 300; margin-bottom: 10px; }
        p { opacity: 0.8; line-height: 1.6; }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(35, 213, 171, 0.2);
            border: 1px solid #23d5ab;
            border-radius: 20px;
            color: #23d5ab;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background: #e73c7e;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #ff4d4d;
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(231, 60, 126, 0.4);
        }
    </style>
</head>
<body>

<div class="home-container">
    <div class="avatar">👤</div>
    <div class="status-badge">متصل الآن الآمن (PDO)</div>
    <h1>أهلاً بك، <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>لقد نجحت في عبور نظام الحماية. كلمة مرورك الآن مخزنة في قاعدة بيانات MariaDB على شكل Hash غير قابل للفك.</p>
    
    <a href="logout.php" class="logout-btn">تسجيل الخروج الآمن</a>
</div>

</body>
</html>

