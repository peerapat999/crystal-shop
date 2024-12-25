<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php'); // ถ้าไม่ได้เข้าสู่ระบบให้ไปที่หน้าล็อกอิน
    exit;
}

include('db.php');

// ตรวจสอบการส่งฟอร์มเพื่อเพิ่มสินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // ตรวจสอบการอัปโหลดไฟล์
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // ตั้งชื่อไฟล์ใหม่เพื่อหลีกเลี่ยงการชนกันของชื่อไฟล์
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $image_path = 'uploads/' . $image_name;

        // ตรวจสอบประเภทไฟล์ (ตัวอย่างนี้รองรับแค่ JPG, PNG, GIF)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            // อัปโหลดไฟล์
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $image = $image_path; // บันทึกลิงก์ของไฟล์
            } else {
                $error_message = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์.";
            }
        } else {
            $error_message = "โปรดเลือกไฟล์ภาพ JPG, PNG, หรือ GIF.";
        }
    }

    // SQL สำหรับการเพิ่มสินค้าใหม่
    $sql_insert = "INSERT INTO products (name, price, quantity, description, image) 
                   VALUES ('$name', '$price', '$quantity', '$description', '$image')";

    // ตรวจสอบการเพิ่มข้อมูล
    if (mysqli_query($conn, $sql_insert)) {
        header('Location: admin_dashboard.php'); // กลับไปที่แดชบอร์ดหลังจากเพิ่มสินค้าเสร็จ
        exit;
    } else {
        $error_message = "เกิดข้อผิดพลาดในการเพิ่มสินค้า: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสินค้า</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 50px;
        }
        .container {
            margin-top: 20px;
        }
        footer {
            padding: 10px 0;
            background-color: #f8f9fa;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">แอดมิน - จัดการระบบ</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">แดชบอร์ด</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_product.php">เพิ่มสินค้า</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>เพิ่มสินค้าใหม่</h3>
            </div>
            <div class="card-body">
                <!-- ฟอร์มเพิ่มสินค้า -->
                <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อสินค้า</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">ราคา</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">จำนวนสินค้า</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">คำอธิบาย</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">เลือกรูปภาพสินค้า</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> เพิ่มสินค้า</button>
                    <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> กลับ</a>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
