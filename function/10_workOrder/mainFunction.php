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

function getRunningNo($running_type, $running_prefix, $date)
{
	// Running Digit
	$leadZerodigit = 3;
	// เชื่อมต่อฐานข้อมูล
	include "../connectionDb.php";

	// กำหนดค่าตัวแปร
	$last_running_no = 0;

	// แยกปีและเดือนจากวันที่
	$running_year = date('y', strtotime($date));
	$running_month = date('m', strtotime($date));

	// ค้นหา last running no จากตาราง system_running_no
	$sql = "SELECT last_running_no FROM system_running_no WHERE running_type='$running_type' AND running_prefix='$running_prefix' AND running_year='$running_year' AND running_month='$running_month'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$last_running_no = $row["last_running_no"];
	} else {
		// ถ้าไม่พบในตาราง ให้เพิ่มข้อมูลลงในตาราง
		$sql = "INSERT INTO system_running_no (running_type, running_prefix, running_year, running_month, last_document_no, last_running_no) VALUES ('$running_type', '$running_prefix', '$running_year', '$running_month', 0, 0)";
		$conn->query($sql);
	}

	// สร้างเลขที่รันรหัสใหม่
	$last_running_no++;
	$document_no = $running_prefix . "-" . $running_year . $running_month . "-" . str_pad($last_running_no, $leadZerodigit, '0', STR_PAD_LEFT);

	// อัพเดท last running no ในตาราง system_running_no
	$sql = "UPDATE system_running_no SET last_document_no='$document_no', last_running_no='$last_running_no' WHERE running_type='$running_type' AND running_prefix='$running_prefix' AND running_year='$running_year' AND running_month='$running_month'";
	$conn->query($sql);

	// ปิดการเชื่อมต่อฐานข้อมูล
	$conn->close();

	// คืนค่าเลขที่รันรหัสใหม่
	return $document_no;
}


function SendNoticeJobConfirm($userId, $accessToken, $message, $link)
{
	$data = [
		'to' => $userId,
		'messages' => [
			[
				'type' => 'flex',
				'altText' => 'มีงานใหม่เข้า',
				'contents' => [
					'type' => 'bubble',
					'body' => [
						'type' => 'box',
						'layout' => 'vertical',
						'contents' => [
							[
								'type' => 'text',
								'text' => $message,
								'wrap' => true
							],
							[
								'type' => 'separator',
								'margin' => 'xl'
							],
							[
								'type' => 'button',
								'style' => 'primary',
								'action' => [
									'type' => 'uri',
									'label' => 'ดูรายละเอียด',
									'uri' => $link
								]
							]
						]
					]
				]
			]
		]
	];

	$url = 'https://api.line.me/v2/bot/message/push';

	$headers = [
		'Content-Type: application/json',
		'Authorization: Bearer ' . $accessToken
	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);

	/*
	if ($result === false) {
		echo 'เกิดข้อผิดพลาดในการส่งข้อความ: ' . curl_error($ch);
	} else {
		echo 'ส่งข้อความและลิงก์ Line Message API สำเร็จ!';
	}
	*/
}




