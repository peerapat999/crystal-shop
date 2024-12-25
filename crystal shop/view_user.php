<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php'); // ถ้าไม่ได้เข้าสู่ระบบให้ไปที่หน้าล็อกอิน
    exit;
}

include('db.php');

// ตรวจสอบว่าได้ ID ของผู้ใช้จาก URL หรือไม่
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // ดึงข้อมูลของผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("ไม่พบผู้ใช้ที่มี ID นี้");
    }

    $user = mysqli_fetch_assoc($result); // ดึงข้อมูลของผู้ใช้
} else {
    die("ไม่พบ ID ของผู้ใช้");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดผู้ใช้</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>รายละเอียดของผู้ใช้</h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">กลับไปที่แดชบอร์ด</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <section class="user-details">
            <h2>ข้อมูลผู้ใช้</h2>
            <table border="1" cellpadding="10">
                <tr>
                    <th>ชื่อผู้ใช้</th>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                </tr>
                <tr>
                    <th>อีเมล</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <th>วันที่สมัคร</th>
                    <td><?php echo isset($user['created_at']) ? $user['created_at'] : 'ไม่ระบุ'; ?></td>
                </tr>
                <tr>
                    <th>สถานะ</th>
                    <td><?php echo isset($user['status']) ? ($user['status'] == 1 ? 'Active' : 'Inactive') : 'ไม่ระบุ'; ?></td>
                </tr>
                <tr>
                    <th>เบอร์โทร</th>
                    <td><?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : 'ไม่ระบุ'; ?></td>
                </tr>
            </table>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
