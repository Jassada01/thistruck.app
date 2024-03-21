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


// ======== Function ========
// F=1
function loadJobHeader()
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
				a.*, 
				b.jobStartDateTime, 
				b.containerID, 
				c.ClientCode
			FROM 
				job_order_header a 
				Left Join (
				SELECT 
					a.job_id, 
					a.jobStartDateTime, 
					REPLACE(
					GROUP_CONCAT(
						IF(
						a.containerID = '', NULL, a.containerID
						) SEPARATOR ','
					), 
					',', 
					'<br>'
					) AS containerID 
				FROM 
					job_order_detail_trip_info a 
				GROUP BY 
					a.job_id
				) b ON a.id = b.job_id
				LEFT Join client_info c ON a.ClientID = c.ClientID
				WHERE a.status = 'เสร็จสิ้น'
				and a.id NOT IN (SELECT z.job_id FROM invoice_job_mapping z Where z.attr = 'ใช้งาน')
				AND a.job_date BETWEEN '$startDate' AND '$endDate'
			Order By 
				a.job_date DESC";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$refDoc_Data = ""; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
		// ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
		$customerJobNo = $row['customer_job_no'];
		if (!empty($customerJobNo)) {
			$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "<br>";
		}

		$booking = $row['booking'];
		if (!empty($booking)) {
			$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "<br>";
		}

		$customerPoNo = $row['customer_po_no'];
		if (!empty($customerPoNo)) {
			$refDoc_Data .= "PO No.: " . $customerPoNo . "<br>";
		}

		$billOfLading = $row['bill_of_lading'];
		if (!empty($billOfLading)) {
			$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "<br>";
		}

		$customerInvoiceNo = $row['customer_invoice_no'];
		if (!empty($customerInvoiceNo)) {
			$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "<br>";
		}

		$agent = $row['agent'];
		if (!empty($agent)) {
			$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "<br>";
		}

		$goods = $row['goods'];
		if (!empty($goods)) {
			$refDoc_Data .= "ชื่อสินค้า: " . $goods . "<br>";
		}

		$quantity = $row['quantity'];
		if (!empty($quantity)) {
			$refDoc_Data .= "QTY/No. of Package: " . $quantity . "<br>";
		}

		$row['refDoc_Data'] = $refDoc_Data;
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=2
function loadJobHeaderSelected()
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
				a.*, 
				b.jobStartDateTime, 
				b.containerID 
			FROM 
				job_order_header a 
				Left Join (
				SELECT 
					a.job_id, 
					a.jobStartDateTime, 
					REPLACE(
					GROUP_CONCAT(
						IF(
						a.containerID = '', NULL, a.containerID
						) SEPARATOR ','
					), 
					',', 
					'<br>'
					) AS containerID 
				FROM 
					job_order_detail_trip_info a 
				GROUP BY 
					a.job_id
				) b ON a.id = b.job_id 
				WHERE a.status = 'เสร็จสิ้น'
				AND a.id in ($selected_id)
			Order By 
				a.job_date DESC";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$refDoc_Data = ""; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
		// ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
		$customerJobNo = $row['customer_job_no'];
		if (!empty($customerJobNo)) {
			$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "<br>";
		}

		$booking = $row['booking'];
		if (!empty($booking)) {
			$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "<br>";
		}

		$customerPoNo = $row['customer_po_no'];
		if (!empty($customerPoNo)) {
			$refDoc_Data .= "PO No.: " . $customerPoNo . "<br>";
		}

		$billOfLading = $row['bill_of_lading'];
		if (!empty($billOfLading)) {
			$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "<br>";
		}

		$customerInvoiceNo = $row['customer_invoice_no'];
		if (!empty($customerInvoiceNo)) {
			$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "<br>";
		}

		$agent = $row['agent'];
		if (!empty($agent)) {
			$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "<br>";
		}

		$goods = $row['goods'];
		if (!empty($goods)) {
			$refDoc_Data .= "ชื่อสินค้า: " . $goods . "<br>";
		}

		$quantity = $row['quantity'];
		if (!empty($quantity)) {
			$refDoc_Data .= "QTY/No. of Package: " . $quantity . "<br>";
		}

		$row['refDoc_Data'] = $refDoc_Data;
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=3
function createNewInvoice()
{
	//sleep(3);
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Step 1 Insert New Header ===========================================================
	$sql = "INSERT INTO invoice_header  (document_date, customer_code, is_tax_invoice, price_type, created_by, updated_by, attr1) 
	VALUES  (CURRENT_DATE, '$selectClient', '2', '3', '$create_user', '$create_user', 'ใช้งาน')";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Get invoice_id
	$invoice_id  = mysqli_insert_id($conn);

	// Update Ref Doc======================================================================
	// SQL query
	$sql = "SELECT TRIM(BOTH FROM CONCAT_WS(', ',
		IF(NULLIF(TRIM(customer_job_no), '') IS NOT NULL, TRIM(customer_job_no), NULL),
		IF(NULLIF(TRIM(customer_po_no), '') IS NOT NULL, TRIM(customer_po_no), NULL),
		IF(NULLIF(TRIM(customer_invoice_no), '') IS NOT NULL, TRIM(customer_invoice_no), NULL),
		IF(NULLIF(TRIM(goods), '') IS NOT NULL, TRIM(goods), NULL),
		IF(NULLIF(TRIM(booking), '') IS NOT NULL, TRIM(booking), NULL),
		IF(NULLIF(TRIM(bill_of_lading), '') IS NOT NULL, TRIM(bill_of_lading), NULL),
		IF(NULLIF(TRIM(quantity), '') IS NOT NULL, TRIM(quantity), NULL)
		)) AS result
		FROM job_order_header
		WHERE id IN ($selected_id)
		HAVING result != ''";

	// Execute SQL query
	$result = $conn->query($sql);

	// Initialize an empty array to hold unique results
	$uniqueResults = [];

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$fields = explode(", ", $row['result']);
			$uniqueResults = array_unique(array_merge($uniqueResults, $fields));
		}
	}

	// Convert the unique results array back to a string separated by ", "
	$uniqueResultsString = implode(", ", $uniqueResults);
	$sql = "Update invoice_header set reference = '$uniqueResultsString' WHERE id = $invoice_id";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Insert Mapping ======================================================================
	// แปลงเป็น array
	$job_ids = explode(',', $selected_id);


	// รอบวนลูปเพื่อ insert ข้อมูล
	foreach ($job_ids as $job_idx) {
		$sql = "INSERT INTO invoice_job_mapping (invoice_id, job_id,attr)
            VALUES ($invoice_id, $job_idx,'ใช้งาน')";
		//echo $sql;
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
	}



	// Insert Price Raw ============================================================================
	$accounting_type = '410202';
	$pay_invoice = 1; //เรียกเก็บเงิน
	$pay_purchase = 0; //จ่ายคืนให้กับ

	foreach ($job_ids as $job_id) {
		$sql_select = "SELECT a.job_name,d.id as trip_id,  IFNULL(c.price, 0.00) as price FROM job_order_header a 
				Left join  service_items_mapping b ON a.job_template_id = b.jobTemplate_ID
				Left Join service_items c ON b.service_id = c.id
				LEFT JOIN job_order_detail_trip_info d ON a.id = d.job_id
				Where a.id = $job_id";

		$result = $conn->query($sql_select);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$trip_id = $row['trip_id'];
				$unit_price = $row['price'];
				$job_name = $row['job_name'];
				$sql_insert = "INSERT INTO invoice_detail_raw (invoice_id, job_id, trip_id, accounting_type, cost_type, description , unit_price, pay_invoice, pay_purchase) 
								   VALUES ($invoice_id, $job_id, $trip_id, '$accounting_type', 'job_price','ค่าขนส่ง : $job_name', $unit_price, $pay_invoice, $pay_purchase)";

				if (!$conn->query($sql_insert)) {
					echo  $conn->errno;
					exit();
				}
			}
		}
	}

	// Insert Cost Raw ============================================================================
	$accounting_type = '113302';
	$pay_invoice = 1; //เรียกเก็บเงิน
	$pay_purchase = 1; //จ่ายคืนให้กับ

	foreach ($job_ids as $job_id) {
		//$sql_select = "SELECT * FROM job_order_detail_trip_cost WHERE job_id = $job_id";
		$sql_select = "SELECT 
				a.*, 
				c.driver_id, 
				c.driver_name, 
				c.payto 
			FROM 
				job_order_detail_trip_cost a 
				left join job_order_detail_trip_info b ON a.job_id = b.job_id 
				AND a.trip_id = b.id 
				Left Join truck_driver_info c ON b.driver_id = c.driver_id 
			WHERE 
				a.job_id = $job_id
			";
		$result = $conn->query($sql_select);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$trip_id = $row['trip_id'];
				$driver_id = $row['driver_id'];
				$driver_name = $row['driver_name'];
				$payto  = $row['payto'];
				$fields = [
					'hire_price', 'overtime_fee', 'port_charge', 'yard_charge', 'container_return',
					'container_cleaning_repair', 'container_drop_lift', 'other_charge',
					'deduction_note', 'wage_travel_cost', 'vehicle_expenses', 'expenses_1'
				];

				foreach ($fields as $field) {
					if ($field == 'hire_price') {
						$pay_invoice = 0;
					} else {
						$pay_invoice = 1;
					}
					if ($field == 'overtime_fee') {
						$accounting_type = '410202';
					} else {
						$accounting_type = '113302';
					}
					$unit_price = $row[$field];
					$sql_insert = "INSERT INTO invoice_detail_raw (invoice_id, job_id, trip_id, accounting_type, cost_type, unit_price, pay_invoice, pay_purchase, driver_id, driver_name, payto) 
								   VALUES ($invoice_id, $job_id, $trip_id, '$accounting_type', '$field', $unit_price, $pay_invoice, $pay_purchase, $driver_id, '$driver_name', '$payto')";

					if (!$conn->query($sql_insert)) {
						echo  $conn->errno;
						exit();
					}
				}
			}
		}
	}

	// update Desc for Cost Raw ======================================================================
	$sql = "UPDATE invoice_detail_raw 
		Inner Join invoice_expense_desc ON invoice_detail_raw.cost_type = invoice_expense_desc.expense
		SET description = invoice_expense_desc.desc_main
		WHERE invoice_detail_raw.invoice_id = $invoice_id AND expense <> 'hire_price'";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	$sql = "UPDATE invoice_detail_raw
		INNER JOIN job_order_detail_trip_cost 
		ON invoice_detail_raw.job_id = job_order_detail_trip_cost.job_id AND invoice_detail_raw.trip_id = job_order_detail_trip_cost.trip_id
		SET invoice_detail_raw.description = CONCAT('สำรองจ่าย : ', IF(NULLIF(TRIM(job_order_detail_trip_cost.remark), '') IS NOT NULL, TRIM(job_order_detail_trip_cost.remark), 'ค่าใช้จ่ายอื่นๆ'))
		WHERE invoice_detail_raw.invoice_id = $invoice_id
		AND invoice_detail_raw.cost_type = 'other_charge'";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Update hire_price
	$sql = "UPDATE invoice_detail_raw  a
	LEFT JOIN job_order_header b ON a.job_id = b.id
	SET description = CONCAT('ค่าจ้างขนส่ง : ', IFNULL(b.job_name, '' ))
	Where a.invoice_id = $invoice_id AND a.cost_type = 'hire_price'";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Process Update Ref Doc
	foreach ($job_ids as $job_id) {
		$sql = "SELECT * FROM job_order_header a Where a.id = $job_id";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				// Process Here ======================
				$refDoc_Data = "\n";

				$customerJobNo = $row['customer_job_no'];
				if (!empty($customerJobNo)) {
					$refDoc_Data .= "Job NO: " . $customerJobNo . "\n";
				}

				$booking = $row['booking'];
				if (!empty($booking)) {
					$refDoc_Data .= "Booking: " . $booking . "\n";
				}

				$customerPoNo = $row['customer_po_no'];
				if (!empty($customerPoNo)) {
					$refDoc_Data .= "PO No.: " . $customerPoNo . "\n";
				}

				$billOfLading = $row['bill_of_lading'];
				if (!empty($billOfLading)) {
					$refDoc_Data .= "B/L: " . $billOfLading . "\n";
				}

				$customerInvoiceNo = $row['customer_invoice_no'];
				if (!empty($customerInvoiceNo)) {
					$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "\n";
				}

				$agent = $row['agent'];
				if (!empty($agent)) {
					$refDoc_Data .= "Agent: " . $agent . "\n";
				}

				$goods = $row['goods'];
				if (!empty($goods)) {
					$refDoc_Data .= "ชื่อสินค้า: " . $goods . "\n";
				}

				$quantity = $row['quantity'];
				if (!empty($quantity)) {
					$refDoc_Data .= "QTY/No. of Package: " . $quantity . "\n";
				}

				// Update Process 

				if ($refDoc_Data != "\n") {
					$update_sql = "UPDATE invoice_detail_raw 
				  SET 
					description = CONCAT(description, '$refDoc_Data') 
				  WHERE 
					invoice_id = $invoice_id
					AND job_id = $job_id
					AND cost_type = 'job_price'
				  ";
					//echo $update_sql;
					if (!$conn->query($update_sql)) {
						echo  $conn->errno;
						exit();
					}
				}
			}
		}
	}







	// Close connection ==================================================================
	mysqli_close($conn);

	// Echo $invoice_id
	echo $invoice_id;
}

