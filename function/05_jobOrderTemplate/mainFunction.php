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
function loadLocationForSelect()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT a.*, b.customer_name, b.branch, b.customer_id from locations a 
	Left Join customers b ON a.customer_id = b.customer_id
	Where a.active = 1
    Order By  b.customer_id";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=2
function loadLocationByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT a.*, b.customer_name, b.branch, b.customer_id from locations a 
	Left Join customers b ON a.customer_id = b.customer_id
	Where a.location_id = $location_id
    Order By  b.customer_id;";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=3
function insertNewJobTemplate()
{

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";



	//## Step 1 Create Query เพื่อ Insert job_order_template_header
	// Load All Data from Paramitor
	// เตรียมข้อมูลที่จะเพิ่มลงในตาราง job_order_template_header
	$jobHeaderForm = $_POST['jobHeaderForm'];
	$clientID = $jobHeaderForm['ClientID'];
	$jobName = $jobHeaderForm['job_name'];
	$jobType = $jobHeaderForm['job_type'];
	$remark = $jobHeaderForm['remark'];
	$customer_id = $jobHeaderForm['customerID'];
	// สร้าง SQL query
	$sql = "INSERT INTO job_order_template_header (ClientID, customer_id, job_name, job_type, remark) 
        VALUES ('$clientID', '$customer_id', '$jobName', '$jobType', '$remark')";

	// ทำการ Insert ข้อมูล 
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// รับ job_order_template_header_id ที่ถูกสร้างขึ้นล่าสุด
	$job_order_template_header_id  = mysqli_insert_id($conn);

	// # Step1 Finished 


	//## Step 2 Create Query เพื่อ Insert job_order_template_detail_cost
	// ดึงข้อมูลจาก jobDetailCostForm
	$hire_price = $_POST['jobDetailCostForm']['hire_price'];
	$overtime_fee = $_POST['jobDetailCostForm']['overtime_fee'];
	$port_charge = $_POST['jobDetailCostForm']['port_charge'];
	$yard_charge = $_POST['jobDetailCostForm']['yard_charge'];
	$container_return = $_POST['jobDetailCostForm']['container_return'];
	$container_cleaning_repair = $_POST['jobDetailCostForm']['container_cleaning_repair'];
	$container_drop_lift = $_POST['jobDetailCostForm']['container_drop_lift'];
	$other_charge = $_POST['jobDetailCostForm']['other_charge'];
	$deduction_note = $_POST['jobDetailCostForm']['deduction_note'];
	$total_expenses = $_POST['jobDetailCostForm']['total_expenses'];
	$wage_travel_cost = $_POST['jobDetailCostForm']['wage_travel_cost'];
	$vehicle_expenses = $_POST['jobDetailCostForm']['vehicle_expenses'];
	$Costremark = $_POST['jobDetailCostForm']['remark'];
	$expenses_1 = $_POST['jobDetailCostForm']['expenses_1'];
	$insInvAdd1 = $_POST['jobDetailCostForm']['insInvAdd1'];
	$insInvAdd2 = $_POST['jobDetailCostForm']['insInvAdd2'];
	$insInvAdd3 = $_POST['jobDetailCostForm']['insInvAdd3'];

	// เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
	$sql = "INSERT INTO job_order_template_detail_cost (job_order_template_header_id, hire_price, overtime_fee, port_charge, yard_charge, container_return, container_cleaning_repair, container_drop_lift, other_charge, deduction_note, total_expenses, wage_travel_cost, vehicle_expenses, insInvAdd1, insInvAdd2, insInvAdd3, expenses_1, remark) 
        VALUES ('$job_order_template_header_id', '$hire_price', '$overtime_fee', '$port_charge', '$yard_charge', '$container_return', '$container_cleaning_repair', '$container_drop_lift', '$other_charge', '$deduction_note', '$total_expenses', '$wage_travel_cost', '$vehicle_expenses', '$insInvAdd1', '$insInvAdd2', '$insInvAdd3', '$expenses_1', '$Costremark')";


	// ทำการ Insert ข้อมูล 
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// # Step 2 Finished 

	//## Step 3 Create Query เพื่อ Insert job_order_template_detail_plan 
	// อ่านค่า jobDetailPlan จาก Object ที่ส่งมาทาง Ajax
	$jobDetailPlan = $_POST['jobDetailPlan'];

	// นำข้อมูลจาก $jobDetailPlan มา loop แล้ว insert เข้าตาราง job_order_template_detail_plan
	foreach ($jobDetailPlan as $detailPlan) {
		$location_id = $detailPlan['location_id'];
		$job_order_template_header_id = $job_order_template_header_id; // ค่าที่เพิ่มเติมจากข้อที่ 2
		$plan_order = $detailPlan['plan_order'];
		$branch = $detailPlan['branch'];
		$showName = $detailPlan['showName'];
		$job_characteristic = $detailPlan['job_characteristic'];
		$job_characteristic_id = $detailPlan['job_characteristic_id'];
		$job_note = $detailPlan['job_note'];
		$unique_key = $detailPlan['unique_key'];
		$cardColor = $detailPlan['cardColor'];
		$job_characteristicShow = $detailPlan['job_characteristicShow'];

		// สร้าง SQL query สำหรับ insert ข้อมูลลงในตาราง job_order_template_detail_plan
		$sql = "INSERT INTO job_order_template_detail_plan (job_order_template_header_id, location_id, plan_order, branch, showName, job_characteristic, job_characteristic_id, job_note, unique_key, cardColor, job_characteristicShow) VALUES ('$job_order_template_header_id', '$location_id', '$plan_order', '$branch', '$showName', '$job_characteristic', $job_characteristic_id, '$job_note', '$unique_key', '$cardColor', '$job_characteristicShow')";

		// ทำการ execute SQL query ด้านบน
		// ทำการ Insert ข้อมูล 
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
	}

	// # Step 3 Finished 
	// Close Connect ===================
	mysqli_close($conn);

	echo $job_order_template_header_id;
}

