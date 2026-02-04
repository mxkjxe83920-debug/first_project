<?php
require 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // تشفير كلمة المرور (Hash)
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // التحقق أولاً إذا كان اسم المستخدم موجوداً مسبقاً
        $check = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $check->execute([$user]);
        
        if ($check->rowCount() > 0) {
            $message = "<div style='color: #ff4d4d;'>عذراً، اسم المستخدم موجود بالفعل!</div>";
        } else {
            // إدخال البيانات
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$user, $hashed_pass])) {
                $message = "<div style='color: #23d5ab;'>تم إنشاء الحساب بنجاح! <a href='login.php' style='color: #fff; text-decoration: underline;'>سجل دخولك من هنا</a></div>";
            }
        }
    } catch (PDOException $e) {
        $message = "<div style='color: #ff4d4d;'>خطأ في القاعدة: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد</title>
    <style>
        /* سنستخدم نفس تصميم صفحة اللوجن ليكون التناسق تاماً */
        body {
            margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(-45deg, #23a6d5, #23d5ab, #ee7752, #e73c7e);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh; display: flex; justify-content: center; align-items: center;
        }
        @keyframes gradient { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px; padding: 40px; width: 350px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1); text-align: center; color: white;
        }
        input {
            width: 100%; padding: 12px 0; background: transparent; border: none;
            border-bottom: 1px solid #fff; outline: none; color: #fff;
            font-size: 16px; margin-bottom: 20px; box-sizing: border-box;
        }
        button {
            width: 100%; padding: 12px; border: none; border-radius: 25px;
            background: #23d5ab; color: white; font-weight: bold; cursor: pointer; transition: 0.3s;
        }
        button:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .msg { margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

<div class="register-container">
    <h2>إنشاء حساب جديد</h2>
    <div class="msg"><?php echo $message; ?></div>
    
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="اختر اسم مستخدم" required>
        <input type="password" name="password" placeholder="اختر كلمة مرور قوية" required>
        <button type="submit">تأكيد التسجيل</button>
    </form>
    
    <div style="margin-top: 20px;">
        <a href="login.php" style="color: #fff; font-size: 12px; text-decoration: none; opacity: 0.8;">لديك حساب؟ سجل دخولك</a>
    </div>
</div>

</body>
</html>