// F = 4
function loadInvoiceData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();
	$data_Array['header'] = array();
	$data_Array['detail'] = array();


	// สร้างคำสั่ง SQL สำหรับข้อมูล Header
	//$sql = "SELECT * FROM invoice_header WHERE id = $invoice_id";
	$sql = "SELECT a.*, b.ClientName FROM invoice_header a 
		Left Join client_info b ON a.customer_code = b.ClientCode
		WHERE a.id = $invoice_id";


	$res = $conn->query(trim($sql));

	while ($row = $res->fetch_assoc()) {
		$data_Array['header'][] = $row;
	}

	// สร้างคำสั่ง SQL สำหรับข้อมูล Detail
	//$sql = "SELECT * FROM invoice_detail_raw WHERE invoice_id = $invoice_id order by job_id, trip_id, id LIMIT 20";
	if ($Onlyhavevalue == "1") {
		$sql = "SELECT 
		a.*, 
		b.job_no, 
		b.tripNo, 
		c.ContactName,
		b.driver_name as realDriverName,
		b.jobStartDateTime, 
		d.job_name
	FROM 
		invoice_detail_raw a 
		LEFT JOIN job_order_detail_trip_info b ON a.trip_id = b.id 
		LEFT JOIN contacts c ON a.payto = c.ContactID
		LEFT JOIN job_order_header d ON b.job_id = d.id
	WHERE 
		a.invoice_id = $invoice_id
		AND (a.unit_price <> 0 OR a.cost_type = 'job_price')
	order by 
		a.job_id, 
		a.trip_id, 
		a.id
		";
	} else {
		$sql = "SELECT 
			a.*, 
			b.job_no, 
			b.tripNo, 
			c.ContactName,
			b.driver_name as realDriverName,
			b.jobStartDateTime, 
			d.job_name
		FROM 
			invoice_detail_raw a 
			LEFT JOIN job_order_detail_trip_info b ON a.trip_id = b.id 
			LEFT JOIN contacts c ON a.payto = c.ContactID
			LEFT JOIN job_order_header d ON b.job_id = d.id
		WHERE 
			a.invoice_id = $invoice_id
		order by 
			a.job_id, 
			a.trip_id, 
			a.id
			";
	}


	$res = $conn->query(trim($sql));

	while ($row = $res->fetch_assoc()) {
		$data_Array['detail'][] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 5
function rewriteServicePrice()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";
	// รับข้อมูลจาก Ajax
	$uploadResult = json_decode($_POST["uploadResult"], true);

	// Initial Delete All Data 
	//$sql = "TRUNCATE Table service_items";
	//
	//if (!$conn->query($sql)) {
	//	echo  $conn->errno;
	//	exit();
	//}


	foreach ($uploadResult as $item) {
		// กรองข้อมูลที่ไม่ตรงเงื่อนไข
		if ($item["item_code"] === null) {
			continue;
		}

		$item_code = $item['item_code'];
		$item_desc = $item["item_desc"] ?? "";
		$price = $item['price'];

		// แปลงค่า null ของ item_desc ให้เป็น ""


		// ตรวจสอบว่า item_code มีอยู่ในฐานข้อมูลหรือไม่
		$query = "SELECT id FROM service_items WHERE item_name = '$item_code'";
		$result = $conn->query($query);
		$rowcount = mysqli_num_rows($result);
		//echo $rowcount;
		if ($rowcount > 0) {
			// มี item_code นี้อยู่แล้วในฐานข้อมูล, ทำการอัปเดต
			$update_query = "UPDATE service_items SET description='$item_desc', price='$price' WHERE item_name='$item_code'";
			if (!$conn->query($update_query)) {
				//echo $update_query;
				echo  $conn->errno;
				exit();
			}
		} else {
			// ไม่มี item_code นี้, ทำการเพิ่มข้อมูลใหม่
			$insert_query = "INSERT INTO service_items (item_name, description, price) VALUES ('$item_code', '$item_desc', '$price')";
			//echo $insert_query;
			if (!$conn->query($insert_query)) {
				echo  $conn->errno;
				exit();
			}
		}
	}

	mysqli_close($conn);
}


