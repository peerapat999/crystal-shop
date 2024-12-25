<?php
session_start();
include('db.php');

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลในฐานข้อมูล
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // ถ้าพบแอดมิน
        $admin = mysqli_fetch_assoc($result);
        
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;  // ตั้งค่าตัวแปร session
            header('Location: admin_dashboard.php');  // ไปที่หน้าแดชบอร์ด
            exit;
        } else {
            $error_message = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error_message = "ไม่พบชื่อผู้ใช้นี้";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบแอดมิน</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>เข้าสู่ระบบแอดมิน</h1>
    </header>

    <section class="admin-login">
        <form action="admin_login.php" method="post">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
    </section>
</body>
</html>
