<?php



// ======== Get Var ========
if (isset($_GET['f'])) {
	$f = $_GET['f'];
}
if (isset($_POST['f'])) {
	$f = $_POST['f'];
}
if (isset($_GET['p1'])) {
	$p1 = $_GET['p1'];
}
if (isset($_GET['p2'])) {
	$p2 = $_GET['p2'];
}
if (isset($_GET['p3'])) {
	$p3 = $_GET['p3'];
}
// ================ Global Function =============================
$thai_day_arr = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์");
$thai_month_arr = array(
	"0" => "",
	"1" => "มกราคม",
	"2" => "กุมภาพันธ์",
	"3" => "มีนาคม",
	"4" => "เมษายน",
	"5" => "พฤษภาคม",
	"6" => "มิถุนายน",
	"7" => "กรกฎาคม",
	"8" => "สิงหาคม",
	"9" => "กันยายน",
	"10" => "ตุลาคม",
	"11" => "พฤศจิกายน",
	"12" => "ธันวาคม"
);

$thai_month_arr_shot = array(
	"0" => "",
	"1" => "ม.ค.",
	"2" => "ก.พ.",
	"3" => "มี.ค.",
	"4" => "ม.ย.",
	"5" => "พ.ค.",
	"6" => "มิ.ย.",
	"7" => "ก.ค.",
	"8" => "ส.ค.",
	"9" => "ก.ย.",
	"10" => "ต.ค.",
	"11" => "พ.ย.",
	"12" => "ธ.ค."
);
function thai_date($time)
{
	global $thai_day_arr, $thai_month_arr;
	$thai_date_return = "วัน" . $thai_day_arr[date("w", $time)];
	$thai_date_return .= "ที่ " . date("j", $time);
	$thai_date_return .= " " . $thai_month_arr[date("n", $time)];
	$thai_date_return .= " " . (date("Y", $time) + 543);
	return $thai_date_return;
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

function gen_rnd_str($length = 10)
{
	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


// F=1
function getJobProgress()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	//$sql = "SELECT *  FROM job_order_detail_trip_action_log WHERE trip_id = $MAIN_trip_id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1;";
	$sql = "SELECT 
				a.job_no, 
				a.tripNo, 
				a.id AS trip_ID, 
				a.job_id, 
				c.job_name, 
				c.customer_name, 
				a.truck_licenseNo, 
				a.driver_name, 
				b.image_path, 
				TOTAL.CNT_TOTAL, 
				IFNULL(COMP.CNT_COMPLETE, 0) AS CNT_COMPLETE, 
				ROUND(
				IFNULL(COMP.CNT_COMPLETE, 0) / TOTAL.CNT_TOTAL, 
				2
				) AS PCT 
			FROM 
				job_order_detail_trip_info a 
				Inner Join (
				SELECT 
					a.trip_id, 
					COUNT(*) AS CNT_TOTAL 
				FROM 
					job_order_detail_trip_action_log a 
				Group By 
					a.trip_id
				) TOTAL ON a.id = TOTAL.trip_id 
				LEFT Join (
				SELECT 
					a.trip_id, 
					COUNT(*) AS CNT_COMPLETE 
				FROM 
					job_order_detail_trip_action_log a 
				Where 
					a.complete_flag IS NOT NULL 
				Group By 
					a.trip_id
				) COMP ON a.id = COMP.trip_id 
				Inner Join truck_driver_info b ON a.driver_id = b.driver_id 
				Inner Join job_order_header c ON a.job_id = c.id 
			WHERE 
				a.complete_flag IS NULL 
			Order BY 
				a.id 
			LIMIT 
				5";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$row['image_path'] = "assets/media/uploadfile/" . $row['image_path'];
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}


// F=2
function getCalendarData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	//$sql = "SELECT *  FROM job_order_detail_trip_action_log WHERE trip_id = $MAIN_trip_id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1;";
	$sql = "SELECT 
		a.id AS trip_id, 
		a.job_id, 
		a.driver_name as title, 
		a.complete_flag, 
		a.jobStartDateTime AS start, 
		b.timestamp AS end 
	FROM 
		job_order_detail_trip_info a 
		LEFT JOIN job_order_detail_trip_action_log b ON a.id = b.trip_id 
		AND a.job_id = b.job_id 
		AND b.main_order = 7 
		AND b.minor_order = 1
	WHERE 
		a.jobStartDateTime >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
		AND a.jobStartDateTime <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND (a.complete_flag IS NULL OR a.complete_flag > 0) ";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$row['url'] = "103_tripDetail.php?job_id=".$row['job_id']."&trip_id=".$row['trip_id'];
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}



//============================ MAIN =========================================================
switch ($f) {
	case 1: {
			getJobProgress();
			break;
		}
	case 2: {
			getCalendarData();
			break;
		}
}
