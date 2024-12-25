<?php
include('db.php');

// ฟังก์ชันเข้ารหัสรหัสผ่าน
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);  // ใช้ BCRYPT ในการเข้ารหัส
}

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // เข้ารหัสรหัสผ่าน
    $hashed_password = hashPassword($password);

    // SQL สำหรับเพิ่มแอดมินใหม่
    $sql = "INSERT INTO admins (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<p>เพิ่มแอดมินใหม่สำเร็จ!</p>";
    } else {
        echo "<p>เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแอดมินใหม่</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>เพิ่มแอดมินใหม่</h1>
    </header>

    <section class="add-admin-form">
        <form action="add_admin.php" method="post">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" id="password" required>

            <label for="email">อีเมล:</label>
            <input type="email" name="email" id="email" required>

            <button type="submit">เพิ่มแอดมิน</button>
        </form>
    </section>
</body>
</html>