// ======== Function ========
// F=1
function insertNewJobData()
{

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// get data from ajaxData object
	$jobHeaderForm = $_POST['jobHeaderForm'];
	$job_id = -1;

	// Generate Job No 
	$main_book_no = '1'; // Fix Job ID as 1
	$job_date = $jobHeaderForm["job_date"];
	$job_no = getRunningNo('JobNo', 'J', $job_date);
	$job_name = $jobHeaderForm["job_name"];
	$job_type = $jobHeaderForm["job_type"];
	$ClientID = $jobHeaderForm["ClientID"];
	$client_name = $jobHeaderForm["client_name"];
	$customer_id = $jobHeaderForm["customerID"];
	$customer_name = $jobHeaderForm["customer_name"];
	$customer_job_no = $jobHeaderForm["customer_job_no"];
	$customer_po_no = $jobHeaderForm["customer_po_no"];
	$customer_invoice_no = $jobHeaderForm["customer_invoice_no"];
	$goods = $jobHeaderForm["goods"];
	$booking = $jobHeaderForm["booking"];
	$bill_of_lading = $jobHeaderForm["bill_of_lading"];
	$agent = $jobHeaderForm["agent"];
	$quantity = $jobHeaderForm["quantity"];
	$remark = $jobHeaderForm["remark"];
	$create_user = $_POST['create_user'];
	$job_template_id = $_POST['job_template_id'];


	// กำหนดค่าของตัวแปรจาก jobDetailCostForm
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
	$insInvAdd1 = $_POST['jobDetailCostForm']['insInvAdd1'];
	$insInvAdd2 = $_POST['jobDetailCostForm']['insInvAdd2'];
	$insInvAdd3 = $_POST['jobDetailCostForm']['insInvAdd3'];


	// Get Plan 
	$jobDetailPlan = $_POST['jobDetailPlan'];

	// Insert data into job_order_header table
	$sql = "INSERT INTO job_order_header (main_book_no, job_no, job_date, job_name, job_type, ClientID, client_name, customer_id, customer_name, customer_job_no, customer_po_no, customer_invoice_no, goods, booking, bill_of_lading, agent, quantity, remark, status, create_date, create_by, job_template_id) 
        VALUES ('$main_book_no', '$job_no', '$job_date', '$job_name', '$job_type', $ClientID, '$client_name', $customer_id, '$customer_name', '$customer_job_no', '$customer_po_no', '$customer_invoice_no', '$goods', '$booking', '$bill_of_lading', '$agent', '$quantity', '$remark',  'Draft', CURRENT_TIMESTAMP, '$create_user', $job_template_id)";


	// create sql statement to insert data into job_order_header table
	// execute sql statement
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	// Get Job ID
	$job_id  = mysqli_insert_id($conn);

	$jobDetailTrip = $_POST['jobDetailTrip'];

	// Loop ข้อมูลและเพิ่มข้อมูลลงในฐานข้อมูล
	foreach ($jobDetailTrip as $data) {
		// Insert Main Trip ===============================================================
		$tripNo = getRunningNo('TripNo', 'T', $job_date);
		$random_code = gen_rnd_str();
		$sql = "INSERT INTO job_order_detail_trip_info (job_id, job_no, tripNo, tripSeq, truck_id, truck_licenseNo, driver_id, driver_name, subcontrackCheckbox, containersize, containerID, seal_no, containerWeight, containerID2, containersize2, seal_no2, containerWeight2, truckType, jobStartDateTime, status, random_code, create_date, create_user, update_date, update_user) 
		VALUES ('$job_id', '$job_no', '$tripNo', '$data[tripSeq]', '$data[truck_id]', '$data[truck_licenseNo]', '$data[driver_id]', '$data[driver_name]', '$data[subcontrackCheckbox]', '$data[containersize]', '$data[containerID]','$data[sealNo]', '$data[containerWeight]', '$data[containerID2]', '$data[containersize2]', '$data[seal_no2]', '$data[containerWeight2]', '$data[truckType]', '$data[jobStartDateTime]', 'รอเจ้าหน้าที่ยืนยัน', '$random_code', NOW(), '$create_user', NOW(), '$create_user')";

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		// Get Job ID
		$trip_id  = mysqli_insert_id($conn);


		// Insert Cost ======================================================================
		if ($data['subcontrackCheckbox'] == 1) {
			$hire_price_true = $hire_price * 2;
		} else {
			$hire_price_true = $hire_price;
		}
		$total_expenses = array_sum([
			$hire_price_true,
			$overtime_fee,
			$port_charge,
			$yard_charge,
			$container_return,
			$container_cleaning_repair,
			$container_drop_lift,
			$other_charge,
			$deduction_note,
			$wage_travel_cost,
			$vehicle_expenses
		]);

		$sql = "INSERT INTO job_order_detail_trip_cost (job_id, job_no, trip_id, hire_price, overtime_fee, port_charge, yard_charge, container_return, container_cleaning_repair, container_drop_lift, other_charge, deduction_note, total_expenses, wage_travel_cost, vehicle_expenses, insInvAdd1, insInvAdd2, insInvAdd3)
			VALUES ('{$job_id}', '{$job_no}', '{$trip_id}', '{$hire_price_true}', '{$overtime_fee}', '{$port_charge}', '{$yard_charge}', '{$container_return}', '{$container_cleaning_repair}', '{$container_drop_lift}', '{$other_charge}', '{$deduction_note}', '{$total_expenses}', '{$wage_travel_cost}', '{$vehicle_expenses}', '$insInvAdd1', '$insInvAdd2', '$insInvAdd3')";

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		// Insert Trip List =========================================================================
		// สร้าง SQL Query เพื่อ Insert ข้อมูลลงในตาราง job_order_detail_trip_list
		$sql = "INSERT INTO job_order_detail_trip_list (job_id, job_no, trip_id, trip_no, location_id, plan_order, branch, showName, job_characteristic, job_characteristic_id, job_note, unique_key, cardColor, job_characteristicShow, create_datetime, location_code, location_name, customer_id, address, map_url, latitude, longitude, location_type, active, customer_name)
			VALUES ";

		// Loop ข้อมูลจาก Object และเพิ่มค่าลงใน SQL Query
		foreach ($jobDetailPlan as $plan) {
			$sql .= "('" . $job_id . "', '" . $job_no . "', '" . $trip_id . "', '" . $tripNo . "', '" . $plan['location_id'] . "', '" . $plan['plan_order'] . "', '" . $plan['branch'] . "', '" . $plan['showName'] . "', '" . $plan['job_characteristic'] . "', '" . $plan['job_characteristic_id'] . "', '" . $plan['job_note'] . "', '" . $plan['unique_key'] . "', '" . $plan['cardColor'] . "', '" . $plan['job_characteristicShow'] . "', '" . $plan['create_datetime'] . "', '" . $plan['location_code'] . "', '" . $plan['location_name'] . "', '" . $plan['customer_id'] . "', '" . $plan['address'] . "', '" . $plan['map_url'] . "', '" . $plan['latitude'] . "', '" . $plan['longitude'] . "', '" . $plan['location_type'] . "', '" . $plan['active'] . "', '" . $plan['customer_name'] . "'),";
		}

		// ตัด comma ที่ไม่จำเป็นทิ้ง
		$sql = rtrim($sql, ",");

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		// Create Trip Action ========================================================================
		// Step 1 Start Process ================
		$sql = "INSERT INTO job_order_detail_trip_action_log
					(job_id,
					job_no,
					trip_id,
					trip_no,
					main_order,
					minor_order,
					step_desc,
					stage,
					button_name,
					progress)
		SELECT a.job_id,
			a.job_no,
			a.id,
			a.tripno,
			b.main_order,
			b.minor_order,
			b.step_desc,
			b.stage,
			b.button_name,
			b.progress
		FROM   job_order_detail_trip_info a
			INNER JOIN job_action_template b
					ON b.id = 0
						AND b.main_order = 1
		WHERE  a.id = $trip_id
		ORDER  BY b.minor_order; ";

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		// Step 2 Action  Process ================
		$sql = "INSERT INTO job_order_detail_trip_action_log (
		job_id, job_no, trip_id, trip_no, trip_list_id, main_order, minor_order, plan_order, step_desc, stage, button_name, progress
				)
				SELECT
					a.job_id,
					a.job_no,
					a.trip_id,
					a.trip_no,
					a.id as trip_list_id,
					b.main_order,
					b.minor_order,
					a.plan_order,
					b.step_desc,
					b.stage,
					b.button_name,
					b.progress
				FROM
					job_order_detail_trip_list a
					INNER JOIN job_action_template b ON a.job_characteristic_id = b.id
				WHERE
					a.trip_id = $trip_id
				ORDER BY
					a.plan_order,
					b.main_order,
					b.minor_order;";

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		// Step 3 Fotter  Process ================
		$sql = "INSERT INTO job_order_detail_trip_action_log
					(job_id,
					job_no,
					trip_id,
					trip_no,
					main_order,
					minor_order,
					step_desc,
					stage,
					button_name,
					progress)
			SELECT a.job_id,
			a.job_no,
			a.id,
			a.tripno,
			b.main_order,
			b.minor_order,
			b.step_desc,
			b.stage,
			b.button_name,
			b.progress
			FROM   job_order_detail_trip_info a
			INNER JOIN job_action_template b
					ON b.id = 0
						AND b.main_order = 7
			WHERE  a.id = $trip_id
			ORDER  BY b.minor_order; ";

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
	}
	// Close connection
	mysqli_close($conn);
	//echo json_encode($data_Array);

	// Return Job ID
	echo $job_id;
}

