<?php
include('db.php');

// ตรวจสอบว่าได้รับ id ของสินค้ามาหรือไม่
if (!isset($_GET['id'])) {
    echo "ไม่พบสินค้านี้";
    exit;
}

$product_id = $_GET['id'];

// ดึงข้อมูลสินค้าที่ต้องการแสดง
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo "ไม่พบสินค้านี้";
    exit;
}

$product = mysqli_fetch_assoc($result);
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
    </header>

    <section class="product-details">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p>ราคา: <?php echo number_format($product['price'], 2); ?> บาท</p>
        <p>คำอธิบาย: <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <!-- รูปภาพสินค้า (ถ้ามี) -->
        <?php if (!empty($product['image'])): ?>
            <img src="uploads/<?php echo $product['image']; ?>" alt="รูปภาพสินค้า" class="product-image">
        <?php else: ?>
            <p>ไม่มีรูปภาพ</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>© 2024 Crystal Shop. All rights reserved.</p>
    </footer>

</body>
</html>