// F = 6
function uploadContact()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";
	// รับข้อมูลจาก Ajax
	$uploadResult = json_decode($_POST["uploadResult"], true);


	foreach ($uploadResult as $item) {
		$ContactID = $item['ContactID'];
		$TaxID = $item['TaxID'];
		$ContactType = $item['ContactType'];
		$ContactName = $item['ContactName'];


		$sql = "INSERT INTO Contacts (ContactID, TaxID, ContactType, ContactName) 
				VALUES ('$ContactID', '$TaxID', '$ContactType', '$ContactName') 
				ON DUPLICATE KEY UPDATE TaxID='$TaxID', ContactType='$ContactType', ContactName='$ContactName'";

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
	}

	$conn->close();
}

// F = 7
function updateRowInvoiceDatabyID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";
	$sql = "UPDATE invoice_detail_raw set $data_type = '$data_value' WHERE id = $data_id AND invoice_id = $invoice_id";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 8
function updateRowInvoiceDatabytrip()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";
	//$sql = "UPDATE invoice_detail_raw set $data_type = '$data_value' WHERE id = $data_id AND invoice_id = $invoice_id";
	$sql = "";

	if ($trip_id == "") {
		$sql = "UPDATE invoice_detail_raw set $data_type = '$data_value' WHERE job_id = $job_id AND invoice_id = $invoice_id AND cost_type <> 'job_price'";
	} else {
		$sql = "UPDATE invoice_detail_raw set $data_type = '$data_value' WHERE job_id = $job_id AND trip_id = $trip_id AND invoice_id = $invoice_id AND cost_type <> 'job_price'";
	}



	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
	echo $trip_id;
}


