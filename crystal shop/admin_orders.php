<?php
session_start();
include('db.php');

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

// ดึงข้อมูลคำสั่งซื้อทั้งหมด
$sql = "SELECT o.id, o.product_id, o.user_id, o.quantity, o.status, p.name AS product_name, u.username AS user_name 
        FROM orders o 
        JOIN products p ON o.product_id = p.id 
        JOIN users u ON o.user_id = u.id";
$result = mysqli_query($conn, $sql);

// อัปเดตสถานะคำสั่งซื้อ
if (isset($_POST['approve'])) {
    $order_id = $_POST['order_id'];
    $sql_update = "UPDATE orders SET status = 'Approved' WHERE id = '$order_id'";
    mysqli_query($conn, $sql_update);
    header('Location: admin_orders.php');  // รีเฟรชหน้า
}

if (isset($_POST['ship'])) {
    $order_id = $_POST['order_id'];
    $sql_update = "UPDATE orders SET status = 'Shipped' WHERE id = '$order_id'";
    mysqli_query($conn, $sql_update);
    header('Location: admin_orders.php');  // รีเฟรชหน้า
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการคำสั่งซื้อ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>จัดการคำสั่งซื้อ</h1>
    </header>

    <section class="admin-orders">
        <div class="container">
            <h2>รายการคำสั่งซื้อ</h2>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>จำนวน</th>
                        <th>สถานะ</th>
                        <th>การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <?php if ($order['status'] == 'Pending'): ?>
                                    <form action="admin_orders.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" name="approve" class="btn">อนุมัติ</button>
                                    </form>
                                <?php endif; ?>
                                <?php if ($order['status'] == 'Approved'): ?>
                                    <form action="admin_orders.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" name="ship" class="btn">ส่งสินค้า</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

</body>
</html>
