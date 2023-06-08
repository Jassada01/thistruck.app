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
function MonthlyReport()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Query to get all container_sizes
	$container_sizes = "SELECT name FROM master_data WHERE type = 'container_size'";
	$result = $conn->query($container_sizes);

	if ($result->num_rows > 0) {
		// Create SQL script with dynamic SUM(CASE WHEN containersize = '...' THEN 1 ELSE 0 END) AS '...' fields
		$sum_cases = "";
		while ($row = $result->fetch_assoc()) {
			$container_size = $row["name"];
			$sum_cases .= "SUM(CASE WHEN containersize = '$container_size' THEN 1 ELSE 0 END) AS `$container_size`, ";
		}

		// Add SUM(CASE WHEN ...) for 'ไม่ระบุ' after all container_sizes
		$sum_cases .= "SUM(CASE WHEN containersize IS NULL OR containersize = '' THEN 1 ELSE 0 END) AS `ไม่ระบุ`, ";

		// Add count for all containersize (including 'ไม่ระบุ')
		$sum_cases .= "COUNT(containersize) AS `รวมทั้งหมด`";
		$sumCasesql = "
					SELECT 
						job_id, 
						job_no, 
						$sum_cases
					FROM 
						job_order_detail_trip_info
					GROUP BY 
						job_id, job_no ";

		$sql = "SELECT 
			b.*, 
			a.job_date as 'วันที่', 
			a.job_type as 'ประเภทงาน', 
			a.job_name  as 'ชื่องาน', 
			a.client_name  as 'ผู้ว่าจ้าง', 
			a.customer_name  as 'ชื่อลูกค้า', 
			a.customer_job_no  as 'Job NO ของลูกค้า', 
			a.customer_po_no as 'PO No.', 
			a.customer_invoice_no as 'Invoice No.', 
			a.goods  as 'ชื่อสินค้า', 
			a.booking  as 'Booking (บุ๊กกิ้ง)', 
			a.bill_of_lading  as 'B/L(ใบขน)', 
			a.agent  as 'Agent(เอเย่นต์)', 
			a.quantity  as 'QTY/No. of Package', 
			a.remark  as 'หมายเหตุ', 
			a.status  as 'สถานะ', 
			c.* 
		  FROM 
			job_order_header a 
			Left join ($sumCasesql) b ON a.id = b.job_id 
			Left Join (
			  SELECT 
				job_id, 
				SUM(hire_price) AS 'ราคางาน', 
				SUM(overtime_fee) AS 'ค่าล่วงเวลา', 
				SUM(port_charge) AS 'ค่าผ่านท่า', 
				SUM(yard_charge) AS 'ค่าผ่านลาน', 
				SUM(container_return) AS 'ค่ารับตู้/คืนตู้', 
				SUM(container_cleaning_repair) AS 'ค่าซ่อมตู้', 
				SUM(container_drop_lift) AS 'ค่าล้างตู้', 
				SUM(other_charge) AS 'ค่าใช้จ่ายอื่นๆ', 
				SUM(deduction_note) AS 'ใบหัก ณ ที่จ่ายกระทำแทน', 
				SUM(total_expenses) AS 'ค่าใช้จ่ายรวมทั้งหมด', 
				SUM(wage_travel_cost) AS 'ค่าเดินทาง/ค่าเที่ยว', 
				SUM(vehicle_expenses) AS 'ค่าใช้จ่ายรถ' 
			  FROM 
				job_order_detail_trip_cost 
			  GROUP BY 
				job_id
			) c ON a.id = c.job_id 
		  Where 
			DATE_FORMAT(a.job_date, '%m%Y') = '062023' 
			AND a.status <> 'ยกเลิก' 
		  Order By 
			a.id";

		//echo  $sql;
	} else {
		echo "0 results";
	}

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
			MonthlyReport();
			break;
		}
}