// F=2
function loadJobdatabyJobID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}


	$data_Array = array();
	$data_Array['jobHeader'] = array();
	$data_Array['JobDetailTrip'] = array();


	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Step 1 Load data from job_order_template_header
	$sql = "SELECT * FROM job_order_header where id = $MAIN_JOB_ID";


	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$data_Array['jobHeader'][] = $row;
	}



	// Step 2 Load data from job_order_template_detail_cost
	$sql = "SELECT * FROM job_order_detail_trip_info where job_id = $MAIN_JOB_ID";
	//$sql = "SELECT a.*, CONCAT(a.containerID, ' ', a.containerID2) AS container_code FROM job_order_detail_trip_info a where job_id = $MAIN_JOB_ID";
	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$row['container_show'] = "";
		if ($row['containerID2'] != "") {
			$row['container_show'] = $row['containerID'] . ", " . $row['containerID2'];
		} else {
			$row['container_show'] = $row['containerID'];
		}

		$data_Array['JobDetailTrip'][] = $row;
	}


	mysqli_close($conn);
	echo json_encode($data_Array, JSON_UNESCAPED_UNICODE);
}


// F=3
function updateJobHeaderByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}


	$data_Array = array();
	$data_Array['jobHeader'] = array();
	$data_Array['JobDetailTrip'] = array();


	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Step 1 Load data from job_order_template_header
	// กำหนดคำสั่ง SQL statement สำหรับ Update ข้อมูล
	$sql = "UPDATE job_order_header
            SET customer_job_no = '$customer_job_no',
                booking = '$booking',
                bill_of_lading = '$bill_of_lading',
                agent = '$agent',
                goods = '$goods',
                quantity = '$quantity',
                remark = '$remark',
                customer_po_no = '$customer_po_no',
                customer_invoice_no = '$customer_invoice_no',
                update_date = CURRENT_TIMESTAMP,
                update_by = '$update_user'
            WHERE id = '$job_id'";
	//echo  $sql;

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	mysqli_close($conn);
}

