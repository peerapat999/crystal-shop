<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบของแอดมิน
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php'); // ถ้าไม่ได้เข้าสู่ระบบให้ไปที่หน้าล็อกอิน
    exit;
}

include('db.php');

// ดึงข้อมูลสินค้าทั้งหมด
$sql_products = "SELECT * FROM products";
$result_products = mysqli_query($conn, $sql_products);

// ดึงข้อมูลคำสั่งซื้อทั้งหมด
$sql_orders = "SELECT orders.id AS order_id, orders.user_id, orders.product_id, orders.quantity, orders.status, users.username 
               FROM orders 
               INNER JOIN users ON orders.user_id = users.id";
$result_orders = mysqli_query($conn, $sql_orders);

// ดึงข้อมูลสมาชิกทั้งหมด
$sql_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $sql_users);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แอดมิน - จัดการระบบ</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 50px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
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
        <!-- ส่วนจัดการสินค้า -->
        <section class="product-list">
            <div class="card">
                <div class="card-header">
                    <h3>รายการสินค้าทั้งหมด</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ชื่อสินค้า</th>
                                <th>ราคา</th>
                                <th>คำอธิบาย</th>
                                <th>การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_products)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo number_format($row['price'], 2); ?> บาท</td>
                                <td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> แก้ไข</a>
                                    <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> ลบ</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ส่วนจัดการคำสั่งซื้อ -->
        <section class="order-list mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>รายการคำสั่งซื้อ</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ชื่อผู้สั่งซื้อ</th>
                                <th>ชื่อสินค้า</th>
                                <th>จำนวน</th>
                                <th>สถานะ</th>
                                <th>การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = mysqli_fetch_assoc($result_orders)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['username']); ?></td>
                                <td><?php 
                                    // ดึงชื่อสินค้าจาก product_id
                                    $sql_product_name = "SELECT name FROM products WHERE id = " . $order['product_id'];
                                    $result_product_name = mysqli_query($conn, $sql_product_name);
                                    $product = mysqli_fetch_assoc($result_product_name);
                                    echo htmlspecialchars($product['name']); 
                                ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                                <td>
                                    <?php if ($order['status'] == 'รอดำเนินการ'): ?>
                                        <a href="approve_order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i> อนุมัติ</a>
                                    <?php endif; ?>
                                    <a href="view_order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> ดูรายละเอียด</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ส่วนจัดการสมาชิก -->
        <section class="user-list mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>สมาชิกทั้งหมด</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ชื่อผู้ใช้</th>
                                <th>อีเมล</th>
                                <th>วันที่สมัคร</th>
                                <th>การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = mysqli_fetch_assoc($result_users)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo $user['created_at']; ?></td>
                                <td>
                                    <a href="view_user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> ดูรายละเอียด</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
