<?php
// รับค่า Customer ID ที่ต้องการค้นหาจาก URL
$customer_id = $_GET['id'];

// เชื่อมต่อฐานข้อมูล MySQL
include "../connectionDb.php";


// สร้างคำสั่ง SQL สำหรับค้นหาข้อมูลลูกค้า
$sql = "SELECT * FROM customers WHERE customer_id = '$customer_id'";

// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = $conn->query($sql);

// ตรวจสอบว่าพบข้อมูลหรือไม่
if ($result->num_rows > 0) {
  // ดึงข้อมูลลูกค้าเป็น array
  $customer = $result->fetch_assoc();
} else {
  // หากไม่พบข้อมูล สร้าง array เปล่า ๆ
  $customer = array();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// ส่งข้อมูลลูกค้ากลับเป็น JSON
header('Content-Type: application/json');
echo json_encode($customer);
?>
