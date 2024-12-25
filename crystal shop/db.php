<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";  // ชื่อเซิร์ฟเวอร์
$username = "root";         // ชื่อผู้ใช้ฐานข้อมูล
$password = "";             // รหัสผ่านฐานข้อมูล (หากมี)
$dbname = "online_store";  // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