// F=4
function loadTripDetailbyJobID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}


	$data_Array = array();
	$data_Array['jobHeader'] = array();
	$data_Array['JobDetailTrip'] = array();
	$data_Array['jobDetailCostForm'] = array();


	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Step 1 Load data from job_order_template_header
	$sql = "SELECT * FROM job_order_header where id = $MAIN_JOB_ID";
	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$data_Array['jobHeader'][] = $row;
	}



	// Step 2 Load data from job_order_template_detail_cost
	$sql = "SELECT * FROM job_order_detail_trip_info where job_id = $MAIN_JOB_ID and id = $MAIN_trip_id";
	//$sql = "SELECT a.*, CONCAT(a.containerID, ' ', a.containerID2) AS container_code FROM job_order_detail_trip_info a where job_id = $MAIN_JOB_ID";
	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$row['container_show'] = "";
		if ($row['containerID2'] != "") {
			$row['container_show'] = $row['containerID'] . ", " . $row['containerID2'];
		} else {
			$row['container_show'] = $row['containerID'];
		}

		$data_Array['JobDetailTrip'][] = $row;
	}

	// Step 3 Load data from job_order_detail_trip_cost
	$sql = "SELECT * FROM job_order_detail_trip_cost where job_id = $MAIN_JOB_ID and trip_id = $MAIN_trip_id";
	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$data_Array['jobDetailCostForm'][] = $row;
	}



	mysqli_close($conn);
	echo json_encode($data_Array, JSON_UNESCAPED_UNICODE);
}

