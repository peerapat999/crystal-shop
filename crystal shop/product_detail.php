<?php
session_start();
include('db.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าได้รับ `id` ของสินค้ามาจาก URL หรือไม่
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $sql);

    // ตรวจสอบว่าเจอสินค้าที่ตรงกันหรือไม่
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        // ถ้าไม่พบสินค้าให้แสดงข้อความแจ้งเตือน
        echo "ไม่พบสินค้าที่คุณเลือก";
        exit;
    }
} else {
    // ถ้าไม่พบ `id` ใน URL ให้แสดงข้อความแจ้งเตือน
    echo "ไม่มีข้อมูลสินค้าที่เลือก";
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดสินค้า</title>
    <!-- เพิ่ม Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJHo3DPxYJScbY0X7+K5P+46d+F0f+1gfh2k3hfa+K0F3kC5IfLXgY2vqxF5" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .product-image {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
        }
        .product-detail-section {
            padding: 60px 0;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="index.php" class="text-white h3">Crystal Shop</a>
            </div>
            <nav>
                <ul class="list-unstyled d-flex mb-0">
                    <li class="mx-2"><a href="index.php" class="text-white">หน้าหลัก</a></li>
                    <li class="mx-2"><a href="products.php" class="text-white">สินค้า</a></li>
                    <li class="mx-2"><a href="about.php" class="text-white">เกี่ยวกับเรา</a></li>
                    <li class="mx-2"><a href="contact.php" class="text-white">ติดต่อเรา</a></li>
                    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                        <li class="mx-2"><a href="profile.php" class="text-white">โปรไฟล์</a></li>
                        <li class="mx-2"><a href="logout.php" class="text-white">ออกจากระบบ</a></li>
                    <?php else: ?>
                        <li class="mx-2"><a href="login.php" class="text-white">เข้าสู่ระบบ</a></li>
                        <li class="mx-2"><a href="register.php" class="text-white">สมัครสมาชิก</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Product Detail Section -->
    <section class="product-detail-section">
        <div class="container">
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                </div>
                
                <!-- Product Info -->
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
                    <h3 class="text-danger">฿<?php echo number_format($product['price'], 2); ?></h3>

                    <!-- Product Order Form -->
                    <form action="order.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="quantity">จำนวน:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" required class="form-control mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">สั่งซื้อ</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
        </div>
    </footer>

    <!-- เพิ่ม Bootstrap JS และ Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybF6kA3B2B57lwnjzU5p8bTtr+YX2eT2Ev12EzO+Nbk71k6g1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0gFnF3sT0Z6nv0A1z9Pp63PfzzWa/N2ZsCdrCB6c8A59LPlD" crossorigin="anonymous"></script>
</body>
</html>