// F = 9
function loadInvoiceDataSummary()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();
	$data_Array['header'] = array();
	$data_Array['detail'] = array();


	// สร้างคำสั่ง SQL สำหรับข้อมูล Header
	//$sql = "SELECT * FROM invoice_header WHERE id = $invoice_id";
	$sql = "SELECT a.*, b.ClientName FROM invoice_header a 
		Left Join client_info b ON a.customer_code = b.ClientCode
		WHERE a.id = $invoice_id";


	$res = $conn->query(trim($sql));

	while ($row = $res->fetch_assoc()) {
		$data_Array['header'][] = $row;
	}

	$sql = "SELECT 
			a.id, 
			DATE_FORMAT(a.document_date, '%Y%m%d') AS document_date, 
			'' AS Document_No, 
			a.reference, 
			a.customer_code, 
			'' AS TAX_ID, 
			'' AS BRANCH, 
			'2' AS Issue_TAX_INV, 
			'3' AS TAX_CAT, 
			CASE WHEN b.accounting_type = '410202' THEN d.job_name ELSE '' END AS ProductCode, 
			b.accounting_type, 
			b.description, 
			count(*) AS QTY, 
			b.unit_price, 
			SUM(b.unit_price) AS AMT, 
			'0' AS deduct, 
			'NO' AS VAT, 
			CASE WHEN b.accounting_type = '410202' THEN '1' ELSE '0' END AS withHoldingtax, 
			GROUP_CONCAT(c.containerID) AS Remark, 
			'' AS type 
		FROM 
			invoice_header a 
			INNER JOIN invoice_detail_raw b ON a.id = b.invoice_id 
			Left Join job_order_detail_trip_info c ON b.job_id = c.job_id 
			AND b.trip_id = c.id 
			LEFT JOIN job_order_header d ON b.job_id = d.id 
		WHERE 
			a.id = $invoice_id 
			AND b.unit_price <> 0 
			AND b.pay_invoice = 1 
		GROUP BY 
			a.id, 
			a.document_date, 
			a.reference, 
			a.customer_code, 
			b.accounting_type, 
			b.description, 
			b.unit_price 
		Order By 
			b.accounting_type DESC
  ";
	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array['detail'][] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 10
function updateInvoiceHeader()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";
	$sql = "Update invoice_header SET reference = '$reference', document_number = '$documentNumber' WHERE id = $invoice_id";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
}