// F=4
function loadJobTemplateDatafromJobTemplateID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}


	$data_Array = array();
	$data_Array['jobHeaderForm'] = array();
	$data_Array['jobDetailCostForm'] = array();
	$data_Array['jobDetailPlan'] = array();

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Step 1 Load data from job_order_template_header
	$sql = "Select * From job_order_template_header Where id = '$jobTemplateID'";
	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$data_Array['jobHeaderForm'][] = $row;
	}



	// Step 2 Load data from job_order_template_detail_cost
	$sql = "Select * From job_order_template_detail_cost Where job_order_template_header_id = '$jobTemplateID'";
	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$data_Array['jobDetailCostForm'][] = $row;
	}


	// Step 3 Load data from job_order_template_detail_cost
	$sql = "SELECT a.*,
			b.location_code,
			b.location_name,
			b.customer_id,
			b.address,
			b.map_url,
			b.latitude,
			b.longitude,
			b.location_type,
			b.active,
			c.customer_name
		FROM   job_order_template_detail_plan a
			INNER JOIN locations b
					ON a.location_id = b.location_id
			LEFT JOIN customers c
				ON b.customer_id = c.customer_id
		WHERE  a.job_order_template_header_id = '$jobTemplateID'
		ORDER  BY a.plan_order; ";

	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$data_Array['jobDetailPlan'][] = $row;
	}
	mysqli_close($conn);
	echo json_encode($data_Array, JSON_UNESCAPED_UNICODE);
}

