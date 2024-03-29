<?php
require_once('assets/plugins/custom/TCPDF/examples/tcpdf_include.php');


function DateThai($strDate)
{
	$strYear = date("Y", strtotime($strDate)) + 543;
	$strMonth = date("n", strtotime($strDate));
	$strDay = date("j", strtotime($strDate));
	$strHour = date("H", strtotime($strDate));
	$strMinute = date("i", strtotime($strDate));
	$strSeconds = date("s", strtotime($strDate));
	$strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$strMonthThai = $strMonthCut[$strMonth];
	return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}


function thai_date_format($datetime)
{
	// รายชื่อเดือนภาษาไทย
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

	// แยกวันที่และเวลา
	$datetime = explode(' ', $datetime);

	// แยกปี เดือน วัน
	$date = explode('-', $datetime[0]);

	// แยกชั่วโมงและนาที
	$time = explode(':', $datetime[1]);

	// ปรับปีเป็นปี พ.ศ.
	$year = $date[0] + 543;

	// รวมวันที่และเวลาเป็นภาษาไทย
	$thai_date = $date[2] . " " . $thai_month_arr[(int)$date[1]] . " " . $year . " เวลา " . $time[0] . ":" . $time[1] . " น.";

	return $thai_date;
}


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
	//Page header
	public function Header()
	{
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->setAutoPageBreak(false, 0);
		// set bacground image
		$img_file = 'assets/media/pdf_template/jobOrder_1.jpg';
		$this->Image($img_file, null, 0, 210, 297, '', '', '', false, 300, 'C', false, false, 0);
		// restore auto-page-break status
		$this->setAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

$job_id = $_GET['job_id'];


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->SetAuthor('This Truck System');
$pdf->SetTitle('Job Order');
$pdf->SetSubject('Job Order');

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(0);
$pdf->setFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->setAutoPageBreak(FALSE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// define barcode style
$style = array(
	'position' => '',
	'align' => 'C',
	'stretch' => false,
	'fitwidth' => true,
	'cellfitalign' => '',
	'border' => 0,
	'hpadding' => 'auto',
	'vpadding' => 'auto',
	'fgcolor' => array(0, 0, 0),
	'bgcolor' => false, //array(255,255,255),
	'text' => true,
	'font' => 'thsarabunb',
	'fontsize' => 10,
	'stretchtext' => 8
);


// Load Data =================================

$server_name = "localhost";
$UID = "root";
$Pass = "}Ww]3v2CX<2mSH$7";
$DB_name = "mysystem";
$conn = new mysqli($server_name, $UID, $Pass, $DB_name);


$trip_job_no = "";
$trip_tripNo = "";


// Get Server Name 
$sql = "SELECT * FROM master_data WHERE type = 'server_name'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$SERVER_NAME = $row['value'];



$sql = "SELECT * FROM job_order_header WHERE id = $job_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// ดึงข้อมูลแถวแรก
	$row = $result->fetch_assoc();

	// ตัวแปรเก็บค่าข้อมูล
	$main_book_no = $row['main_book_no'];
	$job_no = $row['job_no'];
	$job_date = $row['job_date'];
	$job_type = $row['job_type'];
	$job_name = $row['job_name'];
	$ClientID = $row['ClientID'];
	$client_name = $row['client_name'];
	$customer_id = $row['customer_id'];
	$customer_name = $row['customer_name'];
	$customer_job_no = $row['customer_job_no'];
	$customer_po_no = $row['customer_po_no'];
	$customer_invoice_no = $row['customer_invoice_no'];
	$goods = $row['goods'];
	$booking = $row['booking'];
	$bill_of_lading = $row['bill_of_lading'];
	$agent = $row['agent'];
	$quantity = $row['quantity'];
	$remark = $row['remark'];
	$job_template_id = $row['job_template_id'];
	$status = $row['status'];

	// ทำสิ่งที่คุณต้องการกับข้อมูลที่โหลดได้
	// ...

}

$refDoc1 = "";
$refDoc2 = "";
$delimiter = "";
$switchcnt = 1;

if (!empty($customer_job_no)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "Job NO ของลูกค้า : " . $customer_job_no . "\n";
	} else {
		$refDoc2 .=  "Job NO ของลูกค้า : " . $customer_job_no . "\n";
	}
}

if (!empty($customer_po_no)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "PO NO ของลูกค้า : " . $customer_po_no . "\n";
	} else {
		$refDoc2 .=  "PO NO ของลูกค้า : " . $customer_po_no . "\n";
	}
}

