<?php
session_start();
include('db.php'); // เชื่อมต่อฐานข้อมูล
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crystal Shop - หน้าหลัก</title>
    <!-- เพิ่ม Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJHo3DPxYJScbY0X7+K5P+46d+F0f+1gfh2k3hfa+K0F3kC5IfLXgY2vqxF5" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .hero-section {
            background-image: url('images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .service-card {
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .feature-product img {
            max-height: 300px;
            object-fit: cover;
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

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1>ยินดีต้อนรับสู่ Crystal Shop</h1>
            <p>เลือกสินค้าคริสตัลคุณภาพสูงจากเรา</p>
            <a href="products.php" class="btn btn-light btn-lg">ดูสินค้า</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-5">บริการของเรา</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card service-card shadow-sm border-0">
                        <img src="images/service1.jpg" class="card-img-top" alt="บริการ 1">
                        <div class="card-body">
                            <h5 class="card-title">สินค้าคุณภาพสูง</h5>
                            <p class="card-text">เราคัดสรรสินค้าคริสตัลคุณภาพสูงจากแหล่งที่เชื่อถือได้</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card shadow-sm border-0">
                        <img src="images/service2.jpg" class="card-img-top" alt="บริการ 2">
                        <div class="card-body">
                            <h5 class="card-title">จัดส่งรวดเร็ว</h5>
                            <p class="card-text">บริการจัดส่งที่รวดเร็วและปลอดภัยถึงมือลูกค้า</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card shadow-sm border-0">
                        <img src="images/service3.jpg" class="card-img-top" alt="บริการ 3">
                        <div class="card-body">
                            <h5 class="card-title">บริการหลังการขาย</h5>
                            <p class="card-text">เราให้บริการลูกค้าด้วยความเอาใจใส่ และพร้อมช่วยเหลือเสมอ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="feature-product py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-5">สินค้าพิเศษ</h2>
            <div class="row">
                <!-- คุณสามารถดึงข้อมูลสินค้าได้จากฐานข้อมูลที่เชื่อมต่อ -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <img src="uploads/product1.jpg" class="card-img-top" alt="สินค้า 1">
                        <div class="card-body">
                            <h5 class="card-title">คริสตัล A</h5>
                            <p class="card-text">สินค้าคริสตัลคุณภาพดี เหมาะสำหรับทุกโอกาส</p>
                            <p class="card-text text-danger">฿1,200</p>
                            <a href="product_detail.php?id=1" class="btn btn-primary">ดูรายละเอียด</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <img src="uploads/product2.jpg" class="card-img-top" alt="สินค้า 2">
                        <div class="card-body">
                            <h5 class="card-title">คริสตัล B</h5>
                            <p class="card-text">เลือกสินค้าคริสตัลจากคอลเล็กชันสุดพิเศษ</p>
                            <p class="card-text text-danger">฿1,500</p>
                            <a href="product_detail.php?id=2" class="btn btn-primary">ดูรายละเอียด</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <img src="uploads/product3.jpg" class="card-img-top" alt="สินค้า 3">
                        <div class="card-body">
                            <h5 class="card-title">คริสตัล C</h5>
                            <p class="card-text">คริสตัลที่เหมาะสำหรับการตกแต่งบ้านหรือเป็นของขวัญ</p>
                            <p class="card-text text-danger">฿1,800</p>
                            <a href="product_detail.php?id=3" class="btn btn-primary">ดูรายละเอียด</a>
                        </div>
                    </div>
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
