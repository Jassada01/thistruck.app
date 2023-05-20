<?php
// รับข้อมูลจาก Form
$customerName = $_POST['customer_name'];
$customer_code = $_POST['customer_code'];
$address = $_POST['address'];
$branch = $_POST['branch'];
$taxId = $_POST['tax_id'];
$contact1 = $_POST['contact_1'];
$phone1 = $_POST['phone_1'];
$contact2 = $_POST['contact_2'];
$phone2 = $_POST['phone_2'];
$email = $_POST['email'];

// เชื่อมต่อฐานข้อมูล MySQL
include "../connectionDb.php";


// สร้างคำสั่ง SQL สำหรับบันทึกข้อมูลลูกค้า
$sql = "INSERT INTO customers (customer_name, customer_code, address, branch, tax_id, contact_1, phone_1, contact_2, phone_2, email) VALUES ('$customerName', '$customer_code' , '$address', '$branch', '$taxId', '$contact1', '$phone1', '$contact2', '$phone2', '$email')";

// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
if (mysqli_query($conn, $sql)) {
  // รับ ClientID ที่ถูกสร้างขึ้นล่าสุด
  $last_inserted_id = mysqli_insert_id($conn);

  // Return ClientID ออกมา
  echo $last_inserted_id;
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



// ปิดการเชื่อมต่อฐานข้อมูล MySQL
mysqli_close($conn);