// F=5
function updateJobTemplateByID()
{

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	$job_order_template_header_id = $_POST['jobTemplateID'];

	// Step 1: Create Query to Update job_order_template_header
	// Load All Data from Parameter
	// เตรียมข้อมูลที่จะอัพเดตลงในตาราง job_order_template_header
	$jobHeaderForm = $_POST['jobHeaderForm'];
	$clientID = $jobHeaderForm['ClientID'];
	$jobName = $jobHeaderForm['job_name'];
	$jobType = $jobHeaderForm['job_type'];
	$remark = $jobHeaderForm['remark'];
	$active = $jobHeaderForm['active'];
	$customer_id = $jobHeaderForm['customerID'];

	// สร้าง SQL query ในการอัพเดต
	$sql = "UPDATE job_order_template_header
	SET    clientid = '$clientID',
		   job_name = '$jobName',
		   job_type = '$jobType',
		   remark = '$remark',
		   active = '$active',
		   customer_id = '$customer_id'
	WHERE  id = $job_order_template_header_id ";
	//echo $sql;
	// ทำการ Update ข้อมูล
	echo $sql;
	if (!$conn->query($sql)) {
		echo $sql;
		echo $conn->errno;
		exit();
	}

	// รับ job_order_template_header_id ที่ถูกสร้างขึ้นล่าสุด


	// # Step1 Finished 


	//## Step 2 Create Query เพื่อ Update job_order_template_detail_cost
	// ดึงข้อมูลจาก jobDetailCostForm
	$hire_price = $_POST['jobDetailCostForm']['hire_price'];
	$overtime_fee = $_POST['jobDetailCostForm']['overtime_fee'];
	$port_charge = $_POST['jobDetailCostForm']['port_charge'];
	$yard_charge = $_POST['jobDetailCostForm']['yard_charge'];
	$container_return = $_POST['jobDetailCostForm']['container_return'];
	$container_cleaning_repair = $_POST['jobDetailCostForm']['container_cleaning_repair'];
	$container_drop_lift = $_POST['jobDetailCostForm']['container_drop_lift'];
	$other_charge = $_POST['jobDetailCostForm']['other_charge'];
	$deduction_note = $_POST['jobDetailCostForm']['deduction_note'];
	$total_expenses = $_POST['jobDetailCostForm']['total_expenses'];
	$wage_travel_cost = $_POST['jobDetailCostForm']['wage_travel_cost'];
	$vehicle_expenses = $_POST['jobDetailCostForm']['vehicle_expenses'];
	$Costremark = $_POST['jobDetailCostForm']['remark'];
	$expenses_1 = $_POST['jobDetailCostForm']['expenses_1'];
	$insInvAdd1 = $_POST['jobDetailCostForm']['insInvAdd1'];
	$insInvAdd2 = $_POST['jobDetailCostForm']['insInvAdd2'];
	$insInvAdd3 = $_POST['jobDetailCostForm']['insInvAdd3'];

	// เตรียมคำสั่ง SQL สำหรับอัพเดทข้อมูล
	$sql = "UPDATE job_order_template_detail_cost 
        SET hire_price = '$hire_price', overtime_fee = '$overtime_fee', port_charge = '$port_charge', yard_charge = '$yard_charge', container_return = '$container_return', container_cleaning_repair = '$container_cleaning_repair', container_drop_lift = '$container_drop_lift', other_charge = '$other_charge', deduction_note = '$deduction_note', total_expenses = '$total_expenses', wage_travel_cost = '$wage_travel_cost', vehicle_expenses = '$vehicle_expenses',expenses_1 = '$expenses_1', insInvAdd1 = '$insInvAdd1', insInvAdd2 = '$insInvAdd2', insInvAdd3 = '$insInvAdd3', remark = '$Costremark'
        WHERE job_order_template_header_id = '$job_order_template_header_id'";

	// ทำการ Update ข้อมูล 
	
	if (!$conn->query($sql)) {
		
		echo  $conn->errno;
		exit();
	}

	// # Step 2 Finished 


	# Preparation for Step 3 Delete all route 
	$sql = "Delete From job_order_template_detail_plan Where job_order_template_header_id = $job_order_template_header_id";
	
	// ทำการ Delete ข้อมูล 
	
	if (!$conn->query($sql)) {
		
		echo  $conn->errno;
		exit();
	}

	//## Step 3 Create Query เพื่อ Insert job_order_template_detail_plan 
	// อ่านค่า jobDetailPlan จาก Object ที่ส่งมาทาง Ajax
	$jobDetailPlan = $_POST['jobDetailPlan'];
	
	
	// นำข้อมูลจาก $jobDetailPlan มา loop แล้ว insert เข้าตาราง job_order_template_detail_plan
	foreach ($jobDetailPlan as $detailPlan) {
		$location_id = $detailPlan['location_id'];
		$job_order_template_header_id = $job_order_template_header_id; // ค่าที่เพิ่มเติมจากข้อที่ 2
		$plan_order = $detailPlan['plan_order'];
		$branch = $detailPlan['branch'];
		$showName = $detailPlan['showName'];
		$job_characteristic = $detailPlan['job_characteristic'];
		$job_characteristic_id = $detailPlan['job_characteristic_id'];
		$job_note = $detailPlan['job_note'];
		$unique_key = $detailPlan['unique_key'];
		$cardColor = $detailPlan['cardColor'];
		$job_characteristicShow = $detailPlan['job_characteristicShow'];

		// สร้าง SQL query สำหรับ insert ข้อมูลลงในตาราง job_order_template_detail_plan
		$sql = "INSERT INTO job_order_template_detail_plan (job_order_template_header_id, location_id, plan_order, branch, showName, job_characteristic, job_characteristic_id,  job_note, unique_key, cardColor, job_characteristicShow) VALUES ('$job_order_template_header_id', '$location_id', '$plan_order', '$branch', '$showName', '$job_characteristic', $job_characteristic_id, '$job_note', '$unique_key', '$cardColor', '$job_characteristicShow')";

		
		// ทำการ execute SQL query ด้านบน
		// ทำการ Insert ข้อมูล 
		if (!$conn->query($sql)) {
			//echo $sql;
			echo  $conn->errno;
			exit();
		}
	}

	// # Step 3 Finished 
	// Close Connect ===================
	mysqli_close($conn);

	//echo $job_order_template_header_id;
}



//============================ MAIN =========================================================
switch ($f) {
	case 1: {
			loadLocationForSelect();
			break;
		}
	case 2: {
			loadLocationByID();
			break;
		}
	case 3: {
			insertNewJobTemplate();
			break;
		}
	case 4: {
			loadJobTemplateDatafromJobTemplateID();
			break;
		}
	case 5: {
			updateJobTemplateByID();
			break;
		}
}
