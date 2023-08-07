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
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}



// ======== Function ========
// F=1
function MonthlyReportDetail()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT 
		b.job_id,
		b.job_no,
		a.job_name,
		a.job_date,
		b.id AS trip_id,
		b.tripNo,
		b.tripSeq,
		b.truck_licenseNo,
		b.driver_name,
		c.hire_price,
		c.overtime_fee,
		c.port_charge,
		c.yard_charge,
		c.container_return,
		c.container_cleaning_repair,
		c.container_drop_lift,
		c.other_charge,
		c.deduction_note,
		c.expenses_1,
		c.remark,
		c.total_expenses,
		c.wage_travel_cost,
		c.vehicle_expenses
	FROM
		job_order_header a
		INNER JOIN job_order_detail_trip_info b ON a.id = b.job_id
		INNER JOIN job_order_detail_trip_cost c ON a.id = c.job_id AND b.id = c.trip_id
	WHERE
	a.id in (SELECT za.job_id FROM job_order_detail_trip_info za
                                                        WHERE DATE_FORMAT(za.jobStartDateTime, '%m%Y') = '$selectMonth'
                                                        AND za.status <> 'ยกเลิก'
                                                        GROUP BY za.job_id)";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}

// F=2
function updateCostfromTable()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}




	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL UPDATE
	$sql = "UPDATE job_order_detail_trip_cost SET $columnTitle = '$newContent'
	Where job_id = $jobID AND trip_id = $trip_id";


	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	$sql = "UPDATE job_order_detail_trip_cost
	SET total_expenses = IFNULL(hire_price, 0) + IFNULL(overtime_fee, 0) + IFNULL(port_charge, 0) + IFNULL(yard_charge, 0) + IFNULL(container_return, 0) + IFNULL(container_cleaning_repair, 0) + IFNULL(container_drop_lift, 0) + IFNULL(other_charge, 0) + IFNULL(deduction_note, 0) + IFNULL(expenses_1, 0)
	WHERE trip_id = $trip_id
	";


	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	$sql = "Select total_expenses From job_order_detail_trip_cost Where job_id = $jobID AND trip_id = $trip_id";


	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}
//============================ MAIN =========================================================
switch ($f) {
	case 1: {
			MonthlyReportDetail();
			break;
		}
	case 2: {
			updateCostfromTable();
			break;
		}
}
