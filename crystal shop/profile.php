<?php
session_start();  // เริ่มต้น session
include('db.php');  // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ได้เข้าสู่ระบบแล้ว
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header('Location: login.php');  // ถ้ายังไม่ได้เข้าสู่ระบบ ให้ไปที่หน้า login
    exit;
}

$user_id = $_SESSION['user_id'];  // ใช้ user_id ที่เก็บใน session

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของคุณ</title>
    <!-- เชื่อมต่อกับ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">  <!-- หากคุณมีสไตล์เพิ่มเติมในไฟล์ style.css -->
</head>
<body>

    <!-- Header Section -->
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="index.php" class="text-white text-decoration-none h3">Crystal Shop</a>
            </div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="index.php" class="nav-link text-white">หน้าหลัก</a></li>
                    <li class="nav-item"><a href="products.php" class="nav-link text-white">สินค้า</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link text-white">เกี่ยวกับเรา</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link text-white">ติดต่อเรา</a></li>
                    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                        <li class="nav-item"><a href="profile.php" class="nav-link text-white">โปรไฟล์</a></li>
                        <li class="nav-item"><a href="order_history.php" class="nav-link text-white">ประวัติการสั่งซื้อ</a></li>
                        <li class="nav-item"><a href="logout.php" class="nav-link text-white">ออกจากระบบ</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a href="login.php" class="nav-link text-white">เข้าสู่ระบบ</a></li>
                        <li class="nav-item"><a href="register.php" class="nav-link text-white">สมัครสมาชิก</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Profile Section -->
    <section class="profile-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>โปรไฟล์ของคุณ</h4>
                        </div>
                        <div class="card-body">
                            <!-- ข้อมูลผู้ใช้ -->
                            <h5 class="card-title"><?php echo htmlspecialchars($user['name']); ?></h5>
                            <p class="card-text"><strong>อีเมล:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                            <p class="card-text"><strong>เบอร์โทรศัพท์:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                            <p class="card-text"><strong>ที่อยู่:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                            
                            <a href="edit_profile.php" class="btn btn-warning">แก้ไขโปรไฟล์</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
        </div>
    </footer>

    <!-- เชื่อมต่อกับ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
