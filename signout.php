<?php
session_start();

session_unset(); // ยกเลิก Session ทั้งหมด
session_destroy(); // ลบ Session ทั้งหมด
header("Location: login.php"); // ไปยังหน้า Login

?>
