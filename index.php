<?php
session_start();
include('db.php');
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crystal Shop - หน้าหลัก</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="bg-blue-600 shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-5 flex justify-between items-center">
            <div class="text-2xl text-white font-semibold">
                <a href="index.php">Crystal Shop</a>
            </div>
            <nav>
                <ul class="flex space-x-6 text-lg">
                    <li><a href="index.php" class="text-white hover:text-yellow-400">หน้าหลัก</a></li>
                    <li><a href="products.php" class="text-white hover:text-yellow-400">สินค้า</a></li>
                    <li><a href="about.php" class="text-white hover:text-yellow-400">เกี่ยวกับเรา</a></li>
                    <li><a href="contact.php" class="text-white hover:text-yellow-400">ติดต่อเรา</a></li>
                    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                        <li><a href="profile.php" class="text-white hover:text-yellow-400">โปรไฟล์</a></li>
                        <li><a href="logout.php" class="text-white hover:text-yellow-400">ออกจากระบบ</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="text-white hover:text-yellow-400">เข้าสู่ระบบ</a></li>
                        <li><a href="register.php" class="text-white hover:text-yellow-400">สมัครสมาชิก</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-96" style="background-image: url('images/hero-bg.jpg');">
        <div class="h-full flex justify-center items-center bg-black bg-opacity-50">
            <div class="text-center text-white px-6 md:px-12">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">ยินดีต้อนรับสู่ Crystal Shop</h1>
                <p class="text-xl mb-8">พบกับสินค้าคุณภาพมากมายที่คุณไม่ควรพลาด</p>
                <a href="products.php" class="bg-yellow-500 text-black py-2 px-6 rounded-full text-lg hover:bg-yellow-600">ดูสินค้าทั้งหมด</a>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-semibold mb-8">สินค้าของเรา</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php
                // ดึงข้อมูลสินค้า 3 รายการจากฐานข้อมูล
                $sql = "SELECT * FROM products LIMIT 3";
                $result = mysqli_query($conn, $sql);
                while ($product = mysqli_fetch_assoc($result)):
                ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105">
                        <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h5 class="text-xl font-semibold mb-4"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="text-gray-600 mb-4"><?php echo mb_strimwidth($product['description'], 0, 100, '...'); ?></p>
                            <p class="text-lg text-red-500 mb-4">฿<?php echo number_format($product['price'], 2); ?></p>
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg">ดูรายละเอียด</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p>&copy; 2024 Crystal Shop. All rights reserved.</p>
            <div class="mt-4">
                <a href="#" class="text-gray-300 hover:text-white mx-3">Facebook</a>
                <a href="#" class="text-gray-300 hover:text-white mx-3">Instagram</a>
                <a href="#" class="text-gray-300 hover:text-white mx-3">Twitter</a>
            </div>
        </div>
    </footer>

</body>
</html>