// F=5
function updateTripInfo()
{
	// Load All Data from Paramitor


	// Step 1 Load data from job_order_template_header
	// กำหนดคำสั่ง SQL statement สำหรับ Update ข้อมูล
	// รับค่า Object จาก Ajax
	$driverListForm = $_POST['DriverListForm'];
	$update_user = $_POST['update_user'];
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$MAIN_trip_id = $_POST['MAIN_trip_id'];
	$driver_name = $_POST['driver_name'];

	// กำหนดตัวแปรสำหรับใช้ในการ update
	//$job_id = $driverListForm['MAIN_JOB_ID'];
	//$trip_id = $driverListForm['MAIN_trip_id'];
	$truckDriver = $driverListForm['truckDriver'];
	$truckType = $driverListForm['truckType'];
	$jobStartDateTime = $driverListForm['jobStartDateTime'];
	$subcontrackCheckbox = $driverListForm['subcontrackCheckbox'];
	$containerID = $driverListForm['containerID'];
	$containersize = $driverListForm['containersize'];
	$sealNo = $driverListForm['sealNo'];
	$containerWeight = $driverListForm['containerWeight'];
	$containerID2 = $driverListForm['containerID2'];
	$containersize2 = $driverListForm['containersize2'];
	$sealNo2 = $driverListForm['sealNo2'];
	$containerWeight2 = $driverListForm['containerWeight2'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับ update ข้อมูล
	$sql = "UPDATE job_order_detail_trip_info SET 
		driver_id = $truckDriver, 
		driver_name = '$driver_name', 
		truckType = '$truckType', 
		jobStartDateTime = '$jobStartDateTime', 
		subcontrackCheckbox = $subcontrackCheckbox, 
		containerID = '$containerID', 
		containersize = '$containersize', 
		seal_no = '$sealNo', 
		containerWeight = $containerWeight, 
		containerID2 = '$containerID2', 
		containersize2 = '$containersize2', 
		seal_no2 = '$sealNo2', 
		containerWeight2 = $containerWeight2, 
		update_user = '$update_user' 
		WHERE job_id = $MAIN_JOB_ID AND id = $MAIN_trip_id";

	echo $sql;
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

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
	$insInvAdd1 = $_POST['jobDetailCostForm']['insInvAdd1'];
	$insInvAdd2 = $_POST['jobDetailCostForm']['insInvAdd2'];
	$insInvAdd3 = $_POST['jobDetailCostForm']['insInvAdd3'];

	// เตรียมคำสั่ง SQL สำหรับอัพเดทข้อมูล
	$sql = "UPDATE job_order_detail_trip_cost 
        SET hire_price = '$hire_price', overtime_fee = '$overtime_fee', port_charge = '$port_charge', yard_charge = '$yard_charge', container_return = '$container_return', container_cleaning_repair = '$container_cleaning_repair', container_drop_lift = '$container_drop_lift', other_charge = '$other_charge', deduction_note = '$deduction_note', total_expenses = '$total_expenses', wage_travel_cost = '$wage_travel_cost', vehicle_expenses = '$vehicle_expenses', insInvAdd1 = '$insInvAdd1', insInvAdd2 = '$insInvAdd2', insInvAdd3 = '$insInvAdd3'
        WHERE trip_id = '$MAIN_trip_id'";

	// ทำการ Update ข้อมูล 
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
}

// F=6
function loadTripTimeLine()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	/*
	$sql = "SELECT a.id,
				b.plan_order,
				a.timestamp,
				a.step_desc,
				a.button_name,
				b.location_name,
				a.complete_flag,
				a.main_order,
				a.minor_order
		FROM   job_order_detail_trip_action_log a
				LEFT JOIN job_order_detail_trip_list b
					ON a.trip_id = b.trip_id
						AND a.plan_order = b.plan_order
		WHERE  a.trip_id = $MAIN_trip_id
				AND ( a.complete_flag IS NOT NULL
					OR a.main_order <> 3
					OR a.minor_order = 1 )
		ORDER BY COALESCE(a.timestamp, '9999-12-31 23:59:59') ASC, a.id";
	*/
	$sql = "SELECT *
	FROM   (SELECT a.id,
				   b.plan_order,
				   a.timestamp,
				   a.step_desc,
				   a.button_name,
				   b.location_name,
				   a.complete_flag,
				   a.main_order,
				   a.minor_order,
				   b.latitude, 
				   b.longitude,
				   b.location_id AS location_id,
				   '' AS random_code
			FROM   job_order_detail_trip_action_log a
				   LEFT JOIN job_order_detail_trip_list b
						  ON a.trip_id = b.trip_id
							 AND a.plan_order = b.plan_order
			WHERE  a.trip_id = $MAIN_trip_id
				   AND ( a.complete_flag IS NOT NULL
						  OR a.main_order <> 3
						  OR a.minor_order = 1 )
			UNION ALL
			SELECT z.id        AS id,
				   NULL        AS plan_order,
				   z.date_time AS 'timestamp',
				   z.file_desc AS 'step_desc',
				   NULL        AS button_name,
				   NULL        AS location_name,
				   1           AS complete_flag,
				   99          AS main_order,
				   1           AS minor_order,
				   0.0 as latitude,
				   0.0 as longitude,
				   '' AS location_id,
				   z.random_code
			FROM   jobattachedlog z
			WHERE  z.trip_id = $MAIN_trip_id) a
	ORDER  BY Coalesce(a.timestamp, '9999-12-31 23:59:59') ASC,
			  a.id; ";


	$res = $conn->query(trim($sql));
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$attachedFilesData = array();
		if ($row['random_code'] != "") {
			$sql = "SELECT * FROM attached_files WHERE random_code = '{$row['random_code']}'";
			$attachedFilesRes = $conn->query($sql);

			while ($attachedFileRow = $attachedFilesRes->fetch_assoc()) {
				$attachedFilesData[] = $attachedFileRow;
			}
		}
		$row['attached_file'] = $attachedFilesData;
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F=7
function confirmJob()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$update_user = $_POST['update_user'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Get Line Token 
	$sql = "SELECT * FROM master_data WHERE type = 'system_value' AND name = 'Line Token'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$Line_Token = $row['value'];
	// Get Server vname
	$sql = "SELECT * FROM master_data WHERE type = 'server_name'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$SERVER_NAME = $row['value'];


	// คำสั่ง SQL สำหรับหา job_order_detail_trip_info.id ที่มี job_id = MAIN_JOB_ID
	//$sql = "SELECT id FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID AND status = 'รอเจ้าหน้าที่ยืนยัน' and complete_flag IS NULL";
	$sql = "SELECT 
			a.id, 
			a.driver_name, 
			c.job_name, 
			a.job_no, 
			a.tripNo, 
			a.status, 
			a.random_code, 
			b.line_id,
			a.jobStartDateTime
		FROM 
			job_order_detail_trip_info a 
			Inner Join job_order_header c ON a.job_id = c.id 
			LEFT Join truck_driver_info b ON a.driver_id = b.driver_id 
		WHERE 
			a.job_id = $MAIN_JOB_ID
			AND a.status = 'รอเจ้าหน้าที่ยืนยัน' 
			and a.complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	if ($result->num_rows > 0) {
		// วนลูปแสดงผลลัพธ์
		while ($row = $result->fetch_assoc()) {
			// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
			$id = $row['id'];
			$driver_name = $row['driver_name'];
			$job_name = $row['job_name'];
			$job_no = $row['job_no'];
			$tripNo = $row['tripNo'];
			$status = $row['status'];
			$random_code = $row['random_code'];
			$jobStartDateTime = $row['jobStartDateTime'];
			$User_line_id = $row['line_id'];
			$progress = "";



			$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
			$result2 = $conn->query($sql);

			// ตรวจสอบผลลัพธ์การค้นหา
			if ($result2->num_rows > 0) {
				// แสดงผลลัพธ์และอัพเดทค่าในฐานข้อมูล
				while ($row2 = $result2->fetch_assoc()) {
					$progress = $row2['progress'];
					$id2 = $row2['id'];

					// อัพเดทค่าใน job_order_detail_trip_info
					$sql = "UPDATE job_order_detail_trip_info SET status = '$progress', update_user = '$update_user' WHERE id = $id";
					// ทำการ Update ข้อมูล 
					if (!$conn->query($sql)) {
						echo  $conn->errno;
						exit();
					}

					// อัพเดทค่าใน job_order_detail_trip_action_log
					$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = 1, timestamp = CURRENT_TIMESTAMP(), complete_user = '$update_user' WHERE id = $id2";
					// ทำการ Update ข้อมูล 
					if (!$conn->query($sql)) {
						echo  $conn->errno;
						exit();
					}

					// แสดงผลลัพธ์ในรูปแบบ JSON
					echo json_encode($row2);
				}
			} else {
				echo "0 results";
			}


			// Send Line Notification =======================================================
			if (trim($User_line_id != "")) {

				$thai_date = date('d F y', strtotime($jobStartDateTime));
				$thai_date = str_replace(
					['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					[
						'ม.ค.',
						'ก.พ.',
						'มี.ค.',
						'เม.ย.',
						'พ.ค.',
						'มิ.ย.',
						'ก.ค.',
						'ส.ค.',
						'ก.ย.',
						'ต.ค.',
						'พ.ย.',
						'ธ.ค.'
					],
					$thai_date
				);

				$formattedTime = date('H:i', strtotime($jobStartDateTime));
				$formattedDate = $thai_date . ' เวลา ' . $formattedTime . ' น.';

				$message = "มีงานใหม่เข้า
คนขับ : $driver_name
Job ID : $job_no
Trip ID : $tripNo
ชื่องาน : $job_name
สถานะ : $progress
เริ่มงาน : $formattedDate";

				$link = $SERVER_NAME . 'tripDetail.php?r=' . $random_code;
				SendNoticeJobConfirm($User_line_id, $Line_Token, $message, $link);
			}
		}
		// Update Job Status 
		$sql = "UPDATE job_order_header set status = 'กำลังดำเนินการ', update_by = '$update_user' WHERE id = $MAIN_JOB_ID";
		//echo $sql;
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
	}
	mysqli_close($conn);
}

// F=8
function get_tripStatus()
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
			a.*, 
			b.location_name 
		FROM 
			job_order_detail_trip_action_log a 
			LEFT Join job_order_detail_trip_list b ON a.trip_id = b.trip_id 
			AND a.plan_order = b.plan_order 
		WHERE 
			a.trip_id = $MAIN_trip_id 
			AND a.complete_flag IS NULL 
		ORDER BY 
			a.id ASC 
		LIMIT 
			1;
		";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}

// F=9
function update_trip_status()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$MAIN_trip_id = $_POST['MAIN_trip_id'];
	$update_user = $_POST['update_user'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
	$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $MAIN_trip_id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
	$result2 = $conn->query($sql);

	// ตรวจสอบผลลัพธ์การค้นหา
	if ($result2->num_rows > 0) {
		// แสดงผลลัพธ์และอัพเดทค่าในฐานข้อมูล
		while ($row2 = $result2->fetch_assoc()) {
			$progress = $row2['progress'];
			$id2 = $row2['id'];

			// อัพเดทค่าใน job_order_detail_trip_info
			if ($progress == "จบงาน") {
				$sql = "UPDATE job_order_detail_trip_info SET status = '$progress', complete_flag = 1, update_user = '$update_user' WHERE id = $MAIN_trip_id";
			} else {
				$sql = "UPDATE job_order_detail_trip_info SET status = '$progress', update_user = '$update_user' WHERE id = $MAIN_trip_id";
			}
			// ทำการ Update ข้อมูล 
			if (!$conn->query($sql)) {
				echo $conn->errno;
				exit();
			}

			// อัพเดทค่าใน job_order_detail_trip_action_log
			$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = 1, timestamp = CURRENT_TIMESTAMP(), complete_user = '$update_user' WHERE id = $id2";
			// ทำการ Update ข้อมูล 
			if (!$conn->query($sql)) {
				echo  $conn->errno;
				exit();
			}

			if ($progress == "จบงาน") {
				// ค้นหา job_order_detail_trip_info ที่มี job_id เหมือนกันและมี status เป็น NULL
				$sql = "SELECT * FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID AND complete_flag IS NULL";
				$result = $conn->query($sql);

				// เช็คจำนวน record ที่พบ
				if ($result->num_rows == 0) {
					// อัปเดต status ใน job_order_header เป็น 'เสร็จสิ้น'
					$sql = "UPDATE job_order_header SET status = 'เสร็จสิ้น' WHERE id = $MAIN_JOB_ID";
					if (!$conn->query($sql)) {
						echo $conn->errno;
						exit();
					}
				}
			}



			// แสดงผลลัพธ์ในรูปแบบ JSON
			echo json_encode($row2);
		}
	} else {
		echo "0 results";
	}
	mysqli_close($conn);
}

// F=10
function InsertAttachedfileDataTripLog()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}




	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง jobAttachedLog
	$sql = "INSERT INTO jobAttachedLog (trip_id, file_desc, random_code) VALUES ('$trip_id', '$file_desc', '$random_code')";

	//echo $sql;

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	mysqli_close($conn);
}

