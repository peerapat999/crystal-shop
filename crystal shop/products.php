<?php
session_start();
include('db.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header('Location: login.php'); // ถ้าผู้ใช้ยังไม่ได้เข้าสู่ระบบ, ให้ไปที่หน้าล็อกอิน
    exit;
}

// ดึงข้อมูลสินค้า
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สินค้า</title>
    <!-- เพิ่ม Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJHo3DPxYJScbY0X7+K5P+46d+F0f+1gfh2k3hfa+K0F3kC5IfLXgY2vqxF5" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header class="bg-primary text-white">
        <div class="container py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.php" class="text-white h2">Crystal Shop</a>
                </div>
                <nav>
                    <ul class="list-unstyled d-flex mb-0">
                        <li class="mx-2"><a href="index.php" class="text-white">หน้าหลัก</a></li>
                        <li class="mx-2"><a href="products.php" class="text-white">สินค้า</a></li>
                        <li class="mx-2"><a href="about.php" class="text-white">เกี่ยวกับเรา</a></li>
                        <li class="mx-2"><a href="contact.php" class="text-white">ติดต่อเรา</a></li>
                        <li class="mx-2"><a href="profile.php" class="text-white">โปรไฟล์</a></li>
                        <li class="mx-2"><a href="order_history.php" class="text-white">ประวัติการสั่งซื้อ</a></li>
                        <li class="mx-2"><a href="logout.php" class="text-white">ออกจากระบบ</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Product Section -->
    <section class="product-section py-5">
        <div class="container">
            <h1 class="text-center mb-4">สินค้าทั้งหมด</h1>
            <div class="row">
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="uploads/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text text-danger"><?php echo number_format($product['price'], 2); ?> บาท</p>
                                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">ดูรายละเอียด</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
        </div>
    </footer>

    <!-- เพิ่ม Bootstrap JS และ Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybF6kA3B2B57lwnjzU5p8bTtr+YX2eT2Ev12EzO+Nbk71k6g1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0gFnF3sT0Z6nv0A1z9Pp63PfzzWa/N2ZsCdrCB6c8A59LPlD" crossorigin="anonymous"></script>
</body>
</html>
