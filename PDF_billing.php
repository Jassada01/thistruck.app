<?php
require_once('assets/plugins/custom/TCPDF/examples/tcpdf_include.php');

function convertToThaiBaht($amount)
{
	$number = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
	$digit = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
	$amount = number_format($amount, 2, '.', '');
	$bahtText = '';
	list($integer, $satang) = explode('.', $amount);

	if ($integer == 0) {
		$bahtText = 'ศูนย์บาท';
	} else {
		$count = strlen($integer);
		for ($i = 0; $i < $count; $i++) {
			$number_str = substr($integer, $i, 1);
			if ($number_str != 0) {
				if ($number_str == 1 && $i == ($count - 1)) {
					$bahtText .= 'เอ็ด';
				} elseif ($number_str == 2 && $i == ($count - 2)) {
					$bahtText .= 'ยี่';
				} else {
					$bahtText .= $number[$number_str];
				}
				$bahtText .= $digit[$count - $i - 1];
			}
		}
		$bahtText .= 'บาท';
	}

	if ($satang == 0) {
		$bahtText .= 'ถ้วน';
	} else {
		if ($satang < 10) {
			$bahtText .= $number[$satang[1]] . 'สตางค์';
		} else {
			if ($satang[1] == 0) {
				$bahtText .= $number[$satang[0]] . 'สิบสตางค์';
			} else {
				$bahtText .= $number[$satang[0]] . 'สิบ' . $number[$satang[1]] . 'สตางค์';
			}
		}
	}
	return $bahtText;
}

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
	public $bgImage;
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
		if (!empty($this->bgImage)) {
			// Set the image as a page background
			$this->Image($this->bgImage, null, 0, 210, 297, '', '', '', false, 300, 'C', false, false, 0);
		}
		// restore auto-page-break status
		$this->setAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

$billingID = $_GET['billingID'];


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->SetAuthor('This Truck System');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Invoice');

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


// Page Setting 
$Max_line_per_page = 11;
$_fileName = "Billing";

mysqli_set_charset($conn, "utf8");

// Get Server Name 
$sql = "SELECT * FROM master_data WHERE type = 'server_name'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$SERVER_NAME = $row['value'];


// Read Data Header -----------------------------------------------------------------------------
$sql = "SELECT a.*, b.Attr1 AS paymentTerm FROM billing_header a Left Join client_info b ON a.clientID = b.ClientID WHERE id = $billingID";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	foreach ($row as $key => $value) {
		${"header_" . $key} = $value;
	}
} else {
	echo "0 results";
}

class documentStructure
{
	public $docType;
	public $docFontColor;
	public function __construct($docType, $docFontColor)
	{
		$this->docType = $docType;
		$this->docFontColor = $docFontColor;
	}
}
$doc1 = new documentStructure("(ต้นฉบับ)", [128, 128, 128]);
$doc2 = new documentStructure("(สำเนา)", [0, 128, 128]);
$documentArray = array($doc1, $doc2);



// Read Data Detail -----------------------------------------------------------------------------


