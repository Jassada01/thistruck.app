<?php
session_start();

//session_unset(); // ยกเลิก Session ทั้งหมด
//session_destroy(); // ลบ Session ทั้งหมด
if (!isset($_SESSION['expire_time']) || time() > $_SESSION['expire_time'] || !isset($_SESSION['MAIN_USER_DATA'])) {
    session_unset(); // ยกเลิก Session ทั้งหมด
    session_destroy(); // ลบ Session ทั้งหมด
    header("Location: login.php?redirect=" . $CURRENT_URL); // ไปยังหน้า Login
} else {
    // Load Data 
    $MAIN_USER_DATA = $_SESSION['MAIN_USER_DATA'];
   
}

?>