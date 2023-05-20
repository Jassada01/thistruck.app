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
function updateCustomerData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "UPDATE customers SET customer_code='$customer_code', customer_name='$customer_name', address='$address', branch='$branch', tax_id='$tax_id', contact_1='$contact_1', phone_1='$phone_1', contact_2='$contact_2', phone_2='$phone_2', email='$email' , line_token='$line_token', remark='$remark', active=$active WHERE customer_id='$customer_id'";
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}

// F=2
function loadCustomerData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT customer_id, CONCAT(customer_name, ' (', branch, ')') as text FROM customers";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=3
function InsertNewLocation()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	if (isset($short_haul_fee)) {
		$sql = "INSERT INTO locations (location_code, location_name, customer_id, address, map_url, latitude, longitude, location_type, note, short_haul_fee, long_haul_fee, short_haul_return_fee, long_haul_return_fee, yard_fee, opening_hours, contact_number)  
        VALUES ('$location_code', '$location_name', '$customer_id', '$address', '$map_url', $latitude, $longitude, '$location_type', '$note', $short_haul_fee, $long_haul_fee, $short_haul_return_fee, $long_haul_return_fee, $yard_fee, '$opening_hours', '$contact_number')";
	} else {
		$sql = "INSERT INTO locations (location_code, location_name, customer_id, address, map_url, latitude, longitude, location_type, note)  VALUES ('$location_code', '$location_name', '$customer_id', '$address', '$map_url', $latitude, $longitude, '$location_type', '$note')";
	}

	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}

// F=4
function loadCustomerLocation()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select * From locations where customer_id = '$customer_id' AND  active = 1 ";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}

// F=5
function loadCustomerLocationByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select * From locations where location_id = '$location_id'";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=6
function updateCustomerLocationByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	if (isset($short_haul_fee)) {
		$sql = "UPDATE locations SET
	location_code = '$location_code',
	location_name = '$location_name',
	customer_id = '$customer_id',
	address = '$address',
	map_url = '$map_url',
	latitude = $latitude,
	longitude = $longitude,
	note = '$note',
	location_type = '$location_type',
	active = $active,
	short_haul_fee = $short_haul_fee,
	long_haul_fee = $long_haul_fee,
	short_haul_return_fee = $short_haul_return_fee,
	long_haul_return_fee = $long_haul_return_fee,
	yard_fee = $yard_fee,
	opening_hours = '$opening_hours',
	contact_number = '$contact_number'
	WHERE location_id = $location_id";
	} else {
		$sql = "UPDATE locations SET location_code = '$location_code', location_name = '$location_name', customer_id = '$customer_id', address = '$address', map_url = '$map_url', latitude = $latitude, longitude = $longitude, note = '$note', location_type = '$location_type', active = $active WHERE location_id = $location_id";
	}


	//echo $sql;
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}

// F=7
function deleteCustomerLocationByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	//$sql = "Delete from locations where location_id = $location_id";
	$sql = "Update locations set active = 0 where location_id = $location_id";
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}




//============================ MAIN =========================================================
switch ($f) {
	case 1: {
			updateCustomerData();
			break;
		}
	case 2: {
			loadCustomerData();
			break;
		}
	case 3: {
			InsertNewLocation();
			break;
		}
	case 4: {
			loadCustomerLocation();
			break;
		}
	case 5: {
			loadCustomerLocationByID();
			break;
		}
	case 6: {
			updateCustomerLocationByID();
			break;
		}
	case 7: {
			deleteCustomerLocationByID();
			break;
		}
}
