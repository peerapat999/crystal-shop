<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

// ตรวจสอบว่าเรามี `order_id` จาก URL
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // ดึงข้อมูลคำสั่งซื้อจากฐานข้อมูล
    $sql_order = "SELECT orders.id AS order_id, orders.user_id, orders.product_id, orders.quantity, orders.status, users.username, users.email
                  FROM orders 
                  INNER JOIN users ON orders.user_id = users.id 
                  WHERE orders.id = '$order_id'";
    $result_order = mysqli_query($conn, $sql_order);

    if (mysqli_num_rows($result_order) == 0) {
        echo "<p>ไม่พบคำสั่งซื้อนี้ในระบบ</p>";
        exit;
    }

    $order = mysqli_fetch_assoc($result_order);

    // ดึงข้อมูลสินค้าที่เกี่ยวข้อง
    $product_id = $order['product_id'];
    $sql_product = "SELECT * FROM products WHERE id = '$product_id'";
    $result_product = mysqli_query($conn, $sql_product);
    $product = mysqli_fetch_assoc($result_product);
} else {
    echo "<p>ไม่พบคำสั่งซื้อที่ระบุ</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดคำสั่งซื้อ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>รายละเอียดคำสั่งซื้อ #<?php echo $order['order_id']; ?></h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">กลับสู่แดชบอร์ด</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- ส่วนแสดงข้อมูลคำสั่งซื้อ -->
        <section class="order-details">
            <h2>ข้อมูลคำสั่งซื้อ</h2>
            <p><strong>รหัสคำสั่งซื้อ:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>ชื่อผู้สั่งซื้อ:</strong> <?php echo $order['username']; ?></p>
            <p><strong>อีเมล:</strong> <?php echo $order['email']; ?></p>
            <p><strong>จำนวน:</strong> <?php echo $order['quantity']; ?> ชิ้น</p>
            <p><strong>สถานะคำสั่งซื้อ:</strong> <?php echo $order['status']; ?></p>
        </section>

        <!-- ส่วนแสดงข้อมูลสินค้า -->
        <section class="product-details">
            <h2>รายละเอียดสินค้า</h2>
            <p><strong>ชื่อสินค้า:</strong> <?php echo $product['name']; ?></p>
            <p><strong>ราคา:</strong> <?php echo number_format($product['price'], 2); ?> บาท</p>
            <p><strong>คำอธิบาย:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        </section>

        <!-- ส่วนแสดงการจัดการคำสั่งซื้อ -->
        <section class="order-actions">
            <h2>การจัดการคำสั่งซื้อ</h2>
            <form action="approve_order.php" method="post">
                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                <label for="status">เปลี่ยนสถานะ:</label>
                <select name="status" id="status">
                    <option value="รอดำเนินการ" <?php echo ($order['status'] == 'รอดำเนินการ') ? 'selected' : ''; ?>>รอดำเนินการ</option>
                    <option value="สำเร็จ" <?php echo ($order['status'] == 'สำเร็จ') ? 'selected' : ''; ?>>สำเร็จ</option>
                    <option value="ยกเลิก" <?php echo ($order['status'] == 'ยกเลิก') ? 'selected' : ''; ?>>ยกเลิก</option>
                </select>
                <button type="submit">อัปเดตสถานะ</button>
            </form>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