// F=11
function cancelJob()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$update_user = $_POST['update_user'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// คำสั่ง SQL สำหรับหา job_order_detail_trip_info.id ที่มี job_id = MAIN_JOB_ID
	$sql = "SELECT id FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID and complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	if ($result->num_rows > 0) {
		// วนลูปแสดงผลลัพธ์
		while ($row = $result->fetch_assoc()) {
			// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
			$id = $row['id'];
			$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
			$result2 = $conn->query($sql);

			// ตรวจสอบผลลัพธ์การค้นหา
			if ($result2->num_rows > 0) {
				// แสดงผลลัพธ์และอัพเดทค่าในฐานข้อมูล
				while ($row2 = $result2->fetch_assoc()) {
					$progress = $row2['progress'];
					$id2 = $row2['id'];

					// อัพเดทค่าใน job_order_detail_trip_info
					$sql = "UPDATE job_order_detail_trip_info SET status = 'ยกเลิก', update_user = '$update_user', complete_flag = -1 WHERE id = $id";
					// ทำการ Update ข้อมูล 
					if (!$conn->query($sql)) {
						echo  $conn->errno;
						exit();
					}

					// อัพเดทค่าใน job_order_detail_trip_action_log
					$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = -1, timestamp = CURRENT_TIMESTAMP(), complete_user = '$update_user' WHERE id = $id2";
					// ทำการ Update ข้อมูล 
					if (!$conn->query($sql)) {
						echo  $conn->errno;
						exit();
					}

					// แสดงผลลัพธ์ในรูปแบบ JSON
					echo json_encode($row2);
				}
			} else {
				echo "0 results";
			}
		}
		// Update Job Status 
		$sql = "UPDATE job_order_header set status = 'ยกเลิก', update_by = '$update_user' WHERE id = $MAIN_JOB_ID";
		//echo $sql;
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
	}
	mysqli_close($conn);
}