foreach ($documentArray as $maindocument) {
	// echo "Document Type: " . $document->docType . ", Font Color: " . $document->docFontColor . "<br>";
	$sql = "SELECT * FROM billing_detail WHERE billing_header_id = $billingID";
	$result = $conn->query($sql);

	$mainDocumentType = $maindocument->docType;

	$current_item_ID = 0;
	$current_page = 0;
	$rowcount = mysqli_num_rows($result);
	$total_page = ceil($rowcount / $Max_line_per_page);
	$lastPage_flag = false;

	$DetailFontSize = 15;

	$printDetail_X = 20;
	$printDetail_Y = 65;

	while ($row = $result->fetch_assoc()) {
		$current_item_ID += 1;
		// echo $current_item_ID;
		// Max_line_per_page
		if ((fmod($current_item_ID, $Max_line_per_page) == 0) or ($current_item_ID == 1)) {
			$current_page += 1;
			//echo $current_page."-".$total_page."<BR>";
			if ($current_page == $total_page) {
				$pdf->bgImage = 'assets/media/pdf_template/Billing_LastPage.jpg';
				$lastPage_flag = true;
			} else {
				$pdf->bgImage = 'assets/media/pdf_template/Billing_midPage.jpg';
			}

			$printDetail_X = 20;
			$printDetail_Y = 65;
			$pdf->AddPage(); // This page will use background image 1

			// Add Header========================================
			$pdf->SetXY(180, 3);
			$pdf->SetFont('thsarabunb', 'B', 15);
			$pdf->Cell(20, 10, "หน้า " . $current_page . "/" . $total_page, 0, 1, 'R', false, '', 0, false, 'T', 'L');

			if ($mainDocumentType == "(ต้นฉบับ)") {
				$pdf->SetTextColor(0, 128, 128);
			} else {
				$pdf->SetTextColor(120, 120, 120);
			}
			$pdf->SetXY(155, 3);
			$pdf->SetFont('thsarabunb', 'B', 17);
			$pdf->Cell(20, 10, $mainDocumentType, 0, 1, 'L', false, '', 0, false, 'T', 'L');
			$pdf->SetTextColor(0, 0, 0);

			$pdf->SetXY(30, 28.5);
			$pdf->SetFont('thsarabunb', 'B', 12);
			$pdf->Cell(150, 0, $header_client_name, 0, 1, 'L', false, '', 0, false, 'T', 'L');

			$pdf->SetXY(30, 33);
			$pdf->SetFont('thsarabunb', 'R', 13);
			//$pdf->Cell(0, 10, $BillingAddress, 0, 1, 'L', false, '', 0, false, 'T', 'C');
			$pdf->MultiCell(125, 30, $header_billing_address, 0, 'L', false, 1, '', '', true);


			$pdf->SetXY(165, 25.5);
			$pdf->SetFont('thsarabunb', 'B', 16);
			$pdf->Cell(0, 10, $header_billing_no, 0, 1, 'L', false, '', 0, false, 'T', 'C');


			$thai_date = date('d F Y', strtotime($header_billing_date));
			$formatDocumentDate = str_replace(
				['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
				$thai_date
			);


			$pdf->SetXY(165, 30.5);
			$pdf->SetFont('thsarabunb', 'B', 15);
			$pdf->Cell(0, 10, $formatDocumentDate, 0, 1, 'L', false, '', 0, false, 'T', 'C');


			$pdf->SetXY(165, 35.5);
			$pdf->SetFont('thsarabunb', 'B', 15);
			$pdf->Cell(0, 10, $header_paymentTerm . " วัน", 0, 1, 'L', false, '', 0, false, 'T', 'C');

			$thai_date = date('d F Y', strtotime($header_due_date));
			$formatDuedate = str_replace(
				['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
				$thai_date
			);


			$pdf->SetXY(165, 39.5);
			$pdf->SetFont('thsarabunb', 'B', 15);
			$pdf->Cell(0, 10, $formatDuedate, 0, 1, 'L', false, '', 0, false, 'T', 'C');

			$pdf->SetXY(165, 44);
			$pdf->SetFont('thsarabunb', 'B', 15);
			$pdf->Cell(0, 10, $header_ref, 0, 1, 'L', false, '', 0, false, 'T', 'C');

			$pdf->SetXY(46, 48);
			$pdf->SetFont('thsarabunb', 'B', 15);
			$pdf->Cell(0, 10, $header_tax_id . " (" . $header_branch . ")", 0, 1, 'L', false, '', 0, false, 'T', 'C');

			// Last Page contain
			if ($lastPage_flag) {
				// Total AMT
				$pdf->SetXY(135.5, 201);
				$pdf->SetTextColor(33, 97, 140);
				$pdf->SetFont('thsarabunb', 'B', 23);
				$pdf->Cell(50, 10, number_format($header_total_amount, 2) . " บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');

				$pdf->SetTextColor(0, 0, 0);

				//convertToThaiBaht
				// Total AMT
				$pdf->SetXY(35, 201.5);
				$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
				$pdf->Cell(50, 10, number_format($header_total_amount, 2) . " บาท", 0, 1, 'L', false, '', 0, false, 'T', 'C');

				// Total AMT Word
				$pdf->SetXY(20, 211);
				$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
				$pdf->Cell(50, 10, convertToThaiBaht($header_total_amount), 0, 1, 'L', false, '', 0, false, 'T', 'C');


				// Total WHT
				$pdf->SetXY(125, 211.5);
				$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
				$pdf->Cell(50, 10, number_format($header_wht_amt, 2) . " บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');

				// Total AMT - WHT
				$pdf->SetXY(125, 216.3);
				$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
				$pdf->Cell(50, 10, number_format($header_total_amount - $header_wht_amt, 2) . " บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');


				// $Remark
				$pdf->SetXY(25, 185);
				$pdf->SetFont('thsarabunb', 'R', 13);
				$pdf->MultiCell(125, 30, $header_remark, 0, 'L', false, 1, '', '', true);
			}
		}


		$invoice_no = $row['invoice_no'];
		$document_date = $row['document_date'];
		$due_date = $row['due_date'];
		$total_amount = $row['total_amount'];
		$grand_total_amount = $row['grand_total_amount'];
		$wht_amount = $row['wht_amount'];

		// Detail 
		$pdf->SetXY($printDetail_X, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $current_item_ID . ". ", 0, 1, 'L', false, '', 0, false, 'T', 'C');

		$pdf->SetXY($printDetail_X + 5, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $invoice_no, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// document_date
		$thai_date = date('j F y', strtotime($document_date));
		$formatDate = str_replace(
			['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			[
				'ม.ค.', // มกราคม
				'ก.พ.', // กุมภาพันธ์
				'มี.ค.', // มีนาคม
				'เม.ย.', // เมษายน
				'พ.ค.', // พฤษภาคม
				'มิ.ย.', // มิถุนายน
				'ก.ค.', // กรกฎาคม
				'ส.ค.', // สิงหาคม
				'ก.ย.', // กันยายน
				'ต.ค.', // ตุลาคม
				'พ.ย.', // พฤศจิกายน
				'ธ.ค.'  // ธันวาคม
			],
			$thai_date
		);
		$pdf->SetXY($printDetail_X + 35, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $formatDate, 0, 1, 'L', false, '', 0, false, 'T', 'C');


		// document_date
		if (trim($due_date) == "0000-00-00") {
			$formatDate = "-";
		} else {
			$thai_date = date('j F y', strtotime($due_date));
			$formatDate = str_replace(
				['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				[
					'ม.ค.', // มกราคม
					'ก.พ.', // กุมภาพันธ์
					'มี.ค.', // มีนาคม
					'เม.ย.', // เมษายน
					'พ.ค.', // พฤษภาคม
					'มิ.ย.', // มิถุนายน
					'ก.ค.', // กรกฎาคม
					'ส.ค.', // สิงหาคม
					'ก.ย.', // กันยายน
					'ต.ค.', // ตุลาคม
					'พ.ย.', // พฤศจิกายน
					'ธ.ค.'  // ธันวาคม
				],
				$thai_date
			);
		}

		$pdf->SetXY($printDetail_X + 60, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $formatDate, 0, 1, 'L', false, '', 0, false, 'T', 'C');

		$pdf->SetXY($printDetail_X + 60, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($total_amount, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		$pdf->SetXY($printDetail_X + 94.5, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($total_amount, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		$pdf->SetXY($printDetail_X + 110.5, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($wht_amount, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		// Echo 
		$printDetail_Y = $printDetail_Y + 9;
	}
}






mysqli_close($conn);


$export_file_name = "fileName.pdf";
if (isset($_GET['trip_id'])) {
	$export_file_name = $_fileName . ".pdf";
} else {
	$export_file_name = $_fileName . ".pdf";
}




//Close and output PDF document
$pdf->Output($export_file_name, 'I');












//============================================================+
// END OF FILE
//============================================================+
