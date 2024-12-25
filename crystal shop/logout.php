
<?php
session_start();
session_unset();  // ลบข้อมูล session
session_destroy();  // ทำลาย session
header('Location: login.php');  // หลังจากออกจากระบบแล้วจะไปที่หน้าเข้าสู่ระบบ
exit;
?>