// F = 11
function loadPaymentDataSummary()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();


	$sql = "SELECT 
			a.id, 
			DATE_FORMAT(a.document_date, '%Y%m%d') AS document_date, 
			'' AS REF_DOC, 
			b.payto, 
			'' AS TAX_ID, 
			'' AS BRANCH, 
			'' AS TAXINV_NO, 
			'' AS TAXINV_DATE, 
			'3' AS TAX_TYPE, 
			CASE WHEN b.cost_type = 'hire_price' THEN e.item_name ELSE '' END AS Job_Name, 
			CASE WHEN b.cost_type = 'hire_price' THEN '510112' ELSE '114102' END AS Accounting_No, 
			b.description, 
			COUNT(*) AS QTY, 
			b.unit_price, 
			'0' AS TAX, 
			CASE WHEN b.cost_type = 'hire_price' THEN '1' ELSE '0'END AS WHT_rate, 
			'' AS Payby, 
			'0' AS AMT, 
			'' AS PNGD, 
			GROUP_CONCAT(f.tripNo) AS Remark, 
			'' AS Group_Type, 
			g.ContactName 
		From 
			invoice_header a 
			INNER JOIN invoice_detail_raw b ON a.id = b.invoice_id 
			LEFT JOIN job_order_header c ON b.job_id = c.id 
			LEFT JOIN service_items_mapping d ON c.job_template_id = d.jobTemplate_ID 
			LEFT JOIN service_items e ON d.service_id = e.id 
			LEFT JOIN job_order_detail_trip_info f ON b.trip_id = f.id 
			AND b.job_id = f.job_id 
			LEFT JOIN contacts g ON b.payto = g.ContactID 
		WHERE 
			a.id = $invoice_id 
			AND b.pay_purchase = 1 
			AND b.unit_price <> 0 
		Group BY 
			a.id, 
			a.document_date, 
			b.payto, 
			e.item_name, 
			b.description, 
			b.unit_price, 
			g.ContactName 
		Order By 
			b.payto
  ";
	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 12
function loadInvoiceIndex()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();


	$sql = "SELECT 
				a.id, 
				a.document_date, 
				a.document_number, 
				a.customer_code AS ContactID, 
				e.ClientName AS ContactName, 
				a.reference, 
				GROUP_CONCAT(d.job_no) AS job_no, 
				IFNULL(g.id, '') as billing_id, 
				IFNULL(g.billing_no, '') AS billing_no 
			FROM 
				invoice_header a 
				LEFT JOIN contacts b ON a.customer_code = b.ContactID 
				LEFT JOIN invoice_job_mapping c ON a.id = c.invoice_id 
				LEFT JOIN job_order_header d ON c.job_id = d.id 
				LEFT JOIN client_info e ON a.customer_code = e.ClientCode 
				LEFT JOIN billing_detail f ON f.invoice_id = a.id 
				AND f.active = 1 
				LEFT JOIN billing_header g ON f.billing_header_id = g.id 
				AND g.status <> 4 
			WHERE 
				a.attr1 = 'ใช้งาน' 
			GROUP BY 
				a.id, 
				a.document_date, 
				a.document_number, 
				b.ContactID, 
				b.ContactName, 
				a.reference 
			ORDER BY 
				a.id DESC;
	
		";
	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 13
function ExportInvoiceFile()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();


	$sql = " SELECT 
			'1' AS 'ลำดับที่*', 
			DATE_FORMAT(a.document_date, '%Y%m%d') AS 'วันที่เอกสาร', 
			'' AS 'เลขที่เอกสาร' , 
			a.reference AS 'อ้างอิงถึง', 
			a.customer_code AS 'ลูกค้า' , 
			'' AS 'เลขทะเบียน 13 หลัก', 
			'' AS 'เลขสาขา 5 หลัก', 
			'2' AS 'เป็นใบกำกับภาษี', 
			'3' AS 'ประเภทราคา', 
			CASE WHEN b.accounting_type = '410202' THEN d.job_name ELSE '' END AS 'สินค้า/บริการ', 
			b.accounting_type AS 'บัญชี', 
			b.description AS 'คำอธิบาย',  
			count(*) AS 'จำนวน', 
			b.unit_price AS 'ราคาต่อหน่วย', 
			'0' AS 'ส่วนลดต่อหน่วย', 
			'NO' AS 'อัตราภาษี', 
			CASE WHEN b.accounting_type = '410202' THEN '1%' ELSE '0' END AS 'ถูกหัก ณ ที่จ่าย(ถ้ามี)', 
			GROUP_CONCAT(c.containerID) AS 'หมายเหตุ', 
			'' AS 'กลุ่มจัดประเภท' 
		FROM 
			invoice_header a 
			INNER JOIN invoice_detail_raw b ON a.id = b.invoice_id 
			Left Join job_order_detail_trip_info c ON b.job_id = c.job_id 
			AND b.trip_id = c.id 
			LEFT JOIN job_order_header d ON b.job_id = d.id 
		WHERE 
			a.id = $invoice_id
			AND b.unit_price <> 0 
			AND b.pay_invoice = 1 
		GROUP BY 
			a.id, 
			a.document_date, 
			a.reference, 
			a.customer_code, 
			b.accounting_type, 
			b.description, 
			b.unit_price 
		Order By 
			b.accounting_type DESC
  ";
	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}


