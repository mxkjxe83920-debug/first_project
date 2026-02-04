<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$user]);
        $userData = $stmt->fetch();

        if ($userData && password_verify($pass, $userData['password'])) {
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['username'] = $userData['username'];
            header("Location: home.php");
            exit();
        } else {
            $error = "بيانات الدخول غير صحيحة!";
        }
    } catch (PDOException $e) {
        $error = "خطأ في الاتصال بالقاعدة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | نظام آمن</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00f2fe;
            --secondary: #4facfe;
            --bg-dark: #0f172a;
            --glass: rgba(255, 255, 255, 0.05);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 172, 254, 0.15) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(0, 242, 254, 0.15) 0, transparent 50%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* حاوية التصميم الاحترافي */
        .login-box {
            position: relative;
            width: 400px;
            padding: 40px;
            background: var(--glass);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .login-box:hover {
            transform: translateY(-5px);
            border-color: rgba(79, 172, 254, 0.3);
        }

        h2 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 28px;
        }

        p.subtitle {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-field {
            position: relative;
            margin-bottom: 25px;
        }

        .input-field input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            outline: none;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
            text-align: right;
        }

        .input-field input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(0, 242, 254, 0.2);
            background: rgba(0, 0, 0, 0.4);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, var(--secondary), var(--primary));
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 10px 15px -3px rgba(79, 172, 254, 0.3);
        }

        button:hover {
            opacity: 0.9;
            transform: scale(1.02);
            box-shadow: 0 15px 20px -3px rgba(79, 172, 254, 0.4);
        }

        .error-card {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .footer-links {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* تأثير الدوائر في الخلفية */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(var(--secondary), var(--primary));
            filter: blur(80px);
            z-index: -1;
            opacity: 0.2;
        }
    </style>
</head>
<body>

    <div class="circle" style="width: 300px; height: 300px; top: -150px; left: -150px;"></div>
    <div class="circle" style="width: 200px; height: 200px; bottom: -100px; right: -100px;"></div>

    <div class="login-box">
        <h2>تسجيل الدخول</h2>
        <p class="subtitle">نظام PDO الآمن لتخزين الهاش</p>

        <?php if(isset($error)): ?>
            <div class="error-card"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-field">
                <input type="text" name="username" placeholder="اسم المستخدم" required autocomplete="off">
            </div>
            <div class="input-field">
                <input type="password" name="password" placeholder="كلمة المرور" required>
            </div>
            <button type="submit">دخول آمن</button>
        </form>

        <div class="footer-links">
            <a href="register.php">إنشاء حساب جديد</a>
            <span>•</span>
            <a href="#">نسيت كلمة المرور؟</a>
        </div>
    </div>

</body>
</html>
