<?php
// ตรวจสอบว่ามีค่า r ใน URL หรือไม่
if(isset($_GET['r'])) {
    $r = $_GET['r'];
    
    // เชื่อมต่อฐานข้อมูล MySQL
	include "function/connectionDb.php";

    // สร้างคำสั่ง SQL สำหรับการค้นหา URL จากค่า rnd
    $sql = "SELECT url FROM shot_url WHERE rnd = '$r'";
    $result = $conn->query($sql);

    // ตรวจสอบว่าพบ URL หรือไม่
    if ($result->num_rows > 0) {
        // พบ URL ในฐานข้อมูล
        $row = $result->fetch_assoc();
        $url = $row["url"];

        // Redirect ไปยัง URL
        header("Location: $url");
        exit();
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}

// ถ้าไม่พบค่า r หรือไม่พบ URL ในฐานข้อมูล จะทำการแสดงข้อความผิดพลาดหรือกระทำอื่นตามต้องการ
echo "ไม่พบ URL";
?>