// F = 14
function ExportPurchaseFile()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();


	$sql = " SELECT 
	a.id AS 'ลำดับที่*', 
	DATE_FORMAT(a.document_date, '%Y%m%d') AS 'วันที่เอกสาร', 
	'' AS 'อ้างอิงถึง', 
	b.payto AS 'ผู้รับเงิน/คู่ค้า', 
	'' AS 'เลขทะเบียน 13 หลัก', 
	'' AS 'เลขสาขา 5 หลัก', 
	'' AS 'เลขที่ใบกำกับฯ (ถ้ามี)', 
	'' AS 'วันที่ใบกำกับฯ (ถ้ามี)', 
	'3' AS 'ประเภทราคา', 
	CASE WHEN b.cost_type = 'hire_price' THEN e.item_name ELSE '' END AS 'สินค้า/บริการ',  
	CASE WHEN b.cost_type = 'hire_price' THEN '510112' ELSE '114102' END AS 'บัญชี', 
	b.description AS 'คำอธิบาย', 
	COUNT(*) AS 'จำนวน', 
	b.unit_price AS 'ราคาต่อหน่วย', 
	'0' AS 'อัตราภาษี', 
	CASE WHEN b.cost_type = 'hire_price' THEN '1%' ELSE '0' END AS 'หัก ณ ที่จ่าย (ถ้ามี)', 
	'' AS 'ชำระโดย', 
	'0' AS 'จำนวนเงินที่ชำระ', 
	'' AS 'PNG', 
	GROUP_CONCAT(f.tripNo) AS 'หมายเหตุ', 
	'' AS 'กลุ่มจัดประเภท'
  From 
	invoice_header a 
	INNER JOIN invoice_detail_raw b ON a.id = b.invoice_id 
	LEFT JOIN job_order_header c ON b.job_id = c.id 
	LEFT JOIN service_items_mapping d ON c.job_template_id = d.jobTemplate_ID 
	LEFT JOIN service_items e ON d.service_id = e.id 
	LEFT JOIN job_order_detail_trip_info f ON b.trip_id = f.id 
	AND b.job_id = f.job_id 
	LEFT JOIN contacts g ON b.payto = g.ContactID 
  WHERE 
	a.id = $invoice_id 
	AND b.pay_purchase = 1 
	AND b.unit_price <> 0 
  Group BY 
	a.id, 
	a.document_date, 
	b.payto, 
	e.item_name, 
	b.description, 
	b.unit_price, 
	g.ContactName 
  Order By 
	b.payto
  ";
	$res = $conn->query(trim($sql));

	$cntLine = 0;
	$id_temp  = "---";
	while ($row = $res->fetch_assoc()) {
		if ($row['ผู้รับเงิน/คู่ค้า'] != $id_temp) {
			$id_temp = $row['ผู้รับเงิน/คู่ค้า'];
			$cntLine += 1;
		}
		$row['ลำดับที่*'] = $cntLine;
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 15
function cancelInvoice()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Cancel In Header
	$sql = "UPDATE invoice_header SET attr1 = 'ยกเลิก' WHERE id = $invoice_id";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}





	// Cancel in Mapping
	$sql = "UPDATE invoice_job_mapping SET attr = 'ยกเลิก' WHERE invoice_id = $invoice_id";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	mysqli_close($conn);
}

// F = 16
function generateInvoiceNo()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	$new_Invoice_No = getRunningNo('InvNo', 'INV', $doc_date);
	// Cancel In Header
	$sql = "UPDATE invoice_header SET document_number = '$new_Invoice_No' WHERE id = $invoice_id";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
}

// F = 17
function createNewPriceList()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Cancel In Header
	$insert_query = "INSERT INTO service_items (item_name, description, price) VALUES ('$item_name', '$description', '$price')";
	//echo $insert_query;
	if (!$conn->query($insert_query)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
}

// F = 18
function updatePrice()
{
	// Load All Data from Paramitor
	//foreach ($_POST as $key => $value) {
	//	$a = htmlspecialchars($key);
	//	$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	//}
	$MAIN_EDIT_PRICELIST_ID = $_POST['MAIN_EDIT_PRICELIST_ID'];
	$description = $_POST['description'];
	$dynamicChangePrice = $_POST['dynamicChangePrice'];
	$dynamicpriceStape = $_POST['dynamicpriceStape'];
	$editDynamicPrice = $_POST['editDynamicPrice'];
	$item_name = $_POST['item_name'];
	$price = $_POST['price'];
	$priceDetails = $_POST['priceDetails'];
	$starter_price = $_POST['starter_price'];


	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Cancel In Header
	$update_sql = "UPDATE service_items SET
		item_name = '$item_name'
		, price = '$price'
		, description = '$description'
		,dynamicPrice = '$editDynamicPrice'
		,updated_at = CURRENT_TIMESTAMP
		WHERE id = $MAIN_EDIT_PRICELIST_ID";
	//echo $update_sql;
	if (!$conn->query($update_sql)) {
		echo  $conn->errno;
		exit();
	}

	// Initial Delete
	$sql = "Delete From dynamicpriceheader Where id = $MAIN_EDIT_PRICELIST_ID";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	$sql = "Delete From dynamicpricedetail Where id = $MAIN_EDIT_PRICELIST_ID";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	if ($editDynamicPrice == "1") {
		// Insert Header 
		$sql = "Insert Into dynamicpriceheader(id, priceStart, priceStep, Step) Values ($MAIN_EDIT_PRICELIST_ID, $starter_price, $dynamicChangePrice, $dynamicpriceStape)";
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		// Insert Detail 
		foreach ($priceDetails as $detail) {
			$min = $detail['Min'];
			$max = $detail['Max'];
			$price = $detail['Price'];

			// เตรียมคำสั่ง SQL
			$sql = "INSERT INTO dynamicpricedetail (id, min, max, price) VALUES ($MAIN_EDIT_PRICELIST_ID, $min, $max, $price)";
			if (!$conn->query($sql)) {
				echo $sql;
				echo  $conn->errno;
				exit();
			}
		}
	}


	mysqli_close($conn);
}

