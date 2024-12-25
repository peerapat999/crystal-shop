<?php
session_start();
include('db.php'); // เชื่อมต่อฐานข้อมูล

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id']; // ใช้ user_id ที่เก็บใน session ของผู้ใช้

// ดึงข้อมูลประวัติการสั่งซื้อ
$sql = "SELECT orders.*, products.name, products.price FROM orders
        INNER JOIN products ON orders.product_id = products.id
        WHERE orders.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php">Crystal Shop</a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">หน้าหลัก</a></li>
                    <li><a href="products.php">สินค้า</a></li>
                    <li><a href="about.php">เกี่ยวกับเรา</a></li>
                    <li><a href="contact.php">ติดต่อเรา</a></li>
                    <li><a href="profile.php">โปรไฟล์</a></li>
                    <li><a href="order_history.php">ประวัติการสั่งซื้อ</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Order History Content -->
    <section class="order-history-section">
        <div class="container">
            <h1>ประวัติการสั่งซื้อของคุณ</h1>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>รวม</th>
                        <th>วันที่สั่งซื้อ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['name']); ?></td>
                            <td><?php echo number_format($order['price'], 2); ?> บาท</td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo number_format($order['price'] * $order['quantity'], 2); ?> บาท</td>
                            <td><?php echo date("d/m/Y", strtotime($order['order_date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

</body>
</html>
