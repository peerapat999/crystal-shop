<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบ username และ password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // เช็คข้อมูลในฐานข้อมูล (ในที่นี้ใช้ค่าคงที่)
    if ($username == 'admin' && $password == 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: add_product.php'); // ไปหน้ากรอกข้อมูลสินค้า
        exit;
    } else {
        $error_message = "ข้อมูลไม่ถูกต้อง";
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
        <form action="admin.php" method="post">
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