if (!empty($customer_invoice_no)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "Invoice NO ของลูกค้า : " . $customer_invoice_no . "\n";
	} else {
		$refDoc2 .=  "Invoice NO ของลูกค้า : " . $customer_invoice_no . "\n";
	}
}

if (!empty($goods)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "Goods : " . $goods . "\n";
	} else {
		$refDoc2 .=  "Goods : " . $goods . "\n";
	}
}

if (!empty($booking)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "Booking : " . $booking . "\n";
	} else {
		$refDoc2 .=  "Booking : " . $booking . "\n";
	}
}

if (!empty($bill_of_lading)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "Bill of Lading : " . $bill_of_lading . "\n";
	} else {
		$refDoc2 .=  "Bill of Lading : " . $bill_of_lading . "\n";
	}
}

if (!empty($agent)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "Agent : " . $agent . "\n";
	} else {
		$refDoc2 .=  "Agent : " . $agent . "\n";
	}
}

if (!empty($quantity)) {
	$switchcnt += 1;
	if ($switchcnt % 2 == 0) {
		$refDoc1 .=  "Quantity : " . $quantity . "\n";
	} else {
		$refDoc2 .=  "Quantity : " . $quantity . "\n";
	}
}


$fontColor = array(48, 84, 150);



// Get All Trip in Job
$sql = "SELECT COUNT(*) AS countAllTrip FROM job_order_detail_trip_info a WHERE a.job_id = $job_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$AllTripinJob = $row['countAllTrip'];

