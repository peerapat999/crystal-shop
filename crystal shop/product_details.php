<?php
include('db.php');

// ตรวจสอบว่าได้ส่ง ID มาหรือไม่
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("เกิดข้อผิดพลาดในการดึงข้อมูล: " . mysqli_error($conn));
    }

    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        die("ไม่พบข้อมูลสินค้าดังกล่าว");
    }
} else {
    die("ไม่มีข้อมูลสินค้าที่จะดู");
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดสินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>รายละเอียดสินค้า</h1>
        <nav>
            <a href="index.html">หน้าแรก</a>
            <a href="products.php">สินค้าทั้งหมด</a>
        </nav>
    </header>

    <section class="product-detail">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p>ราคา: ฿<?php echo number_format($product['price'], 2); ?></p>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <a href="products.php" class="back-to-products">กลับไปยังหน้าสินค้า</a>
    </section>

    <footer>
        <p>© 2024 ร้านค้าของออนไลน์</p>
    </footer>
</body>
</html>
