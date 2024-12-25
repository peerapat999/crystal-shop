<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php'); // ถ้าไม่ได้เข้าสู่ระบบให้ไปที่หน้าล็อกอิน
    exit;
}

include('db.php');

// ตรวจสอบว่ามีการส่ง id ของสินค้า
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // แปลง id ให้เป็นตัวเลข

    // ดึงข้อมูลสินค้าที่จะลบ (เพื่อเก็บชื่อไฟล์ภาพ)
    $sql_orders = "SELECT orders.id AS order_id, orders.user_id, orders.product_id, orders.quantity, orders.status, users.username 
               FROM orders 
               INNER JOIN users ON orders.user_id = users.id 
               INNER JOIN products ON orders.product_id = products.id";


    if (mysqli_num_rows($result_select) > 0) {
        // ดึงข้อมูลสินค้า
        $row = mysqli_fetch_assoc($result_select);
        $image_path = $row['image'];

        // ลบข้อมูลในตาราง orders ที่อ้างอิงถึงสินค้าก่อน
        $sql_delete_orders = "DELETE FROM orders WHERE product_id = $product_id";
        mysqli_query($conn, $sql_delete_orders);

        // ลบข้อมูลสินค้าออกจากฐานข้อมูล
        $sql_delete_product = "DELETE FROM products WHERE id = $product_id";
        if (mysqli_query($conn, $sql_delete_product)) {
            // ลบไฟล์ภาพที่อัปโหลดแล้ว (ถ้ามี)
            if ($image_path && file_exists($image_path)) {
                unlink($image_path); // ลบไฟล์ภาพ
            }

            // รีไดเร็กต์กลับไปที่หน้าแดชบอร์ด
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $error_message = "เกิดข้อผิดพลาดในการลบสินค้า: " . mysqli_error($conn);
        }
    } else {
        $error_message = "ไม่พบสินค้าที่ต้องการลบ";
    }
} else {
    $error_message = "ไม่พบ ID ของสินค้า";
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลบสินค้า</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <h3>ลบสินค้า</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php else: ?>
                    <div class="alert alert-success">สินค้าถูกลบเรียบร้อยแล้ว</div>
                <?php endif; ?>
                <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> กลับไปยังแดชบอร์ด</a>
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
