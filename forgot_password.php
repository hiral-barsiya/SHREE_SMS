<?php
session_start();
if (isset($_POST['email'])) {
    include "DB_connection.php";
    $email = trim($_POST['email']);

    // Check in admin table
    $stmt = $conn->prepare("SELECT admin_id FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_role'] = 'admin';
        header("Location: reset_password.php");
        exit;
    } else {
        $stmt = $conn->prepare("SELECT student_id FROM students WHERE email_address = ?");
        $stmt->execute([$email]);
        $student = $stmt->fetch();

        if ($student) {
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_role'] = 'student';
            header("Location: reset_password.php");
            exit;
        } else {
            $error = "Email not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            background: url(img/back.jpg) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            background: rgba(255,255,255,0.85);
            max-width: 350px;
            margin: 80px auto;
            padding: 32px 28px 24px 28px;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        }
        .form-container label {
            font-weight: 500;
            color: #333;
        }
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px 12px;
            margin: 12px 0 18px 0;
            border: 1px solid #bfc9d4;
            border-radius: 6px;
            font-size: 15px;
        }
        .form-container button {
            width: 100%;
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .form-container button:hover {
            background: #1741a6;
        }
        .form-container p {
            margin-top: 10px;
            color: #e11d48;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="form-container">
    <form method="post">
        <label>Enter your email address:</label>
        <input type="email" name="email" required>
        <button type="submit">Continue</button>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </form>
</div>
</body>
</html>