if (isset($_GET['trip_id'])) {
	$trip_id = $_GET['trip_id'];
	$sql = "SELECT a.*, b.contact_number, b.nameVisable FROM job_order_detail_trip_info a LEFT JOIN truck_driver_info b ON a.driver_id = b.driver_id WHERE a.job_id = $job_id AND a.id = $trip_id";
} else {
	$sql = "SELECT a.*, b.contact_number, b.nameVisable FROM job_order_detail_trip_info a LEFT JOIN truck_driver_info b ON a.driver_id = b.driver_id WHERE a.job_id = $job_id";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		// ตัวแปรเก็บค่าข้อมูล
		$trip_job_order_id = $row['id'];
		$trip_job_id = $row['job_id'];
		$trip_job_no = $row['job_no'];
		$trip_tripNo = $row['tripNo'];
		$trip_tripSeq = $row['tripSeq'];
		$trip_truck_id = $row['truck_id'];
		$trip_truck_licenseNo = $row['truck_licenseNo'];
		$trip_driver_id = $row['driver_id'];
		$trip_driver_name = $row['driver_name'];
		$trip_containerID = $row['containerID'];
		$trip_seal_no = $row['seal_no'];
		$trip_containerWeight = $row['containerWeight'];
		$trip_subcontrackCheckbox = $row['subcontrackCheckbox'];
		$trip_containersize = $row['containersize'];
		$trip_containerID2 = $row['containerID2'];
		$trip_seal_no2 = $row['seal_no2'];
		$trip_containerWeight2 = $row['containerWeight2'];
		$trip_containersize2 = $row['containersize2'];
		$trip_truckType = $row['truckType'];
		$trip_jobStartDateTime = $row['jobStartDateTime'];
		$trip_status = $row['status'];
		$trip_complete_flag = $row['complete_flag'];
		$trip_contact_number = $row['contact_number'];
		$trip_random_code = $row['random_code'];
		$trip_driver_visable = $row['nameVisable'];

		if ($trip_driver_visable == "0") {
			$trip_driver_name = ".................................................................";
			$trip_truck_licenseNo = ".................................................................";
			$trip_contact_number = ".................................................................";
		}

		mysqli_set_charset($conn, "utf8");
		// ---------------------------------------------------------

		// ...
		$pdf->AddPage();

		//main_book_no
		$pdf->SetXY(166, 37); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 16);
		$pdf->SetTextColor($fontColor[0], $fontColor[1], $fontColor[2]);
		//$pdf->Cell(0, 10, $main_book_no, 0, 1, 'L', false, '', 0, false, 'T', 'C');


		// Set position x, y for the text
		$pdf->SetXY(185, 37); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 16);
		//$pdf->Cell(0, 10, '1', 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// job_date
		$pdf->SetXY(164, 36.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 16);
		// แปลงวันที่เป็นภาษาไทย
		$thai_date = date('d F Y', strtotime($job_date));
		$thai_date = str_replace(
			['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			$thai_date
		);
		$pdf->Cell(0, 10, $thai_date, 0, 1, 'L', false, '', 0, false, 'T', 'C');



		// job_no
		$pdf->SetXY(164, 41.7); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 25);
		$pdf->Cell(0, 10, $job_no, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_tripNo
		$pdf->SetXY(164, 50.2); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 18);
		$pdf->Cell(0, 10, $trip_tripNo, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// customer_name
		$pdf->SetXY(44, 40.8); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 14);
		$pdf->Cell(0, 10, $customer_name, 0, 1, 'L', false, '', 0, false, 'T', 'C');


		// client_name
		$pdf->SetXY(44, 48.4); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 14);
		$pdf->Cell(0, 10, $client_name, 0, 1, 'L', false, '', 0, false, 'T', 'C');


		// $refDoc1
		$pdf->SetXY(21, 81); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 14);
		//$pdf->Cell(0, 10, $refDoc, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		$pdf->MultiCell(0, 10, $refDoc1, 0, 'L', false, 1, '', '', true);

		// $refDoc2
		$pdf->SetXY(105, 81); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 14);
		//$pdf->Cell(0, 10, $refDoc, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		$pdf->MultiCell(0, 10, $refDoc2, 0, 'L', false, 1, '', '', true);


		switch ($job_type) {
			case "EXPORT":
				$pdf->SetFont('zapfdingbats', '', 22);
				$pdf->writeHTMLCell(10, 10, 29.5, 54.5, '3', $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
				break;
			case "IMPORT":
				$pdf->SetFont('zapfdingbats', '', 22);
				$pdf->writeHTMLCell(10, 10, 56.5, 54.5, '3', $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
				break;
			case "DOMESTIC":
				$pdf->SetFont('zapfdingbats', '', 22);
				$pdf->writeHTMLCell(10, 10, 81.5, 54.5, '3', $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
				break;
			default:
				$pdf->SetFont('zapfdingbats', '', 22);
				$pdf->writeHTMLCell(10, 10, 116, 54.5, '3', $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
				$pdf->SetXY(120, 58.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 16);
				$pdf->Cell(0, 10, $job_type, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		}




		// trip_tripSeq
		$pdf->SetXY(191, 2); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 16);
		//$pdf->Cell(0, 10, $trip_tripSeq, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		$pdf->Cell(0, 10, $trip_tripSeq . "/" . $AllTripinJob, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_truckType
		$pdf->SetXY(164, 59.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 16);
		//$pdf->Cell(0, 10, $trip_truckType, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		//$pdf->setFillColor(255, 255, 255);
		$pdf->MultiCell(40, 5, $trip_truckType . "\n", 0, 'L', false, 1, '', '', true);

		if ($trip_driver_visable == 0) {

			// trip_driver_name
			$pdf->SetXY(32, 111.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', 10);
			$pdf->Cell(0, 10, $trip_driver_name, 0, 1, 'L', false, '', 0, false, 'T', 'C');

			// trip_contact_number
			$pdf->SetXY(96, 111.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', 10);
			$pdf->Cell(0, 10, $trip_contact_number, 0, 1, 'L', false, '', 0, false, 'T', 'C');
			// trip_truck_licenseNo
			$pdf->SetXY(161, 111.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', 10);
			$pdf->Cell(0, 10, $trip_truck_licenseNo, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		} else {

			// trip_driver_name
			$pdf->SetXY(36, 109.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', 18);
			$pdf->Cell(0, 10, $trip_driver_name, 0, 1, 'L', false, '', 0, false, 'T', 'C');

			// trip_contact_number
			$pdf->SetXY(100, 109.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', 18);
			$pdf->Cell(0, 10, $trip_contact_number, 0, 1, 'L', false, '', 0, false, 'T', 'C');

			// trip_truck_licenseNo
			$licensefs = 18;
			if (strlen($trip_truck_licenseNo) > 30) {
				$licensefs = 14;
			}
			$pdf->SetXY(162, 109.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', $licensefs);
			$pdf->Cell(0, 10, $trip_truck_licenseNo, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		}



		// trip_container 1 ===========================================================
		// trip_containerID
		$pdf->SetXY(38, 120); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 20);
		$pdf->Cell(0, 10, $trip_containerID, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_seal_no
		$pdf->SetXY(98.5, 120); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 16);
		$pdf->Cell(0, 10, $trip_seal_no, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_containersize
		$pdf->SetXY(139, 120); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 18);
		$pdf->Cell(0, 10, $trip_containersize, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_containerWeight
		if (($trip_containerWeight != "") and ($trip_containerWeight != 0.00)) {
			$pdf->SetXY(178, 120); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', 18);
			$pdf->Cell(0, 10, number_format($trip_containerWeight) . " กก.", 0, 1, 'L', false, '', 0, false, 'T', 'C');
		}


		// trip_container 2 ===========================================================
		// trip_containerID2
		$pdf->SetXY(38, 130); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 20);
		$pdf->Cell(0, 10, $trip_containerID2, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_seal_no2
		$pdf->SetXY(98, 130); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 18);
		$pdf->Cell(0, 10, $trip_seal_no2, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_containersize
		$pdf->SetXY(139, 130); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', 'B', 18);
		$pdf->Cell(0, 10, $trip_containersize2, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_containerWeight2
		if (($trip_containerWeight2 != "") and ($trip_containerWeight2 != 0.00)) {
			$pdf->SetXY(178, 115); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetFont('thsarabunb', 'B', 18);
			$pdf->Cell(0, 10, number_format($trip_containerWeight2) . " กก.", 0, 1, 'L', false, '', 0, false, 'T', 'C');
		}



		// remark
		$pdf->SetXY(15, 246); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', '', 14);
		//$pdf->Cell(0, 10, $remark, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		//$pdf->SetXY(164, 76); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		//$pdf->SetFont('thsarabunb', 'B', 16);
		//$pdf->Cell(0, 10, $trip_truckType, 0, 1, 'L', false, '', 0, false, 'T', 'C');
		//$pdf->setFillColor(255, 255, 255);

		// Split the string into an array by newline
		$lines = explode("\n", $remark);

		// Remove empty lines from array
		$lines = array_filter($lines, 'trim');

		// If the array has more than 4 lines, replace newlines with ', '
		if (count($lines) > 4) {
			$remark = implode(", ", $lines);
		}
		$pdf->MultiCell(185, 5, $remark, 0, 'L', false, 1, '', '', true);


		//trip_jobStartDateTime

		$pdf->SetXY(44, 63); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', '', 14);
		$pdf->Cell(0, 10,  thai_date_format($trip_jobStartDateTime), 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// trip_containerWeight2
		// กำหนดโซนเวลา
		date_default_timezone_set('Asia/Bangkok');
		$currentDateTime = date('d/m/Y H:i:s');
		$pdf->SetXY(15, 287); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
		$pdf->SetFont('thsarabunb', '', 14);
		$pdf->Cell(0, 10, "Export Date : " . $currentDateTime, 0, 1, 'R', false, '', 0, false, 'T', 'C');


		//$trip_status
		// trip_containerWeight2
		if ($trip_status == "ยกเลิก") {
			$pdf->SetXY(98, 28); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
			$pdf->SetTextColor(200, 42, 75);
			$pdf->SetFont('thsarabunb', '', 30);
			$pdf->Cell(0, 10, "ใบงานนี้ถูกยกเลิก", 0, 1, 'L', false, '', 0, false, 'T', 'C');
		}

		$pdf->SetTextColor($fontColor[0], $fontColor[1], $fontColor[2]);
		// Load Location list ============================================

		$sql = "Select 
			a.plan_order, 
			a.job_characteristic_id,
			b.location_code, 
			b.location_name, 
			a.job_characteristic,
			a.job_note 
		From 
			job_order_detail_trip_list a 
			Inner Join locations b ON a.location_id = b.location_id 
		Where 
			a.trip_id = $trip_job_order_id 
		Order By 
			a.plan_order;
		";


		$resTrip = $conn->query($sql);
		$cnt = 0;
		while ($row2 = $resTrip->fetch_assoc()) {
			$trip_detail_plan_order = $row2['plan_order'];
			$trip_detail_job_characteristic_id = $row2['job_characteristic_id'];
			$trip_detail_location_code = $row2['location_code'];
			$trip_detail_location_name = $row2['location_name'];
			$trip_detail_job_characteristic = $row2['job_characteristic'];
			$trip_detail_job_note = $row2['job_note'];

			if ($trip_detail_location_code == "XXX") {
				$trip_detail_location_code = "__________________";
			}
			if (in_array($trip_detail_job_characteristic_id, ['1000', '1001'])) {
				// Pickup Process
				$pdf->SetXY(46, 141); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 18);
				$pdf->Cell(0, 10, $trip_detail_location_code, 0, 1, 'L', false, '', 0, false, 'T', 'C');

				$pdf->SetXY(46, 147); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 14);
				$pdf->Cell(0, 10, str_replace("Pick Up (รับตู้) >> ", "รับ", $trip_detail_job_characteristic), 0, 1, 'L', false, '', 0, false, 'T', 'C');

				$pdf->SetXY(32, 153.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 11);
				//$pdf->Cell(0, 10, str_replace("\n", ' ', $trip_detail_job_note), 0, 1, 'L', false, '', 0, false, 'T', 'C');
				$pdf->MultiCell(50, 5, str_replace("\n", ' ', $trip_detail_job_note) . "", 0, 'L', false, 1, '', '', true);
			} else if (in_array($trip_detail_job_characteristic_id, ['1010', '1011'])) {
				// Return Process
				$pdf->SetXY(122, 141); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 18);
				$pdf->Cell(0, 10, $trip_detail_location_code, 0, 1, 'L', false, '', 0, false, 'T', 'C');

				$pdf->SetXY(122, 147); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 14);
				$pdf->Cell(0, 10, str_replace("Return  (คืนตู้) >> ", "คืน", $trip_detail_job_characteristic), 0, 1, 'L', false, '', 0, false, 'T', 'C');

				$pdf->SetXY(109, 153.5); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 11);
				//$pdf->Cell(0, 10, $trip_detail_job_note, 0, 1, 'L', false, '', 0, false, 'T', 'C');
				$pdf->MultiCell(50, 5, str_replace("\n", ' ', $trip_detail_job_note) . "", 0, 'L', false, 1, '', '', true);
			} else {
				$pdf->SetXY(46, 162 + ($cnt * 18)); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 18);
				$pdf->Cell(0, 10, $trip_detail_location_code, 0, 1, 'L', false, '', 0, false, 'T', 'C');

				$pdf->SetXY(46, 166 + ($cnt * 18)); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 14);
				$pdf->Cell(0, 10, $trip_detail_job_characteristic, 0, 1, 'L', false, '', 0, false, 'T', 'C');

				$pdf->SetXY(32, 172 + ($cnt * 18)); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
				$pdf->SetFont('thsarabunb', 'B', 11);
				//$pdf->Cell(0, 10, $trip_detail_job_note, 0, 1, 'L', false, '', 0, false, 'T', 'C');
				$pdf->MultiCell(50, 5, str_replace("\n", ' ', $trip_detail_job_note) . "", 0, 'L', false, 1, '', '', true);


				// Loac Time Stamp for each action =======================================
				$SQL_load_timeStamp = "SELECT minor_order, button_name, timestamp FROM job_order_detail_trip_action_log WHERE trip_id = $trip_job_order_id AND plan_order = $trip_detail_plan_order AND complete_flag = 1 ORDER BY main_order, minor_order";
				$resTrip_log = $conn->query($SQL_load_timeStamp);
				while ($row3 = $resTrip_log->fetch_assoc()) {

					switch ($row3['minor_order']) {
						case '1':
							$timeStampX = 120.5;
							$timeStampY = 162.5 + ($cnt * 18);
							break;
						case '3':
							$timeStampX = 168.5;
							$timeStampY = 162.5 + ($cnt * 18);
							break;
						case '7':
							$timeStampX = 168.5;
							$timeStampY = 168.5 + ($cnt * 18);
							break;
						case '9':
							$timeStampX = 120.5;
							$timeStampY = 168.5 + ($cnt * 18);

							break;
						default:
							// NULL
					}

					$thai_date = date('j F', strtotime($row3['timestamp']));
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

					$formattedTime = date('H:i', strtotime($row3['timestamp']));
					$formattedDate = $thai_date . ' ' . $formattedTime . ' น.';
					//$formattedDate = $formattedTime . ' น.';

					$pdf->SetXY($timeStampX, $timeStampY); // กำหนดตำแหน่ง x = 50, y = 100 (หน่วยเป็น mm)
					$pdf->SetFont('thsarabunb', 'B', 15);
					$pdf->Cell(0, 10, $formattedDate, 0, 1, 'L', false, '', 0, false, 'T', 'C');
				}






				$cnt = $cnt + 1;
			}
		}


		// Generate QR Code
		$pdf->Rect(160, 5, 30, 30, 'F', '', array(255, 255, 255));
		$token_link = $SERVER_NAME . "tripDetail.php?r=" . $trip_random_code;
		$pdf->write2DBarcode($token_link, 'QRCODE,H', 160, 5, 30, 30, $style, 'N');
	}
} else {
	echo "ไม่พบข้อมูล";
}



mysqli_close($conn);









$export_file_name = "fileName.pdf";
if (isset($_GET['trip_id'])) {
	$export_file_name = $trip_tripNo . ".pdf";
} else {
	$export_file_name = $trip_job_no . ".pdf";
}




//Close and output PDF document
$pdf->Output($export_file_name, 'I');












//============================================================+
// END OF FILE
//============================================================+
