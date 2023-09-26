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
function insertDriverInfo()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "INSERT INTO truck_driver_info (driver_name, driver_license_number, driver_license_expiry_date, contact_number, line_id, image_path, note, type, payto) VALUES ('$driver_name', '$driver_license_number', '$driver_license_expiry_date', '$contact_number', '$line_id', '$image_path', '$note', '$type', '$payto')";

	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}

// F=2
function loadDriverInfoByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT * From truck_driver_info where driver_id = '$driver_id'";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=3
function updateDriverInfoByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "UPDATE truck_driver_info
	SET driver_name = '$driver_name',
		driver_license_number = '$driver_license_number',
		driver_license_expiry_date = '$driver_license_expiry_date',
		contact_number = '$contact_number',
		image_path = '$image_path',
		line_id = '$line_id',
		type = '$type',
		note = '$note',
		payto = '$payto',
		NameVisable = $NameVisable,
		active = $active
	WHERE driver_id = $driver_id;";

	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}

// F=4
function insertNewTruckInfo()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	$next_maintenance_distance = empty($next_maintenance_distance) ? "NULL" : $next_maintenance_distance;
	$capacity = empty($capacity) ? "NULL" : $capacity;
	$year = empty($year) ? "NULL" : $year;
	$last_maintenance_date = empty($last_maintenance_date) ? "NULL" : $last_maintenance_date;
	$next_maintenance_distance = empty($next_maintenance_distance) ? "NULL" : $next_maintenance_distance;
	$insurance_expiry_date = empty($insurance_expiry_date) ? "NULL" : $insurance_expiry_date;

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "INSERT INTO truck_info (truck_number, province, manufacturer, model, year, capacity, fuel_type, insurance_company, insurance_expiry_date, insurance_policy_number, last_maintenance_date, next_maintenance_date, next_maintenance_distance, note, main_driver_id, truck_type)
	VALUES ('$truck_number', '$province', '$manufacturer', '$model', $year, $capacity, '$fuel_type', '$insurance_company', '$insurance_expiry_date', '$insurance_policy_number', '$last_maintenance_date', '$next_maintenance_date', $next_maintenance_distance, '$note', $main_driver_id, '$truck_type')";
	//echo $sql;
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// รับ ClientID ที่ถูกสร้างขึ้นล่าสุด
	$last_inserted_id = mysqli_insert_id($conn);

	// Return ClientID ออกมา
	echo $last_inserted_id;


	// Close connection
	mysqli_close($conn);
}

// F=5
function loadProvinceData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select a.id, a.name_in_thai From provinces a Order By a.run_order";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=6
function loadDriverforSelect()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT driver_id, image_path, driver_name FROM truck_driver_info Where active = 1";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}


// F=7
function loadMasterforSelect()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT * From master_data Where type = '$MasterType'";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=8
function loadTruckDatabyID()
{
	//sleep(2);
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT * FROM truck_info Where truck_id = $truck_id";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=9
function updateTruckDatabyID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	$next_maintenance_distance = empty($next_maintenance_distance) ? "NULL" : $next_maintenance_distance;
	$capacity = empty($capacity) ? "NULL" : $capacity;
	$year = empty($year) ? "NULL" : $year;
	$last_maintenance_date = empty($last_maintenance_date) ? "NULL" : $last_maintenance_date;
	$next_maintenance_distance = empty($next_maintenance_distance) ? "NULL" : $next_maintenance_distance;
	$insurance_expiry_date = empty($insurance_expiry_date) ? "NULL" : $insurance_expiry_date;

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "UPDATE truck_info
		SET truck_number = '$truck_number',
		   province = '$province',
		   manufacturer = '$manufacturer',
		   model = '$model',
		   year = $year,
		   capacity = $capacity,
		   truck_type = '$truck_type',
		   fuel_type = '$fuel_type',
		   insurance_expiry_date = '$insurance_expiry_date',
		   insurance_policy_number = '$insurance_policy_number',
		   insurance_company = '$insurance_company',
		   last_maintenance_date = '$last_maintenance_date',
		   next_maintenance_distance = $next_maintenance_distance,
		   next_maintenance_date = '$next_maintenance_date',
		   note = '$note',
		   main_driver_id = $main_driver_id,
		   active = $active
	WHERE  truck_id = $truck_id  ";
	//echo $sql;
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
			insertDriverInfo();
			break;
		}
	case 2: {
			loadDriverInfoByID();
			break;
		}
	case 3: {
			updateDriverInfoByID();
			break;
		}
	case 4: {
			insertNewTruckInfo();
			break;
		}
	case 5: {
			loadProvinceData();
			break;
		}
	case 6: {
			loadDriverforSelect();
			break;
		}
	case 7: {
			loadMasterforSelect();
			break;
		}
	case 8: {
			loadTruckDatabyID();
			break;
		}
	case 9: {
			updateTruckDatabyID();
			break;
		}
}


