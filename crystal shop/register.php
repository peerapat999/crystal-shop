<?php
session_start();  // เริ่มต้น session
include('db.php');  // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการสมัครสมาชิก
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // ตรวจสอบว่าอีเมลถูกใช้แล้วหรือไม่
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error = "อีเมลนี้ถูกใช้งานแล้ว กรุณาใช้อีเมลอื่น";
    } else {
        // เข้ารหัสรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // เพิ่มข้อมูลผู้ใช้ใหม่ลงในฐานข้อมูล
        $sql_insert = "INSERT INTO users (name, email, password, phone, address) 
                       VALUES ('$name', '$email', '$hashed_password', '$phone', '$address')";

        if (mysqli_query($conn, $sql_insert)) {
            // หากการสมัครสมาชิกสำเร็จ, ให้ผู้ใช้เข้าสู่ระบบทันที
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = mysqli_insert_id($conn);  // ใช้ user_id ที่ถูกสร้างขึ้นใหม่
            header('Location: profile.php');  // ไปยังหน้าโปรไฟล์
            exit;
        } else {
            $error = "เกิดข้อผิดพลาดในการสมัครสมาชิก: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <!-- เชื่อมต่อกับ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Registration Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">สมัครสมาชิก</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อ</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">ที่อยู่</label>
                        <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">สมัครสมาชิก</button>
                </form>
                <p class="mt-3 text-center">มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
            </div>
        </div>
    </div>

    <!-- เชื่อมต่อกับ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