// F=12
function getTripforGoogleMapbyTripID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT a.location_code, a.job_characteristic, a.latitude, a.longitude FROM job_order_detail_trip_list a Where trip_id = $trip_id";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}

// F=13
function getTripIDfromRandomCode()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select id, job_id, driver_name, driver_id From job_order_detail_trip_info where random_code = '$randomCode'";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}

// loadTripDetailforEdit
// F=14
function loadTripDetailforEdit()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT * FROM job_order_detail_trip_list a 
	Where a.job_id = $job_id AND a.trip_id = $trip_id Order By a.plan_order;";

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
			insertNewJobData();
			break;
		}
	case 2: {
			loadJobdatabyJobID();
			break;
		}
	case 3: {
			updateJobHeaderByID();
			break;
		}
	case 4: {
			loadTripDetailbyJobID();
			break;
		}
	case 5: {
			updateTripInfo();
			break;
		}
	case 6: {
			loadTripTimeLine();
			break;
		}
	case 7: {
			confirmJob();
			break;
		}
	case 8: {
			get_tripStatus();
			break;
		}
	case 9: {
			update_trip_status();
			break;
		}
	case 10: {
			InsertAttachedfileDataTripLog();
			break;
		}
	case 11: {
			cancelJob();
			break;
		}
	case 12: {
			getTripforGoogleMapbyTripID();
			break;
		}
	case 13: {
			getTripIDfromRandomCode();
			break;
		}
	case 14: {
			loadTripDetailforEdit();
			break;
		}
}