// F = 19
function loadDynamicPrice()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();


	$sql = " Select * From dynamicpriceheader where id = $MAIN_EDIT_PRICELIST_ID";
	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 20
function loadInvoiceHeaderForSelect()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();


	$sql = "SELECT 
			a.id, 
			a.document_number, 
			a.document_date, 
			b.Attr1 AS paymentterm, 
			CASE WHEN b.Attr1 IS NULL THEN NULL WHEN b.Attr1 = '' THEN NULL ELSE DATE_ADD(
			a.document_date, INTERVAL b.Attr1 DAY
			) END AS due_date, 
			a.reference, 
			a.customer_code AS ClientCode, 
			b.ClientName, 
			c.total_price, 
			c.wht 
		FROM 
			invoice_header a 
			LEFT JOIN client_info b ON a.customer_code = b.ClientCode 
			LEFT JOIN (
			SELECT 
				a.invoice_id, 
				SUM(a.unit_price) AS total_price, 
				SUM(a.withHoldingtax) AS wht 
			FROM 
				(
				SELECT 
					a.invoice_id, 
					a.unit_price, 
					CASE WHEN a.accounting_type = '410202' THEN a.unit_price * 0.01 ELSE '0' END AS withHoldingtax 
				FROM 
					invoice_detail_raw a 
				Where 
					a.pay_invoice = 1 
					AND a.unit_price <> 0
				) a 
			Group By 
				a.invoice_id
			) c ON a.id = c.invoice_id 
		WHERE 
			a.attr1 <> 'ยกเลิก'
			AND a.document_date BETWEEN '$startDate' AND '$endDate'
			AND a.id NOT IN (SELECT a.invoice_id FROM billing_detail a Where a.active = 1)
		";
	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}
// F = 21
function loadCustomerInfobyClientCode()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();


	$sql = "SELECT * FROM client_info a Where a.ClientCode = '$ClientCode'";
	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F= 22
function createnewBilling()
{
	// ดึงข้อมูลส่วน Header
	$header = $_POST['header'];

	// สร้างตัวแปรสำหรับข้อมูลที่จะ insert
	$create_user = $_POST['create_user'];
	$clientID = $header['ClientID'];
	$clientCode = $header['ClientCode'];
	$clientName = $header['ClientName'];
	$branch = $header['Branch'];
	$billingAddress = $header['BillingAddress'];
	$taxID = $header['TaxID'];
	$billingDate = $header['billing_date'];
	$dueDate = $header['due_date'];
	$remark = $header['billing_remark'];
	$new_billing_running_no = getRunningNo('BillNo', 'BL', $billingDate);;
	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้าง SQL script สำหรับ insert
	$sql = "Insert Into billing_header (
		billing_no, clientID, client_code, 
		client_name, branch, billing_address, 
		tax_id, billing_date, due_date, remark,
		create_datetime, create_user, update_datetime, update_user
	  ) 
	  VALUES 
		(
		  '$new_billing_running_no', '$clientID', 
		  '$clientCode', '$clientName', '$branch', 
		  '$billingAddress', '$taxID', '$billingDate', 
		  '$dueDate', '$remark', CURRENT_TIMESTAMP, '$create_user', CURRENT_TIMESTAMP, '$create_user'
		)
	  ";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Get invoice_id
	$billing_id  = mysqli_insert_id($conn);

	$details  = $_POST['detail'];
	foreach ($details as $detail) {
		// สร้าง SQL script
		$sql = "INSERT INTO billing_detail (invoice_id, invoice_no, document_date, due_date, total_amount, wht_amount, reference_doc, billing_header_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = $conn->prepare($sql);
		if (!$stmt) {
			echo "Error preparing statement: " . $conn->error;
			continue;
		}

		// คำสั่งนี้สมมติว่าคุณมี billing_header_id ที่เกี่ยวข้องแล้ว
		// คุณอาจต้องปรับแก้ตามข้อมูลจริงของคุณ
		$stmt->bind_param(
			"issdddsi",
			$detail['id'],
			$detail['document_number'],
			$detail['document_date'],
			$detail['due_date'],
			$detail['total_price'],
			$detail['wht'],
			$detail['reference'],
			$billing_id
		);

		if (!$stmt->execute()) {
			echo "Error inserting record: " . $stmt->error . "\n";
		}

		$stmt->close();
	}

	// Update Amount 
	$sql = "UPDATE billing_header bh
		SET bh.total_amount = (SELECT SUM(bd.total_amount) FROM billing_detail bd WHERE bd.billing_header_id = $billing_id),
			bh.vat_amount = (SELECT SUM(bd.vat_amount) FROM billing_detail bd WHERE bd.billing_header_id = $billing_id),
			bh.wht_amt = (SELECT SUM(bd.wht_amount) FROM billing_detail bd WHERE bd.billing_header_id = $billing_id),
			bh.grand_total = (SELECT SUM(bd.grand_total_amount) FROM billing_detail bd WHERE bd.billing_header_id = $billing_id)
		WHERE bh.id = $billing_id;
";
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	echo $billing_id;
	mysqli_close($conn);
}

