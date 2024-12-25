<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // อัปเดตสถานะคำสั่งซื้อ
    $sql_update = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<p>อัปเดตสถานะคำสั่งซื้อเรียบร้อยแล้ว</p>";
        header('Location: admin_dashboard.php'); // กลับไปที่แดชบอร์ดแอดมิน
        exit;
    } else {
        echo "<p>เกิดข้อผิดพลาดในการอัปเดตสถานะ: " . mysqli_error($conn) . "</p>";
    }
}
?>
