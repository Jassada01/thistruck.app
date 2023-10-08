<?php
require_once('assets/plugins/custom/TCPDF/examples/tcpdf_include.php');

function convertToThaiBaht($amount) {
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
			if ($satang[1] == 0)
			{
				$bahtText .= $number[$satang[0]] . 'สิบสตางค์';
			}
			else
			{
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
		$img_file = 'assets/media/pdf_template/invoice.jpg';
		$this->Image($img_file, null, 0, 210, 297, '', '', '', false, 300, 'C', false, false, 0);
		// restore auto-page-break status
		$this->setAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

$invoiceID = $_GET['invoiceID'];


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

$_fileName = "Invoice";

mysqli_set_charset($conn, "utf8");

// Get Server Name 
$sql = "SELECT * FROM master_data WHERE type = 'server_name'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$SERVER_NAME = $row['value'];


// Load Header Info
$sql = "SELECT a.*, b.ClientName, b.Branch, b.BillingAddress, b.TaxID, b.Attr1 AS 'Payment' FROM invoice_header a 
Left Join client_info b ON a.customer_code = b.ClientCode
WHERE a.id = $invoiceID";

$result = $conn->query($sql);

$document_date = "";
$document_number = "";
$reference = "";
$invoiceStatus = "";
$created_by = "";
$ClientName = "";
$Branch = "";
$BillingAddress = "";
$TaxID = "";
$Payment = "";
$Duedate = "";
$formatDuedate = "";
$Remark = "";


if ($result->num_rows > 0) {
	// ดึงข้อมูลแถวแรก
	$row = $result->fetch_assoc();

	// ตัวแปรเก็บค่าข้อมูล
	$document_date = $row['document_date'];
	$document_number = $row['document_number'];
	$reference = $row['reference'];
	$invoiceStatus = $row['attr1'];
	$created_by = $row['created_by'];
	$ClientName = $row['ClientName'];
	$Branch = $row['Branch'];
	$BillingAddress = $row['BillingAddress'];
	$TaxID = $row['TaxID'];
	$Payment = $row['Payment'];
}


// ---------------------------------------------------------

// ...
$pdf->AddPage();


// 
$pdf->SetXY(165, 2);
$pdf->SetTextColor(0, 128, 128);
$pdf->SetFont('thsarabunb', 'B', 17);
$pdf->Cell(0, 10, "(ต้นฉบับ)", 0, 1, 'R', false, '', 0, false, 'T', 'L');


$pdf->SetTextColor(0, 0, 0);
// Invoice No.
$pdf->SetXY(162, 25);
$pdf->SetFont('thsarabunb', 'B', 20);
$pdf->Cell(0, 10, $document_number, 0, 1, 'L', false, '', 0, false, 'T', 'C');

$_fileName = $document_number;

// document_date
$thai_date = date('d F Y', strtotime($document_date));
$formatDocumentDate = str_replace(
	['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
	$thai_date
);
$pdf->SetXY(162, 30.5);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $formatDocumentDate, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// Payment
if ($Payment != "") {
	// แปลง string เป็น DateTime object
	$Duedate = new DateTime($document_date);
	// เพิ่มจำนวนวัน
	$paymentINT = intval($Payment);
	$Duedate->add(new DateInterval("P{$paymentINT}D"));
	//$thai_date = date('d F Y', $Duedate);
	$thai_date = $Duedate->format('d F Y');
	$formatDuedate = str_replace(
		['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
		$thai_date
	);

	$Payment = $Payment . " วัน";
} else {
	$Payment = "";
}



$pdf->SetXY(162, 35);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $Payment, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// Due Date 
$pdf->SetXY(162, 39.5);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $formatDuedate, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// reference
$pdf->SetXY(162, 47);
$pdf->SetFont('thsarabunb', 'B', 11);
//$pdf->Cell(0, 10, $reference, 0, 1, 'L', false, '', 0, false, 'T', 'C');
$pdf->MultiCell(50, 30, $reference, 0, 'L', false, 0.5, '', '', true);



// ClientName
$pdf->SetXY(30, 26);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $ClientName, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// BillingAddress
$pdf->SetXY(30, 33);
$pdf->SetFont('thsarabunb', 'R', 13);
//$pdf->Cell(0, 10, $BillingAddress, 0, 1, 'L', false, '', 0, false, 'T', 'C');
$pdf->MultiCell(125, 30, $BillingAddress, 0, 'L', false, 1, '', '', true);


// TaxID
$pdf->SetXY(46, 48.5);
$pdf->SetFont('thsarabunb', 'R', 13);
$pdf->Cell(0, 10, $TaxID . " (" . $Branch . ")", 0, 1, 'L', false, '', 0, false, 'T', 'C');


// Detail ===============================================================================
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
	a.id = $invoiceID 
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
	b.accounting_type DESC";


$result = $conn->query($sql);

$count_item = 1;
$DetailFontSize = 13;
$printDetail_X = 20;
$printDetail_Y = 61;

$sumAMT = 0;
$sumWHT = 0;

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {

		if ($Remark == "")
		{
			$Remark = $row['Remark'];
		}

		// Load Detail Data
		$description = $row['description'];
		$description_array = explode("\n", $description);

		$QTY = $row['QTY'];
		$unit_price = $row['unit_price'];
		$AMT = $row['AMT'];
		$withHoldingtax_percent = $row['withHoldingtax'];
		$WHT = 0;
		if ($withHoldingtax_percent != "0") {
			$WHT = number_format((intval($withHoldingtax_percent) / 100) * $AMT, 2);
			$sumWHT = $sumWHT + $WHT;
		} else {
			$WHT = "0.00";
		}

		$sumAMT = $sumAMT + floatval($AMT);

		// Description
		$pdf->SetXY($printDetail_X, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $count_item . ". ", 0, 1, 'L', false, '', 0, false, 'T', 'C');
		//$pdf->Cell(0, 10,count($description_array), 0, 1, 'L', false, '', 0, false, 'T', 'C');



		// Description
		$pdf->SetXY($printDetail_X + 5, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $description_array[0], 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// QTY
		$pdf->SetXY($printDetail_X + 49, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($QTY, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		// unit_price
		$pdf->SetXY($printDetail_X + 71, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($unit_price, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		// AMT
		$pdf->SetXY($printDetail_X + 95, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($AMT, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		// WHT
		$pdf->SetXY($printDetail_X + 110, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, $WHT, 0, 1, 'R', false, '', 0, false, 'T', 'C');

		if (count($description_array) > 1) {
			$cnt_each = 0;
			foreach ($description_array as $value) {
				// Description
				if (trim($value) != "" && $cnt_each != 0) {
					$printDetail_Y = $printDetail_Y + 5;
					$pdf->SetTextColor(125, 125, 125);
					$pdf->SetXY($printDetail_X + 5, $printDetail_Y);
					$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
					$pdf->Cell(0, 10, $value, 0, 1, 'L', false, '', 0, false, 'T', 'C');
				}
				$cnt_each = $cnt_each +1;
			}
		}
		$pdf->SetTextColor(0, 0, 0);


		$printDetail_Y = $printDetail_Y + 6;
		$count_item = $count_item + 1;


		# break;
	}
}


// Total AMT
$pdf->SetXY(135.5, 201);
$pdf->SetTextColor(33, 97, 140);
$pdf->SetFont('thsarabunb', 'B', 23);
$pdf->Cell(50, 10, number_format($sumAMT, 2)." บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');

$pdf->SetTextColor(0, 0, 0);

//convertToThaiBaht
// Total AMT
$pdf->SetXY(35, 201.5);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, number_format($sumAMT, 2)." บาท", 0, 1, 'L', false, '', 0, false, 'T', 'C');

// Total AMT Word
$pdf->SetXY(25, 211);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, convertToThaiBaht($sumAMT), 0, 1, 'L', false, '', 0, false, 'T', 'C');


// Total WHT
$pdf->SetXY(120, 211.5);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, number_format($sumWHT, 2)." บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');

// Total AMT - WHT
$pdf->SetXY(120, 216.5);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, number_format($sumAMT - $sumWHT, 2)." บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');


// $Remark
$pdf->SetXY(25, 185);
$pdf->SetFont('thsarabunb', 'R', 13);
//$pdf->Cell(0, 10, $BillingAddress, 0, 1, 'L', false, '', 0, false, 'T', 'C');
$pdf->MultiCell(125, 30, $Remark, 0, 'L', false, 1, '', '', true);


//$formatDocumentDate
$pdf->SetXY(0, 275);
$pdf->SetFont('thsarabunb', 'C', 13);
$pdf->Cell(50, 10,$formatDocumentDate, 0, 1, 'R', false, '', 0, false, 'T', 'C');

//$formatDocumentDate
$pdf->SetXY(47, 275);
$pdf->SetFont('thsarabunb', 'C', 13);
$pdf->Cell(50, 10,$formatDocumentDate, 0, 1, 'R', false, '', 0, false, 'T', 'C');





// ---------------------------------------------------------

// ...
$pdf->AddPage();

$pdf->SetXY(165, 2);
$pdf->SetTextColor(128, 128, 128);
$pdf->SetFont('thsarabunb', 'B', 17);
$pdf->Cell(0, 10, "(สำเนา)", 0, 1, 'R', false, '', 0, false, 'T', 'L');


$pdf->SetTextColor(0, 0, 0);
// Invoice No.
$pdf->SetXY(162, 25);
$pdf->SetFont('thsarabunb', 'B', 20);
$pdf->Cell(0, 10, $document_number, 0, 1, 'L', false, '', 0, false, 'T', 'C');


// document_date
$thai_date = date('d F Y', strtotime($document_date));
$formatDocumentDate = str_replace(
	['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
	$thai_date
);
$pdf->SetXY(162, 30.5);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $formatDocumentDate, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// Payment
if ($Payment != "") {
	// แปลง string เป็น DateTime object
	$Duedate = new DateTime($document_date);
	// เพิ่มจำนวนวัน
	$paymentINT = intval($Payment);
	$Duedate->add(new DateInterval("P{$paymentINT}D"));
	//$thai_date = date('d F Y', $Duedate);
	$thai_date = $Duedate->format('d F Y');
	$formatDuedate = str_replace(
		['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
		$thai_date
	);

	$Payment = $Payment . " วัน";
} else {
	$Payment = "";
}



$pdf->SetXY(162, 35);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $Payment, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// Due Date 
$pdf->SetXY(162, 39.5);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $formatDuedate, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// reference
$pdf->SetXY(162, 47);
$pdf->SetFont('thsarabunb', 'B', 11);
//$pdf->Cell(0, 10, $reference, 0, 1, 'L', false, '', 0, false, 'T', 'C');
$pdf->MultiCell(50, 30, $reference, 0, 'L', false, 0.5, '', '', true);



// ClientName
$pdf->SetXY(30, 26);
$pdf->SetFont('thsarabunb', 'B', 13);
$pdf->Cell(0, 10, $ClientName, 0, 1, 'L', false, '', 0, false, 'T', 'C');

// ClientName
$pdf->SetXY(30, 33);
$pdf->SetFont('thsarabunb', 'R', 13);
//$pdf->Cell(0, 10, $BillingAddress, 0, 1, 'L', false, '', 0, false, 'T', 'C');
$pdf->MultiCell(125, 30, $BillingAddress, 0, 'L', false, 1, '', '', true);


// TaxID
$pdf->SetXY(46, 48.5);
$pdf->SetFont('thsarabunb', 'R', 13);
$pdf->Cell(0, 10, $TaxID . " (" . $Branch . ")", 0, 1, 'L', false, '', 0, false, 'T', 'C');


// Detail ===============================================================================
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
	a.id = $invoiceID 
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
	b.accounting_type DESC";


$result = $conn->query($sql);

$count_item = 1;
$DetailFontSize = 13;
$printDetail_X = 20;
$printDetail_Y = 61;

$sumAMT = 0;
$sumWHT = 0;

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {

		if ($Remark == "")
		{
			$Remark = $row['Remark'];
		}

		// Load Detail Data
		$description = $row['description'];
		$description_array = explode("\n", $description);

		$QTY = $row['QTY'];
		$unit_price = $row['unit_price'];
		$AMT = $row['AMT'];
		$withHoldingtax_percent = $row['withHoldingtax'];
		$WHT = 0;
		if ($withHoldingtax_percent != "0") {
			$WHT = number_format((intval($withHoldingtax_percent) / 100) * $AMT, 2);
			$sumWHT = $sumWHT + $WHT;
		} else {
			$WHT = "0.00";
		}

		$sumAMT = $sumAMT + floatval($AMT);

		// Description
		$pdf->SetXY($printDetail_X, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $count_item . ". ", 0, 1, 'L', false, '', 0, false, 'T', 'C');
		//$pdf->Cell(0, 10,count($description_array), 0, 1, 'L', false, '', 0, false, 'T', 'C');



		// Description
		$pdf->SetXY($printDetail_X + 5, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(0, 10, $description_array[0], 0, 1, 'L', false, '', 0, false, 'T', 'C');

		// QTY
		$pdf->SetXY($printDetail_X + 49, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($QTY, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		// unit_price
		$pdf->SetXY($printDetail_X + 71, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($unit_price, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		// AMT
		$pdf->SetXY($printDetail_X + 95, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, number_format($AMT, 2), 0, 1, 'R', false, '', 0, false, 'T', 'C');

		// WHT
		$pdf->SetXY($printDetail_X + 110, $printDetail_Y);
		$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
		$pdf->Cell(50, 10, $WHT, 0, 1, 'R', false, '', 0, false, 'T', 'C');

		if (count($description_array) > 1) {
			$cnt_each = 0;
			foreach ($description_array as $value) {
				// Description
				if (trim($value) != "" && $cnt_each != 0) {
					$printDetail_Y = $printDetail_Y + 5;
					$pdf->SetTextColor(125, 125, 125);
					$pdf->SetXY($printDetail_X + 5, $printDetail_Y);
					$pdf->SetFont('thsarabunb', 'R', $DetailFontSize);
					$pdf->Cell(0, 10, $value, 0, 1, 'L', false, '', 0, false, 'T', 'C');
				}
				$cnt_each = $cnt_each +1;
			}
		}
		$pdf->SetTextColor(0, 0, 0);


		$printDetail_Y = $printDetail_Y + 6;
		$count_item = $count_item + 1;


		# break;
	}
}


// Total AMT
$pdf->SetXY(135.5, 201);
$pdf->SetTextColor(33, 97, 140);
$pdf->SetFont('thsarabunb', 'B', 23);
$pdf->Cell(50, 10, number_format($sumAMT, 2)." บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');

$pdf->SetTextColor(0, 0, 0);

//convertToThaiBaht
// Total AMT
$pdf->SetXY(35, 201.5);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, number_format($sumAMT, 2)." บาท", 0, 1, 'L', false, '', 0, false, 'T', 'C');

// Total AMT Word
$pdf->SetXY(25, 211);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, convertToThaiBaht($sumAMT), 0, 1, 'L', false, '', 0, false, 'T', 'C');


// Total WHT
$pdf->SetXY(120, 211.5);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, number_format($sumWHT, 2)." บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');

// Total AMT - WHT
$pdf->SetXY(120, 216.5);
$pdf->SetFont('thsarabunb', 'B', $DetailFontSize);
$pdf->Cell(50, 10, number_format($sumAMT - $sumWHT, 2)." บาท", 0, 1, 'R', false, '', 0, false, 'T', 'C');


// $Remark
$pdf->SetXY(25, 185);
$pdf->SetFont('thsarabunb', 'R', 13);
//$pdf->Cell(0, 10, $BillingAddress, 0, 1, 'L', false, '', 0, false, 'T', 'C');
$pdf->MultiCell(125, 30, $Remark, 0, 'L', false, 1, '', '', true);


//$formatDocumentDate
$pdf->SetXY(0, 275);
$pdf->SetFont('thsarabunb', 'C', 13);
$pdf->Cell(50, 10,$formatDocumentDate, 0, 1, 'R', false, '', 0, false, 'T', 'C');

//$formatDocumentDate
$pdf->SetXY(47, 275);
$pdf->SetFont('thsarabunb', 'C', 13);
$pdf->Cell(50, 10,$formatDocumentDate, 0, 1, 'R', false, '', 0, false, 'T', 'C');





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
