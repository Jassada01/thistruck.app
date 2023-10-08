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
function insertClientInfo()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "INSERT INTO client_info (ClientCode, ClientName, Branch, Address, BillingAddress, TaxID, ContactPerson, Phone, Email, Attr1)
	VALUES ('$ClientCode', '$ClientName', '$Branch', '$Address', '$BillingAddress', '$TaxID', '$ContactPerson', '$Phone', '$Email', '$Attr1')";

	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo $sql;
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

// F=2
function LoadClientInfobyID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select * From client_info where ClientID = '$ClientID'";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=3
function updateClientInfobyID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "UPDATE client_info SET 
            ClientCode = '$ClientCode',
            ClientName = '$ClientName',
            Branch = '$Branch',
            Address = '$Address',
            BillingAddress = '$BillingAddress',
            TaxID = '$TaxID',
            ContactPerson = '$ContactPerson',
            Phone = '$Phone',
            Email = '$Email',
            Remark = '$Remark',
            Line_token = '$Line_token',
			Attr1 = '$Attr1',
            Active = $Active
        WHERE ClientID = $ClientID";
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}

// F=4
function loadRelateCustomerbyClientID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT customers.*
	FROM customers
	JOIN customer_client_relation
	ON customers.customer_id = customer_client_relation.customer_id
	WHERE customer_client_relation.client_id = $ClientID
	Order by customers.customer_id;";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=5
function deleteRelation()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Delete From customer_client_relation where customer_id = $customer_id AND client_id = $client_id";
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Close connection
	mysqli_close($conn);
}

// F=6
function addRelation()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "INSERT INTO customer_client_relation (customer_id, client_id) VALUES($customer_id, $client_id)";
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
			insertClientInfo();
			break;
		}
	case 2: {
			LoadClientInfobyID();
			break;
		}
	case 3: {
			updateClientInfobyID();
			break;
		}
	case 4: {
			loadRelateCustomerbyClientID();
			break;
		}
	case 5: {
			deleteRelation();
			break;
		}
	case 6: {
			addRelation();
			break;
		}
}