// F = 23
function loadBillingData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();
	$data_Array['detail'] = array();


	// สร้างคำสั่ง SQL สำหรับข้อมูล Header
	//$sql = "SELECT * FROM invoice_header WHERE id = $invoice_id";
	$sql = "SELECT 
		a.*, 
		b.status_thai, 
		b.status_eng 
	FROM 
		billing_header a 
		Inner JOIN system_status_master b ON a.status = b.status_code 
		AND b.status_type = 'BL' 
	where 
		a.id = $billingID";


	$res = $conn->query(trim($sql));

	while ($row = $res->fetch_assoc()) {
		$data_Array['header'] = $row;
	}

	// สร้างคำสั่ง SQL สำหรับข้อมูล Detail
	//$sql = "SELECT * FROM invoice_detail_raw WHERE invoice_id = $invoice_id order by job_id, trip_id, id LIMIT 20";
	$sql = "SELECT * FROM billing_detail a 
		Where a.billing_header_id = $billingID
		Order By a.detail_id;";


	$res = $conn->query(trim($sql));

	while ($row = $res->fetch_assoc()) {
		$data_Array['detail'][] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}

// F = 24
function updateBillingData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();
	$data_Array['detail'] = array();


	// Cancel In Header
	$updateSQL = "UPDATE billing_header SET 
		ref = '$ref'
		, due_date = '$due_date'
		, remark = '$remark'
		, update_user = '$update_user'
		, update_datetime = CURRENT_TIMESTAMP
	WHERE id = $billing_id";
	echo $updateSQL;
	if (!$conn->query($updateSQL)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
}

// F = 25
function cancelBilling()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();
	$data_Array['detail'] = array();


	// Cancel In Header
	$updateSQL = "UPDATE billing_header SET 
		status = 4
		, update_user = '$update_user'
		, update_datetime = CURRENT_TIMESTAMP
	WHERE id = $billing_id";
	echo $updateSQL;
	if (!$conn->query($updateSQL)) {
		echo  $conn->errno;
		exit();
	}

	// Cancel In Detail
	$updateSQL = "UPDATE billing_detail SET 
		active = 0
	WHERE billing_header_id  = $billing_id";
	echo $updateSQL;
	if (!$conn->query($updateSQL)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
}

// F = 26
function loadBillingIndex()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";


	$data_Array = array();

	if ($active == "checked") {
		$sql = "SELECT 
		a.id, 
		a.billing_no,
		a.billing_date, 
		a.due_date, 
		a.clientID, 
		a.client_name, 
		a.total_amount, 
		a.wht_amt, 
		a.status, 
		c.status_thai, 
		c.status_eng, 
		GROUP_CONCAT(b.invoice_no) AS invoice 
	FROM 
		billing_header a 
		Inner Join billing_detail b ON a.id = b.billing_header_id 
		Left Join system_status_master c ON a.status = c.status_code 
		AND c.status_type = 'BL' 
	WHERE a.status <> 4
	Group By 
		a.id 
	Order By 
		a.id DESC;
	";
	} else {
		$sql = "SELECT 
		a.id, 
		a.billing_no,
		a.billing_date, 
		a.due_date, 
		a.clientID, 
		a.client_name, 
		a.total_amount, 
		a.wht_amt, 
		a.status, 
		c.status_thai, 
		c.status_eng, 
		GROUP_CONCAT(b.invoice_no) AS invoice 
	FROM 
		billing_header a 
		Inner Join billing_detail b ON a.id = b.billing_header_id 
		Left Join system_status_master c ON a.status = c.status_code 
		AND c.status_type = 'BL' 
	Group By 
		a.id 
	Order By 
		a.id DESC;
	";
	}

	$res = $conn->query(trim($sql));


	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	mysqli_close($conn);
	echo json_encode($data_Array);
}



//============================ MAIN =========================================================
switch ($f) {
	case 1: {
			loadJobHeader();
			break;
		}
	case 2: {
			loadJobHeaderSelected();
			break;
		}
	case 3: {
			createNewInvoice();
			break;
		}
	case 4: {
			loadInvoiceData();
			break;
		}
	case 5: {
			rewriteServicePrice();
			break;
		}
	case 6: {
			uploadContact();
			break;
		}
	case 7: {
			updateRowInvoiceDatabyID();
			break;
		}
	case 8: {
			updateRowInvoiceDatabytrip();
			break;
		}
	case 9: {
			loadInvoiceDataSummary();
			break;
		}
	case 10: {
			updateInvoiceHeader();
			break;
		}
	case 11: {
			loadPaymentDataSummary();
			break;
		}
	case 12: {
			loadInvoiceIndex();
			break;
		}
	case 13: {
			ExportInvoiceFile();
			break;
		}
	case 14: {
			ExportPurchaseFile();
			break;
		}
	case 15: {
			cancelInvoice();
			break;
		}
	case 16: {
			generateInvoiceNo();
			break;
		}

	case 17: {
			createNewPriceList();
			break;
		}
	case 18: {
			updatePrice();
			break;
		}
	case 19: {
			loadDynamicPrice();
			break;
		}
	case 20: {
			loadInvoiceHeaderForSelect();
			break;
		}
	case 21: {
			loadCustomerInfobyClientCode();
			break;
		}
	case 22: {
			createnewBilling();
			break;
		}
	case 23: {
			loadBillingData();
			break;
		}
	case 24: {
			updateBillingData();
			break;
		}
	case 25: {
			cancelBilling();
			break;
		}
	case 26: {
			loadBillingIndex();
			break;
		}
}
