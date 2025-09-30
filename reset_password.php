<?php
session_start();
$success = "";
if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_role'])) {
    ?>
    
    <!DOCTYPE html>
    <html>
    <head>
        <title>Unauthorized Access</title>
        <style>
            body {
                background: url(img/bg.jpg) no-repeat center center fixed;
                background-size: cover;
                font-family: 'Segoe UI', Arial, sans-serif;
                min-height: 100vh;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error-container {
                background: rgba(220, 38, 38, 0.95);
                color: #fff;
                max-width: 350px;
                width: 100%;
                padding: 32px 28px 24px 28px;
                border-radius: 10px;
                box-shadow: 0 2px 16px rgba(0,0,0,0.08);
                text-align: center;
                font-size: 17px;
                font-weight: 500;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            Unauthorized access.
        </div>
    </body>
    </html>
    <?php
    exit;
}


$email = $_SESSION['reset_email'];
$role = $_SESSION['reset_role'];

if (isset($_POST['new_password'])) {
    $new_password = $_POST['new_password'];
    include "DB_connection.php";

    if ($role === 'admin') {
        $stmt = $conn->prepare("UPDATE admin SET password=? WHERE email=?");
        $stmt->execute([$new_password, $email]);
    } else {
        $stmt = $conn->prepare("UPDATE students SET password=? WHERE email_address=?");
        $stmt->execute([$new_password, $email]);
    }

    // Clear session vars
    unset($_SESSION['reset_email']);
    unset($_SESSION['reset_role']);

    $success = "Password updated successfully. You can now <a href='login.php' style='color:#fff;text-decoration:underline;'>login</a>.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
            background:rgba(255,255,255,0.85);
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
        .form-container input[type="password"] {
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
        .success-message {
            background: #22c55e;
            color: #fff;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 15px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="form-container">
    <?php if ($success): ?>
        <div class="success-message"><?= $success ?></div>
    <?php endif; ?>
    <?php if (!$success): ?>
    <form method="post">
        <label>Enter new password:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
    <?php endif; ?>
</div>
</body>
</html>