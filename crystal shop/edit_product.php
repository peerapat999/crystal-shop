<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php'); // ถ้าไม่ได้เข้าสู่ระบบให้ไปที่หน้าล็อกอิน
    exit;
}

include('db.php');

// ตรวจสอบว่าได้รับการส่ง ID ของสินค้ามาหรือไม่
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql_product = "SELECT * FROM products WHERE id = $product_id";
    $result_product = mysqli_query($conn, $sql_product);

    if (mysqli_num_rows($result_product) > 0) {
        $product = mysqli_fetch_assoc($result_product);
    } else {
        echo "ไม่พบข้อมูลสินค้า";
        exit;
    }
} else {
    echo "ไม่พบข้อมูลสินค้าที่ต้องการแก้ไข";
    exit;
}

// ตรวจสอบการส่งฟอร์มเพื่ออัปเดตข้อมูล
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql_update = "UPDATE products SET name = '$name', price = '$price', description = '$description', quantity = '$quantity' WHERE id = $product_id";

    if (mysqli_query($conn, $sql_update)) {
        header('Location: admin_dashboard.php'); // กลับไปที่หน้าแดชบอร์ดหลังจากอัปเดตเสร็จ
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขสินค้า</title>
    
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
                <h3>แก้ไขสินค้า</h3>
            </div>
            <div class="card-body">
                <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อสินค้า</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">ราคา</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">จำนวนสินค้า</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">คำอธิบาย</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลง</button>
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
