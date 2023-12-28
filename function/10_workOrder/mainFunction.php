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


// สร้างฟังก์ชันเพื่อสร้างส่วนของ JSON
function createActionBox($action, $color, $code, $link)
{
	return array(
		"type" => "box",
		"layout" => "horizontal",
		"contents" => array(
			array(
				"type" => "text",
				"text" => $action,
				"size" => "sm",
				"gravity" => "center",
				"wrap" => true,
				"flex" => 2,
				"align" => "end"
			),
			array(
				"type" => "box",
				"layout" => "vertical",
				"contents" => array(
					array(
						"type" => "filler"
					),
					array(
						"type" => "box",
						"layout" => "vertical",
						"contents" => array(),
						"width" => "12px",
						"height" => "12px",
						"borderWidth" => "2px",
						"borderColor" => $color,
						"cornerRadius" => "30px"
					),
					array(
						"type" => "filler"
					)
				),
				"flex" => 1,
				"alignItems" => "center"
			),
			array(
				"type" => "text",
				"text" => $code,
				"flex" => 4,
				"size" => "sm",
				"gravity" => "center",
				"action" => array(
					"type" => "uri",
					"label" => "action",
					"uri" => $link
				)
			)
		),
		"spacing" => "lg"
	);
}



function SendNoticeJobConfirm($userId, $accessToken, $message)
{



	//echo ($messages);

	$data = [
		'to' => $userId,
		'messages' => $message
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


	if ($result === false) {
		echo 'เกิดข้อผิดพลาดในการส่งข้อความ: ' . curl_error($ch);
	} else {
		echo 'ส่งข้อความและลิงก์ Line Message API สำเร็จ!';
	}
}

function SendNoticeJobConfirmforCustomerClient($userId, $accessToken, $textHeader, $message)
{
	$data = [
		'to' => $userId,
		'messages' => [
			[
				'type' => 'flex',
				'altText' => $textHeader,
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


function countValues($data)
{
	// นับจำนวนครั้งที่แต่ละค่าปรากฎใน array
	$counts = array_count_values($data);

	// สร้าง string สำหรับผลลัพธ์
	$result = "";

	// วนซ้ำผ่าน array ของจำนวนการนับ
	foreach ($counts as $value => $count) {
		// ถ้าไม่ใช่ค่าแรก, ใส่ comma ก่อน
		if ($result != "") {
			$result .= ", ";
		}
		// ต่อ string นี้ลงไปในผลลัพธ์
		$result .= $count . "x" . $value;
	}

	// return ผลลัพธ์
	return $result;
}

// Send Line Notify ==================
function sendLineNotify($LINE_TOKEN, $message)
{
	$message = "\n" . $message;
	$headers = [
		'Authorization: Bearer ' . $LINE_TOKEN,
		'Content-Type: application/x-www-form-urlencoded'
	];
	$data = ['message' => $message];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/notify');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

function generateMainMsgNoticeNewJob(
	$job_name,
	$job_no,
	$tripNo,
	$driver_name,
	$formattedJobDate,
	$formattedDate,
	$refDoc_Data,
	$jsonJobActionTimeLine,
	$fullAddress,
	$hdRemark,
	$link
) {
	$main_msg =  [
		[
			'type' => 'flex',
			'altText' => "มีงานใหม่เข้า",
			'contents' => [
				'type' => 'bubble',
				'header' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						0 => [
							'type' => 'text',
							'text' => ' ',
							'size' => 'md',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'end',
						],
						1 => [
							'type' => 'separator',
							'margin' => 'md',
							'color' => '#e6f2ff66',
						],
						2 => [
							'type' => 'text',
							'text' => $job_name,
							'size' => 'lg',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'start',
							'offsetBottom' => '20px',
							'offsetTop' => '10px',
						],
						3 => [
							'type' => 'box',
							'layout' => 'horizontal',
							'contents' => [
								0 => [
									'type' => 'text',
									'text' =>  $job_no,
									'color' => '#FFFFFF',
									'align' => 'start',
									'weight' => 'bold',
								],
								1 => [
									'type' => 'text',
									'text' =>  $tripNo,
									'color' => '#FFFFFF',
									'align' => 'end',
								],
							],
							'paddingTop' => 'sm',
							'offsetTop' => '15px',
						],
						4 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => [
								0 => [
									'type' => 'text',
									'text' =>  'มีงานเข้าใหม่',
									'color' => '#0367D3',
									'align' => 'center',
									'size' => 'md',
									'offsetTop' => '3px',
									'weight' => 'bold',
								],
							],
							'position' => 'absolute',
							'cornerRadius' => '15px',
							'backgroundColor' => '#FFFFFFAA',
							'offsetTop' => '10px',
							'offsetStart' => '10px',
							'height' => '30px',
							'width' => '120px',
						],
					],
					'backgroundColor' => '#0367D3',
					'paddingTop' => '20px',
				],
				'body' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						0 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'คนขับ ',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 1,
											'wrap' => true,
											'weight' => 'bold',
										],
										1 => [
											'type' => 'text',
											'text' => $driver_name,
											'flex' => 5,
											'size' => 'sm',
											'color' => '#666666',
											'wrap' => true,
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'baseline',
									'spacing' => 'sm',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'เริ่มงาน',
											'color' => '#000000',
											'flex' => 1,
											'size' => 'sm',
											'wrap' => true,
											'weight' => 'bold',
										],
										1 => [
											'type' => 'text',
											'text' => $formattedDate,
											'flex' => 5,
											'size' => 'sm',
											'wrap' => true,
											'color' => '#666666',
										],
									],
								],
								2 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => $refDoc_Data,
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
										],
									],
								],
								3 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'แผนปฏิบัติงาน',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
							],
						],
						1 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => $jsonJobActionTimeLine,
							'paddingTop' => 'xxl',
						],
						2 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'ที่อยู่ออกใบเสร็จ',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => $fullAddress,
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
										],
									],
								],
							],
						],
						3 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'หมายเหตุ',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
											'text' => !empty($hdRemark) ? $hdRemark : '-',
										],
									],
								],
							],
						],
					],
					'paddingTop' => 'xs',
				],
				'footer' => [
					'type' => 'box',
					'layout' => 'vertical',
					'spacing' => 'sm',
					'contents' => [
						0 => [
							'type' => 'button',
							'style' => 'primary',
							'height' => 'sm',
							'action' => [
								'type' => 'uri',
								'label' => 'รายละเอียด',
								'uri' => $link,
							],
							'adjustMode' => 'shrink-to-fit',
							'color' => '#0367D3',
							'margin' => 'none',
							'position' => 'relative',
						],
						1 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => [],
							'margin' => 'sm',
						],
					],
					'flex' => 0,
				],
			]
		]
	];

	return $main_msg;
}

//createMainMsgforCancelJob
function createMainMsgforCancelJob($job_name, $job_no, $tripNo, $formattedDate)
{
	$main_msg = [
		[
			'type' => 'flex',
			'altText' => "แจ้งยกเลิกงาน",
			'contents' => [
				'type' => 'bubble',
				'header' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						0 => [
							'type' => 'text',
							'text' => ' ',
							'size' => 'md',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'end',
						],
						1 => [
							'type' => 'separator',
							'margin' => 'md',
							'color' => '#ffccce66',
						],
						2 => [
							'type' => 'text',
							'text' => $job_name,
							'size' => 'lg',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'start',
							'offsetBottom' => '20px',
							'offsetTop' => '10px',
						],
						3 => [
							'type' => 'box',
							'layout' => 'horizontal',
							'contents' => [
								0 => [
									'type' => 'text',
									'text' =>  $job_no,
									'color' => '#FFFFFF',
									'align' => 'start',
									'weight' => 'bold',
								],
								1 => [
									'type' => 'text',
									'text' =>  $tripNo,
									'color' => '#FFFFFF',
									'align' => 'end',
								],
							],
							'paddingTop' => 'sm',
							'offsetTop' => '15px',
						],
						4 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => [
								0 => [
									'type' => 'text',
									'text' =>  'แจ้งยกเลิกงาน',
									'color' => '#FF3137',
									'align' => 'center',
									'size' => 'md',
									'offsetTop' => '3px',
									'weight' => 'bold',
								],
							],
							'position' => 'absolute',
							'cornerRadius' => '15px',
							'backgroundColor' => '#FFFFFFAA',
							'offsetTop' => '10px',
							'offsetStart' => '10px',
							'height' => '30px',
							'width' => '120px',
						],
					],
					'backgroundColor' => '#FF3137',
					'paddingTop' => '20px',
				],
				'body' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						[
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								[
									'type' => 'box',
									'layout' => 'baseline',
									'spacing' => 'sm',
									'contents' => [
										[
											'type' => 'text',
											'text' => 'เริ่มงานเดิม',
											'color' => '#000000',
											'flex' => 2,
											'size' => 'sm',
											'wrap' => true,
											'weight' => 'bold',
										],
										[
											'type' => 'text',
											'text' => $formattedDate,
											'flex' => 4,
											'size' => 'sm',
											'wrap' => true,
											'color' => '#666666',
										],
									],
								],
							],
						],
					],
					'paddingTop' => 'xs',
				],
			]
		]
	];

	return $main_msg;
}

function createMainMsgForCustomer($job_name, $formattedJobDate, $formattedDate, $refDoc_Data, $totalQTYDataText, $jsonJobActionTimeLine, $fullAddress, $hdRemark)
{
	$main_msgforCustomer =  [
		[
			'type' => 'flex',
			'altText' => "คอนเฟิร์มงาน",
			'contents' => [
				'type' => 'bubble',
				'header' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						0 => [
							'type' => 'text',
							'text' => ' ',
							'size' => 'md',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'end',
						],
						1 => [
							'type' => 'separator',
							'margin' => 'md',
							'color' => '#fdcee266',
						],
						2 => [
							'type' => 'text',
							'text' => $job_name,
							'size' => 'lg',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'start',
							'offsetBottom' => '20px',
							'offsetTop' => '10px',
						],
						3 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => [
								0 => [
									'type' => 'text',
									'text' =>  'คอนเฟิร์มงาน',
									'color' => '#F6358A',
									'align' => 'center',
									'size' => 'md',
									'offsetTop' => '1px',
									'weight' => 'bold',
								],
							],
							'position' => 'absolute',
							'cornerRadius' => '15px',
							'backgroundColor' => '#FFFFFFAA',
							'offsetTop' => '10px',
							'offsetStart' => '10px',
							'height' => '30px',
							'width' => '120px',
						],
					],
					'backgroundColor' => '#F6358A',
					'paddingTop' => '20px',
				],
				'body' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						0 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'spacing' => 'sm',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'เริ่มงาน',
											'color' => '#000000',
											'flex' => 1,
											'size' => 'sm',
											'wrap' => true,
											'weight' => 'bold',
										],
										1 => [
											'type' => 'text',
											'text' => $formattedDate,
											'flex' => 5,
											'size' => 'sm',
											'wrap' => true,
											'color' => '#666666',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => $refDoc_Data,
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
										],
									],
								],
								2 => [
									'type' => 'box',
									'layout' => 'baseline',
									'spacing' => 'sm',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'ขนาด',
											'color' => '#000000',
											'flex' => 1,
											'size' => 'sm',
											'wrap' => true,
											'weight' => 'bold',
										],
										1 => [
											'type' => 'text',
											'text' => $totalQTYDataText,
											'flex' => 5,
											'size' => 'sm',
											'wrap' => true,
											'color' => '#666666',
										],
									],
								],
								3 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'แผนปฏิบัติงาน',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
							],
						],
						1 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => $jsonJobActionTimeLine,
							'paddingTop' => 'xxl',
						],
						2 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'ที่อยู่ออกใบเสร็จ',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => $fullAddress,
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
										],
									],
								],
							],
						],
						3 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'หมายเหตุ',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
											'text' => !empty($hdRemark) ? $hdRemark : '-',
										],
									],
								],
							],
						],
					],
					'paddingTop' => 'xs',
				],
			]
		]
	];

	// Additional processing here if needed

	return $main_msgforCustomer;
}

function createMainMsgForSubcontract($job_name, $formattedJobDate, $formattedDate, $refDoc_Data, $totalQTYDataText, $jsonJobActionTimeLine, $fullAddress, $hdRemark, $jsonJoblist)
{
	$main_msgforsub =  [
		[
			'type' => 'flex',
			'altText' => "คอนเฟิร์มงานซับ",
			'contents' => [
				'type' => 'bubble',
				'header' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						0 => [
							'type' => 'text',
							'text' => ' ',
							'size' => 'md',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'end',
						],
						1 => [
							'type' => 'separator',
							'margin' => 'md',
							'color' => '#99ff9960',
						],
						2 => [
							'type' => 'text',
							'text' => $job_name,
							'size' => 'lg',
							'color' => '#FFFFFF',
							'wrap' => true,
							'weight' => 'bold',
							'style' => 'normal',
							'align' => 'start',
							'offsetBottom' => '20px',
							'offsetTop' => '10px',
						],
						3 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => [
								0 => [
									'type' => 'text',
									'text' =>  'คอนเฟิร์มงานซับ',
									'color' => '#00b300',
									'align' => 'center',
									'size' => 'md',
									'offsetTop' => '1px',
									'weight' => 'bold',
								],
							],
							'position' => 'absolute',
							'cornerRadius' => '15px',
							'backgroundColor' => '#FFFFFFAA',
							'offsetTop' => '10px',
							'offsetStart' => '10px',
							'height' => '30px',
							'width' => '120px',
						],
					],
					'backgroundColor' => '#00b300',
					'paddingTop' => '20px',
				],
				'body' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						0 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'เลขอ้างอิง',
											'color' => '#000000',
											'size' => 'sm',
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => $refDoc_Data,
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
										],
									],
								],
								2 => [
									'type' => 'box',
									'layout' => 'baseline',
									'spacing' => 'sm',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'ขนาด',
											'color' => '#000000',
											'flex' => 1,
											'size' => 'md',
											'wrap' => true,
											'weight' => 'bold',
										],
										1 => [
											'type' => 'text',
											'text' => $totalQTYDataText,
											'flex' => 5,
											'size' => 'md',
											'wrap' => true,
											'color' => '#000000',
										],
									],
								],
								3 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'แผนปฏิบัติงาน',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
							],
						],
						1 => [
							'type' => 'box',
							'layout' => 'vertical',
							'contents' => $jsonJobActionTimeLine,
							'paddingTop' => 'xxl',
						],
						2 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'ที่อยู่ออกใบเสร็จ',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => $fullAddress,
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
										],
									],
								],
							],
						],
						3 => [
							'type' => 'box',
							'layout' => 'vertical',
							'margin' => 'lg',
							'spacing' => 'sm',
							'contents' => [
								0 => [
									'type' => 'box',
									'layout' => 'baseline',
									'contents' => [
										0 => [
											'type' => 'text',
											'text' => 'หมายเหตุ',
											'size' => 'sm',
											'color' => '#000000',
											'flex' => 5,
											'wrap' => true,
											'weight' => 'bold',
										],
									],
								],
								1 => [
									'type' => 'box',
									'layout' => 'vertical',
									'contents' => [
										0 => [
											'type' => 'text',
											'color' => '#666666',
											'size' => 'sm',
											'wrap' => true,
											'text' => !empty($hdRemark) ? $hdRemark : '-',
										],
									],
								],
							],
						],
					],
					'paddingTop' => 'xs',
				],
				'footer' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => $jsonJoblist
				]
			]
		]
	];

	// Additional processing here if needed

	return $main_msgforsub;
}





// ======== Function ===========================================================================================================
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
	$Costremark = $_POST['jobDetailCostForm']['remark'];
	$expenses_1 = $_POST['jobDetailCostForm']['expenses_1'];
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
			$vehicle_expenses,
			$expenses_1
		]);

		$sql = "INSERT INTO job_order_detail_trip_cost (job_id, job_no, trip_id, hire_price, overtime_fee, port_charge, yard_charge, container_return, container_cleaning_repair, container_drop_lift, other_charge, deduction_note, total_expenses, wage_travel_cost, vehicle_expenses, insInvAdd1, insInvAdd2, insInvAdd3, expenses_1, remark)
			VALUES ('{$job_id}', '{$job_no}', '{$trip_id}', '{$hire_price_true}', '{$overtime_fee}', '{$port_charge}', '{$yard_charge}', '{$container_return}', '{$container_cleaning_repair}', '{$container_drop_lift}', '{$other_charge}', '{$deduction_note}', '{$total_expenses}', '{$wage_travel_cost}', '{$vehicle_expenses}', '$insInvAdd1', '$insInvAdd2', '$insInvAdd3', '{$expenses_1}', '$Costremark')";

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

		// Delete Action for ลานตู้ 
		//$sql = "DELETE FROM job_order_detail_trip_action_log WHERE id IN (SELECT a.id FROM job_order_detail_trip_action_log a
		//Inner Join job_order_detail_trip_list b ON a.trip_id = b.trip_id AND a.plan_order = b.plan_order
		//WHERE a.trip_id = $trip_id AND a.main_order = 3 AND a.minor_order NOT IN (1, 9) AND b.location_type like '%ลาน%')";
		/*
		$sql = "DELETE FROM job_order_detail_trip_action_log WHERE id IN (SELECT a.id FROM job_order_detail_trip_action_log a
		Inner Join job_order_detail_trip_list b ON a.trip_id = b.trip_id AND a.plan_order = b.plan_order
		WHERE a.trip_id = $trip_id AND a.main_order = 3 AND a.minor_order NOT IN (1, 9) AND (b.location_type like '%ลาน%' OR b.location_type like '%ท่าเรือ%'))"; // Add ท่าเรือ

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
		*/
	}

	// Delete Action for ลานตู้ and ท่าเรือ 
	$sql = "DELETE FROM job_order_detail_trip_action_log WHERE id IN (SELECT a.id FROM job_order_detail_trip_action_log a
	Inner Join job_order_detail_trip_list b ON a.trip_id = b.trip_id AND a.plan_order = b.plan_order
	WHERE a.job_id = $job_id AND a.main_order = 3 AND a.minor_order NOT IN (1, 9) AND (b.location_type like '%ลาน%' OR b.location_type like '%ท่าเรือ%'))"; // Add ท่าเรือ

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
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
	$data_Array['jobforSubContract'] = array();


	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Step 1 Load data from job_order_template_header
	//$sql = "SELECT * FROM job_order_header where id = $MAIN_JOB_ID";
	$sql = "SELECT a.*, b.Line_token AS ClientLine, c.line_token AS CsutomerLine FROM job_order_header a 
	Left join client_info b ON a.ClientID = b.ClientID
	left Join customers c ON a.customer_id = c.customer_id
	WHERE a.id = $MAIN_JOB_ID";

	$res = $conn->query(trim($sql));
	while ($row = $res->fetch_assoc()) {
		$refDoc_Data = "";

		$customerJobNo = $row['customer_job_no'];
		if (!empty($customerJobNo)) {
			$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "\n";
		}

		$booking = $row['booking'];
		if (!empty($booking)) {
			$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "\n";
		}

		$customerPoNo = $row['customer_po_no'];
		if (!empty($customerPoNo)) {
			$refDoc_Data .= "PO No.: " . $customerPoNo . "\n";
		}

		$billOfLading = $row['bill_of_lading'];
		if (!empty($billOfLading)) {
			$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "\n";
		}

		$customerInvoiceNo = $row['customer_invoice_no'];
		if (!empty($customerInvoiceNo)) {
			$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "\n";
		}

		$agent = $row['agent'];
		if (!empty($agent)) {
			$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "\n";
		}

		$goods = $row['goods'];
		if (!empty($goods)) {
			$refDoc_Data .= "ชื่อสินค้า: " . $goods . "\n";
		}

		$quantity = $row['quantity'];
		if (!empty($quantity)) {
			$refDoc_Data .= "QTY/No. of Package: " . $quantity . "\n";
		}
		$row['refDoc_Data'] = $refDoc_Data;
		$data_Array['jobHeader'][] = $row;
	}



	// Step 2 Load data from job_order_template_detail_cost
	//$sql = "SELECT * FROM job_order_detail_trip_info where job_id = $MAIN_JOB_ID";
	//$sql = "SELECT a.*, CONCAT(a.containerID, ' ', a.containerID2) AS container_code FROM job_order_detail_trip_info a where job_id = $MAIN_JOB_ID";
	//$sql = "SELECT a.*, b.contact_number AS Driver_Phone_no FROM job_order_detail_trip_info a 
	//Left join truck_driver_info b ON a.driver_id = b.driver_id
	//where a.job_id = $MAIN_JOB_ID";


	$sql = "SELECT 
	a.*, 
	b.contact_number AS Driver_Phone_no, 
	c.*, 
	d.* 
  FROM 
	job_order_detail_trip_info a 
	Left join truck_driver_info b ON a.driver_id = b.driver_id 
	LEFT JOIN (
	  SELECT 
		a.job_id, 
		a.trip_id, 
		a.stage AS NEXT_STAGE, 
		a.main_order AS NEXT_MAIN_ORDER, 
		a.minor_order AS NEXT_MINOR_ORDER, 
		b.location_name AS NEXT_LOCATION_NAME, 
		c.attr1 AS NEXT_ACTION 
	  FROM 
		job_order_detail_trip_action_log a 
		Left Join job_order_detail_trip_list b ON a.trip_list_id = b.id 
		Left Join master_data c ON c.type = 'job_characteristic' 
		AND b.job_characteristic_id = c.id 
	  Where 
		a.id IN (
		  SELECT 
			MIN(a.id) AS target_log_id 
		  FROM 
			job_order_detail_trip_action_log a 
		  Where 
			a.job_id = $MAIN_JOB_ID 
			AND a.complete_flag IS NULL 
		  Group By 
			a.trip_id
		)
	) c ON a.id = c.trip_id 
	LEFT JOIN (
	  SELECT 
		a.job_id, 
		a.trip_id, 
		a.stage AS CURRENT_STAGE, 
		a.main_order AS CURRENT_MAIN_ORDER, 
		a.minor_order AS CURRENT_MINOR_ORDER, 
		b.location_name AS CURRENT_LOCATION_NAME, 
		c.attr1 AS CURRENT_ACTION 
	  FROM 
		job_order_detail_trip_action_log a 
		Left Join job_order_detail_trip_list b ON a.trip_list_id = b.id 
		Left Join master_data c ON c.type = 'job_characteristic' 
		AND b.job_characteristic_id = c.id 
	  Where 
		a.id IN (
		  SELECT 
			MAX(a.id) AS target_log_id 
		  FROM 
			job_order_detail_trip_action_log a 
		  Where 
			a.job_id = $MAIN_JOB_ID 
			AND a.complete_flag IS NOT NULL 
		  Group By 
			a.trip_id
		)
	) d ON a.id = d.trip_id 
  where 
	a.job_id = $MAIN_JOB_ID";

	$res = $conn->query(trim($sql));
	$firstTrip_id = "";
	while ($row = $res->fetch_assoc()) {
		$row['container_show'] = "";
		if ($row['containerID2'] != "") {
			$row['container_show'] = $row['containerID'] . ", " . $row['containerID2'];
		} else {
			$row['container_show'] = $row['containerID'];
		}

		if ($firstTrip_id == "") {
			$firstTrip_id  = $row['id'];
		}

		$data_Array['JobDetailTrip'][] = $row;
	}
	// Get Trip Route  
	$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, a.map_url, b.attr1 AS JSC , b.attr2 AS Color
			FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			WHERE a.trip_id = $firstTrip_id Order By a.plan_order";
	$result3 = $conn->query($sql);
	$jobActionLog = "";


	while ($row3 = $result3->fetch_assoc()) {
		$location_code = $row3['location_code'];
		$map_url = $row3['map_url'];
		$JSC = $row3['JSC'];
		//$Color = $row3['Color'];
		$jobActionLog = $jobActionLog . "\n" . $JSC . " : " . $location_code;
	}

	$data_Array['jobActionLog'] = $jobActionLog;

	// 
	$sql = "Select a.driver_name, c.id, c.companyName, c.line_group_id From job_order_detail_trip_info a
	Left Join truck_driver_info b ON a.driver_id = b.driver_id
	Left Join subcontractcarcompanies c ON b.subContractCompany = c.id
	Where a.job_id = $MAIN_JOB_ID  AND c.id IS NOT NULL";
	$result4 = $conn->query($sql);

	while ($row = $result4->fetch_assoc()) {
		$data_Array['jobforSubContract'][] = $row;
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
	$truck_licenseNo = $_POST['truck_licenseNo'];

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
	$truck_id = $driverListForm['truckinJob'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับ update ข้อมูล
	$sql = "UPDATE job_order_detail_trip_info SET 
		driver_id = $truckDriver, 
		driver_name = '$driver_name', 
		truck_licenseNo = '$truck_licenseNo', 
		truck_id = '$truck_id', 
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
	$expenses_1 = $_POST['jobDetailCostForm']['expenses_1'];
	$costRemark = $_POST['jobDetailCostForm']['remark'];

	// เตรียมคำสั่ง SQL สำหรับอัพเดทข้อมูล
	$sql = "UPDATE job_order_detail_trip_cost 
        SET hire_price = '$hire_price', overtime_fee = '$overtime_fee', port_charge = '$port_charge', yard_charge = '$yard_charge', container_return = '$container_return', container_cleaning_repair = '$container_cleaning_repair', container_drop_lift = '$container_drop_lift', other_charge = '$other_charge', deduction_note = '$deduction_note', total_expenses = '$total_expenses', wage_travel_cost = '$wage_travel_cost', vehicle_expenses = '$vehicle_expenses', expenses_1 = '$expenses_1', insInvAdd1 = '$insInvAdd1', insInvAdd2 = '$insInvAdd2', insInvAdd3 = '$insInvAdd3', remark = '$costRemark'
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
				   b.job_note,
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
				   '' AS job_note,
				   '' AS location_id,
				   z.random_code
			FROM   jobattachedlog z
			WHERE  z.trip_id = $MAIN_trip_id) a
	ORDER  BY Coalesce(a.timestamp, '9999-12-31 23:59:59') ASC,
			  a.id";


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

	// Delete for ลานตู้ and ท่าเรือ
	$sql = "DELETE FROM job_order_detail_trip_action_log WHERE id IN (SELECT a.id FROM job_order_detail_trip_action_log a
	Inner Join job_order_detail_trip_list b ON a.trip_id = b.trip_id AND a.plan_order = b.plan_order
	WHERE a.job_id = $MAIN_JOB_ID AND a.main_order = 3 AND a.minor_order NOT IN (1, 9) AND (b.location_type like '%ลาน%' OR b.location_type like '%ท่าเรือ%'))"; // Add ท่าเรือ

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	// คำสั่ง SQL สำหรับหา job_order_detail_trip_info.id ที่มี job_id = MAIN_JOB_ID
	//$sql = "SELECT id FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID AND status = 'รอเจ้าหน้าที่ยืนยัน' and complete_flag IS NULL";
	/*
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
	*/


	// สร้างคำสั่ง SQL สำหรับดึงข้อมูล refDoc_Data
	$sql = "SELECT customer_job_no, booking, customer_po_no, bill_of_lading, customer_invoice_no, agent, goods, quantity
	FROM job_order_header where id = $MAIN_JOB_ID";

	$result = $conn->query($sql);

	$client_line_token = "";
	$customer_line_token = "";

	$refDoc_Data = " "; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
	$agent = "";
	if ($result->num_rows > 0) {
		// วนลูปผลลัพธ์ที่ได้จากฐานข้อมูล
		while ($row = $result->fetch_assoc()) {
			// ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
			$customerJobNo = $row['customer_job_no'];
			if (!empty($customerJobNo)) {
				$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "\n";
			}

			$booking = $row['booking'];
			if (!empty($booking)) {
				$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "\n";
			}

			$customerPoNo = $row['customer_po_no'];
			if (!empty($customerPoNo)) {
				$refDoc_Data .= "PO No.: " . $customerPoNo . "\n";
			}

			$billOfLading = $row['bill_of_lading'];
			if (!empty($billOfLading)) {
				$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "\n";
			}

			$customerInvoiceNo = $row['customer_invoice_no'];
			if (!empty($customerInvoiceNo)) {
				$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "\n";
			}

			$agent = $row['agent'];
			if (!empty($agent)) {
				$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "\n";
			}

			$goods = $row['goods'];
			if (!empty($goods)) {
				$refDoc_Data .= "ชื่อสินค้า: " . $goods . "\n";
			}

			$quantity = $row['quantity'];
			if (!empty($quantity)) {
				$refDoc_Data .= "QTY/No. of Package: " . $quantity . "\n";
			}
		}
	}
	/*
	$sql = "SELECT 
			a.id, 
			a.job_id,
			a.driver_name, 
			c.job_name, 
			a.job_no, 
			a.tripNo, 
			a.status, 
			a.random_code, 
			b.line_id,
			a.jobStartDateTime,
			a.containersize,
			d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
			c.remark
		FROM 
			job_order_detail_trip_info a 
			Inner Join job_order_header c ON a.job_id = c.id
			LEFT Join truck_driver_info b ON a.driver_id = b.driver_id 
			inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
		WHERE 
			a.job_id = $MAIN_JOB_ID
			AND a.status = 'รอเจ้าหน้าที่ยืนยัน' 
			and a.complete_flag IS NULL;";
*/

	$sql = "SELECT 
		a.id, 
		a.job_id,
		a.driver_name, 
		c.job_name, 
		a.job_no, 
		a.tripNo, 
		a.status, 
		a.random_code, 
		b.line_id,
		a.jobStartDateTime,
		a.containersize,
		d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
		c.remark,
		c.client_confirmed,
		e.Line_token AS client_line_token,
		f.line_token AS customer_line_token
	FROM 
		job_order_detail_trip_info a 
		Inner Join job_order_header c ON a.job_id = c.id
		LEFT Join truck_driver_info b ON a.driver_id = b.driver_id
		inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
		LEFT JOIN client_info e ON c.ClientID = e.ClientID
		LEFT JOIN customers f ON c.customer_id = f.customer_id
	WHERE 
		a.job_id = $MAIN_JOB_ID
		AND a.status = 'รอเจ้าหน้าที่ยืนยัน' 
		and a.complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	$totalQTYData = array();
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
			$containersize = $row['containersize'];
			$insInvAdd1 = $row['insInvAdd1'];
			$insInvAdd2 = $row['insInvAdd2'];
			$insInvAdd3 = $row['insInvAdd3'];
			$hdRemark = $row['remark'];
			$client_line_token = $row['client_line_token'];
			$customer_line_token = $row['customer_line_token'];
			$client_confirmed = $row['client_confirmed'];
			$progress = "";

			if (trim($containersize) == "") {
				$containersize = "ไม่ระบุ";
			}

			array_push($totalQTYData, $containersize);



			$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
			$result2 = $conn->query($sql);

			// ตรวจสอบผลลัพธ์การค้นหา
			if ($result2->num_rows > 0) {
				// แสดงผลลัพธ์และอัพเดทค่าในฐานข้อมูล
				while ($row2 = $result2->fetch_assoc()) {
					$progress = $row2['progress'];
					$id2 = $row2['id'];

					/* RELEASE HERE ===========================================================================*/
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
					//echo json_encode($row2);


				}
			} else {
				echo "0 results";
			}


			//$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, a.map_url, b.attr1 AS JSC , b.attr2 AS Color
			//FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			//WHERE a.trip_id = $id Order By a.plan_order";

			$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, c.map_url, b.attr1  AS JSC , c.latitude, c.longitude , b.attr2 AS Color, c.location_name
			FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			Left Join locations c ON a.location_id = c.location_id
			WHERE a.trip_id = $id  Order By a.plan_order";

			$result3 = $conn->query($sql);
			$jobActionLog = array();
			$jobActionLogtext = "";

			while ($row3 = $result3->fetch_assoc()) {
				$job_characteristic_id = $row3['job_characteristic_id'];
				$job_characteristic = $row3['job_characteristic'];
				$location_code = $row3['location_code'];
				$map_url = $row3['map_url'];
				$JSC = $row3['JSC'];
				$Color = $row3['Color'];
				$latitude = $row3['latitude'];
				$longitude = $row3['longitude'];
				$location_name = $row3['location_name'];

				// URL encode the place name
				$placeName = urlencode($location_name);



				// Generate the Google Maps link
				$googleMapsLink = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}&query_place_id={$placeName}";


				// สร้างคำสั่ง SQL สำหรับการค้นหา URL
				$sql4 = "SELECT rnd FROM shot_url WHERE url = '$map_url'";
				$result4 = $conn->query($sql4);
				// ตรวจสอบว่าพบ URL หรือไม่
				$rnd = "";
				if ($result4->num_rows > 0) {
					// พบ URL ในฐานข้อมูล
					$row = $result4->fetch_assoc();
					$rnd = $row["rnd"];
					echo "พบ URL และรหัส rnd: " . $rnd;
				} else {
					// ไม่พบ URL ในฐานข้อมูล
					// สร้างรหัส rnd แบบสุ่ม
					$rnd = bin2hex(random_bytes(16));

					// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล URL และ rnd
					$insert_sql = "INSERT INTO shot_url (rnd, url) VALUES ('$rnd', '$map_url')";

					if ($conn->query($insert_sql) === TRUE) {
						echo "เพิ่มข้อมูล URL และรหัส rnd สำเร็จ";
					} else {
						echo "การเพิ่มข้อมูลล้มเหลว: " . $conn->error;
					}
				}


				$map_msg_url = $SERVER_NAME . "sht.php?r=" . $rnd;

				/*

				echo "\n";
				echo "\n" . $row3['location_code'];
				echo "\n" . $row3['map_url'];
				echo "\n" . $row3['JSC'];
				echo "\n" . $row3['Color'];
				*/

				//$jobActionLog[] = array(
				//	"action" => $JSC,
				//	"color" => $Color,
				//	"code" => $location_code,
				//	"link" => $googleMapsLink
				//);

				$jobActionLog[] = array(
					"action" => $JSC,
					"color" => $Color,
					"code" => $location_code,
					"link" => $map_msg_url
				);
				$jobActionLogtext = $jobActionLogtext . "\n" . $JSC . " : " . $location_code;
			}

			// สร้าง Array สำหรับ JSON ที่เราต้องการสร้าง
			$jsonJobActionTimeLine = array();

			// วนลูปเพื่อสร้างส่วนของ JSON จากแต่ละองค์ประกอบใน $jobActionLog
			$idxjobActionLog = 0;
			foreach ($jobActionLog as $log) {
				$idxjobActionLog = $idxjobActionLog + 1;
				$jsonJobActionTimeLine[] = createActionBox($log['action'], $log['color'], $log['code'], $log['link']);

				//echo $idxjobActionLog < count($jobActionLog);
				if ($idxjobActionLog < count($jobActionLog)) {
					$jsonJobActionTimeLine[] = [
						'type' => 'box',
						'layout' => 'horizontal',
						'contents' => [
							0 => [
								'type' => 'box',
								'layout' => 'baseline',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
								],
								'flex' => 2,
							],
							1 => [
								'type' => 'box',
								'layout' => 'horizontal',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
									1 => [
										'type' => 'box',
										'layout' => 'vertical',
										'contents' => [],
										'width' => '2px',
										'backgroundColor' => '#B7B7B7',
									],
									2 => [
										'type' => 'filler',
									],
								],
								'flex' => 1,
							],
							2 => [
								'type' => 'box',
								'layout' => 'vertical',
								'contents' => [],
								'flex' => 4,
							],
						],
						'spacing' => 'lg',
						'height' => '30px',
					];
				}
			}

			// แปลง Array เป็น JSON
			//$jsonJobActionTimeLine = json_encode($jsonArray, JSON_PRETTY_PRINT);


			// Send Line Notification =======================================================
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
			$formattedJobDate = $thai_date;

			$fullAddress = " ";

			if (!empty($insInvAdd1)) {
				$fullAddress .= $insInvAdd1 . "\n";
			}

			if (!empty($insInvAdd2)) {
				// "\n" คือ การขึ้นบรรทัดใหม่
				$fullAddress .= $insInvAdd2 . "\n";
			}

			if (!empty($insInvAdd3)) {
				$fullAddress .= $insInvAdd3 . "\n";
			}

			// ลบบรรทัดว่างที่สุดท้ายออก
			$fullAddress = rtrim($fullAddress, "\n");

			$link = $SERVER_NAME . 'tripDetail.php?r=' . $random_code;


			//print_r($jsonJobActionTimeLine);

			$main_msg = generateMainMsgNoticeNewJob(
				$job_name,
				$job_no,
				$tripNo,
				$driver_name,
				$formattedJobDate,
				$formattedDate,
				$refDoc_Data,
				$jsonJobActionTimeLine,
				$fullAddress,
				$hdRemark,
				$link
			);



			//echo $message;
			// Send Line Notice to Driver 
			if (trim($User_line_id != "")) {

				SendNoticeJobConfirm($User_line_id, $Line_Token, $main_msg);
			}
		}


		/* RELEASE HERE ===========================================================================*/
		// Update Job Status 
		$sql = "UPDATE job_order_header set status = 'กำลังดำเนินการ', client_confirmed = 1, update_by = '$update_user' WHERE id = $MAIN_JOB_ID";
		//echo $sql;
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		$totalQTYDataText = countValues($totalQTYData);
		$main_msgforCustomer = createMainMsgForCustomer($job_name, $formattedJobDate, $formattedDate, $refDoc_Data, $totalQTYDataText, $jsonJobActionTimeLine, $fullAddress, $hdRemark);

		$messagefor_lineNotification = "คอนเฟิร์มงาน
$job_name
วันที่ : $formattedJobDate
เริ่มงาน : $formattedDate
เอกสารอ้างอิง : 
$refDoc_Data
ขนาด : $totalQTYDataText
=== แผนปฏิบัติงาน ===$jobActionLogtext

=== ที่อยู่ออกใบเสร็จ ===
$fullAddress
หมายเหตุ : 
$hdRemark";

		//echo $messagefor_lineNotification ;

		// Process after finished each trip =======================================
		if ($client_confirmed <> '1') {
			$prefix = "NOTIFY_";
			if (trim($client_line_token != "")) {

				//SendNoticeJobConfirmforCustomerClient($client_line_token, $Line_Token, 'คอนเฟิร์มงาน', $messageforClientandCustomer);

				if (substr($client_line_token, 0, strlen($prefix)) == $prefix) {
					$client_line_token = substr($client_line_token, strlen($prefix));
					sendLineNotify($client_line_token, $messagefor_lineNotification);
				} else {
					SendNoticeJobConfirm($client_line_token, $Line_Token, $main_msgforCustomer);
				}
			}

			if (trim($customer_line_token != "")) {

				//SendNoticeJobConfirmforCustomerClient($customer_line_token, $Line_Token, 'คอนเฟิร์มงาน', $messageforClientandCustomer);
				if (substr($customer_line_token, 0, strlen($prefix)) == $prefix) {
					$customer_line_token = substr($customer_line_token, strlen($prefix));
					sendLineNotify($customer_line_token, $messagefor_lineNotification);
				} else {
					SendNoticeJobConfirm($customer_line_token, $Line_Token, $main_msgforCustomer);
				}
			}
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
	$sql = "INSERT INTO jobattachedlog (trip_id, file_desc, random_code) VALUES ('$trip_id', '$file_desc', '$random_code')";

	echo $sql;

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

	// Get Line Token 
	$sql = "SELECT * FROM master_data WHERE type = 'system_value' AND name = 'Line Token'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$Line_Token = $row['value'];


	// คำสั่ง SQL สำหรับหา job_order_detail_trip_info.id ที่มี job_id = MAIN_JOB_ID
	//$sql = "SELECT id FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID and complete_flag IS NULL";
	$sql = "SELECT a.id, a.status, b.line_id FROM job_order_detail_trip_info a 
	Inner Join truck_driver_info b ON a.driver_id = b.driver_id
	WHERE a.job_id = $MAIN_JOB_ID and complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	if ($result->num_rows > 0) {
		// วนลูปแสดงผลลัพธ์
		while ($row = $result->fetch_assoc()) {
			// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
			$id = $row['id'];
			$line_id = trim($row['line_id']);
			$Job_status = trim($row['status']);
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

			// Send Line Notification if Line Exist 
			if (($line_id != "") && ($Job_status != "รอเจ้าหน้าที่ยืนยัน")) {

				// Get Job Info
				$sql = "SELECT a.job_no, a.tripNo, a.jobStartDateTime, b.job_name 
				FROM job_order_detail_trip_info a Inner Join job_order_header b ON a.job_id = b.id Where a.id = $id";
				$result3 = $conn->query($sql);
				$row = $result3->fetch_assoc();
				$job_no = $row['job_no'];
				$tripNo = $row['tripNo'];
				$jobStartDateTime = $row['jobStartDateTime'];
				$job_name = $row['job_name'];

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

				// Cancel Job Notification ==============================
				$main_msg = createMainMsgforCancelJob($job_name, $job_no, $tripNo, $formattedDate);

				SendNoticeJobConfirm($line_id, $Line_Token, $main_msg);
			}
		}
	}


	// Update Job Status 
	$sql = "UPDATE job_order_header set status = 'ยกเลิก', update_by = '$update_user' WHERE id = $MAIN_JOB_ID";
	//echo $sql;
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
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


// F=15
function updateTripRoute()
{


	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	$jobDetailPlan = $_POST['jobDetailPlan'];
	$job_id = $_POST['job_id'];
	$job_no = $_POST['job_no'];
	$trip_id = $_POST['trip_id'];
	$tripNo = $_POST['tripNo'];


	// Delete From job_order_detail_trip_list
	$sql = "DELETE FROM job_order_detail_trip_list WHERE job_id = $job_id AND trip_id = $trip_id";
	// ทำการ Delete ข้อมูล 
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	// Delete From job_order_detail_trip_action_log
	$sql = "DELETE FROM job_order_detail_trip_action_log WHERE job_id = $job_id AND trip_id = $trip_id";
	// ทำการ Delete ข้อมูล 
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}



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


	mysqli_close($conn);
}

// F=16
function updateTripRoute_onlyLocation()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}




	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL UPDATE
	$sql = "UPDATE job_order_detail_trip_list SET 
		location_id = '$location_id',
		branch = '$branch',
		showName = '$showName',
		job_note = '$job_note',
		unique_key = '$unique_key',
		location_code = '$location_code',
		location_name = '$location_name',
		customer_id = '$customer_id',
		address = '$address',
		map_url = '$map_url',
		latitude = '$latitude',
		longitude = '$longitude',
		location_type = '$location_type',
		active = '$active',
		customer_name = '$customer_name'
		WHERE job_id = '$job_id' AND trip_id = '$trip_id' AND plan_order = '$plan_order'";


	//echo $sql;

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	mysqli_close($conn);
}

// F=17
function loadTrip_DetailforViewIndex()
{
	//sleep(1);
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT * FROM job_order_detail_trip_info Where job_id = $job_id Order By tripSeq";

	$res = $conn->query(trim($sql));

	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
		$sql2 = "SELECT b.step_desc, a.map_url, c.location_code, c.location_name, b.complete_flag, b.plan_order FROM job_order_detail_trip_list a 
		Inner Join job_order_detail_trip_action_log b ON a.job_id = b.job_id AND a.trip_id = b.trip_id AND a.plan_order = b.plan_order
		AND b.main_order = 3 AND b.minor_order = 9
		Inner Join locations c ON a.location_id = c.location_id
		Where a.trip_id = " . $row['id'] . "
		Order By a.plan_order";

		$res2 = $conn->query(trim($sql2));
		$data_Array2 = array();
		while ($row2 = $res2->fetch_assoc()) {
			$data_Array2[] = $row2;
		}



		$row['trip_data'] =  $data_Array2;
		$data_Array[] = $row;
	}
	mysqli_close($conn);
	echo json_encode($data_Array);
}

// 
// F=18
function loadTripTimeLineOverAll()
{
	//sleep(1);
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "SELECT b.step_desc, a.map_url, c.location_code, c.location_name, b.complete_flag, b.plan_order FROM job_order_detail_trip_list a 
	Inner Join job_order_detail_trip_action_log b ON a.job_id = b.job_id AND a.trip_id = b.trip_id AND a.plan_order = b.plan_order
	AND b.main_order = 3 AND b.minor_order = 9
	Inner Join locations c ON a.location_id = c.location_id
	Where a.trip_id = $trip_id
	Order By a.plan_order";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}


// F=19
function confirmJobOnlyClient()
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


	// Delete for ลานตู้ and ท่าเรือ
	$sql = "DELETE FROM job_order_detail_trip_action_log WHERE id IN (SELECT a.id FROM job_order_detail_trip_action_log a
	Inner Join job_order_detail_trip_list b ON a.trip_id = b.trip_id AND a.plan_order = b.plan_order
	WHERE a.job_id = $MAIN_JOB_ID AND a.main_order = 3 AND a.minor_order NOT IN (1, 9) AND (b.location_type like '%ลาน%' OR b.location_type like '%ท่าเรือ%'))"; // Add ท่าเรือ

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	// สร้างคำสั่ง SQL สำหรับดึงข้อมูล refDoc_Data
	$sql = "SELECT customer_job_no, booking, customer_po_no, bill_of_lading, customer_invoice_no, agent, goods, quantity
	FROM job_order_header where id = $MAIN_JOB_ID";

	$result = $conn->query($sql);

	$client_line_token = "";
	$customer_line_token = "";

	$refDoc_Data = " "; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
	$agent = "";
	if ($result->num_rows > 0) {
		// วนลูปผลลัพธ์ที่ได้จากฐานข้อมูล
		while ($row = $result->fetch_assoc()) {
			// ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
			$customerJobNo = $row['customer_job_no'];
			if (!empty($customerJobNo)) {
				$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "\n";
			}

			$booking = $row['booking'];
			if (!empty($booking)) {
				$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "\n";
			}

			$customerPoNo = $row['customer_po_no'];
			if (!empty($customerPoNo)) {
				$refDoc_Data .= "PO No.: " . $customerPoNo . "\n";
			}

			$billOfLading = $row['bill_of_lading'];
			if (!empty($billOfLading)) {
				$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "\n";
			}

			$customerInvoiceNo = $row['customer_invoice_no'];
			if (!empty($customerInvoiceNo)) {
				$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "\n";
			}

			$agent = $row['agent'];
			if (!empty($agent)) {
				$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "\n";
			}

			$goods = $row['goods'];
			if (!empty($goods)) {
				$refDoc_Data .= "ชื่อสินค้า: " . $goods . "\n";
			}

			$quantity = $row['quantity'];
			if (!empty($quantity)) {
				$refDoc_Data .= "QTY/No. of Package: " . $quantity . "\n";
			}
		}
	}

	$sql = "SELECT 
		a.id, 
		a.job_id,
		a.driver_name, 
		c.job_name, 
		a.job_no, 
		a.tripNo, 
		a.status, 
		a.random_code, 
		b.line_id,
		a.jobStartDateTime,
		a.containersize,
		d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
		c.remark,
		e.Line_token AS client_line_token,
		f.line_token AS customer_line_token
	FROM 
		job_order_detail_trip_info a 
		Inner Join job_order_header c ON a.job_id = c.id
		LEFT Join truck_driver_info b ON a.driver_id = b.driver_id
		inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
		LEFT JOIN client_info e ON c.ClientID = e.ClientID
		LEFT JOIN customers f ON c.customer_id = f.customer_id
	WHERE 
		a.job_id = $MAIN_JOB_ID
		AND a.status = 'รอเจ้าหน้าที่ยืนยัน' 
		and a.complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	$totalQTYData = array();
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
			$containersize = $row['containersize'];
			$insInvAdd1 = $row['insInvAdd1'];
			$insInvAdd2 = $row['insInvAdd2'];
			$insInvAdd3 = $row['insInvAdd3'];
			$hdRemark = $row['remark'];
			$client_line_token = $row['client_line_token'];
			$customer_line_token = $row['customer_line_token'];
			$progress = "";

			if (trim($containersize) == "") {
				$containersize = "ไม่ระบุ";
			}

			array_push($totalQTYData, $containersize);



			$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
			$result2 = $conn->query($sql);

			// ตรวจสอบผลลัพธ์การค้นหา
			if ($result2->num_rows > 0) {
				// แสดงผลลัพธ์และอัพเดทค่าในฐานข้อมูล
				while ($row2 = $result2->fetch_assoc()) {
					$progress = $row2['progress'];
					$id2 = $row2['id'];
					/* RELEASE HERE ===========================================================================
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
					//echo json_encode($row2);
					*/
				}
			} else {
				echo "0 results";
			}


			//$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, a.map_url, b.attr1 AS JSC , b.attr2 AS Color
			//FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			//WHERE a.trip_id = $id Order By a.plan_order";

			$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, c.map_url, b.attr1  AS JSC , c.latitude, c.longitude , b.attr2 AS Color, c.location_name
			FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			Left Join locations c ON a.location_id = c.location_id
			WHERE a.trip_id = $id  Order By a.plan_order";

			$result3 = $conn->query($sql);
			$jobActionLog = array();
			$jobActionLogtext = "";

			while ($row3 = $result3->fetch_assoc()) {
				$job_characteristic_id = $row3['job_characteristic_id'];
				$job_characteristic = $row3['job_characteristic'];
				$location_code = $row3['location_code'];
				$map_url = $row3['map_url'];
				$JSC = $row3['JSC'];
				$Color = $row3['Color'];
				$latitude = $row3['latitude'];
				$longitude = $row3['longitude'];
				$location_name = $row3['location_name'];

				// URL encode the place name
				$placeName = urlencode($location_name);

				// Generate the Google Maps link
				$googleMapsLink = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}&query_place_id={$placeName}";

				// สร้างคำสั่ง SQL สำหรับการค้นหา URL
				$sql4 = "SELECT rnd FROM shot_url WHERE url = '$map_url'";
				$result4 = $conn->query($sql4);
				// ตรวจสอบว่าพบ URL หรือไม่
				$rnd = "";
				if ($result4->num_rows > 0) {
					// พบ URL ในฐานข้อมูล
					$row = $result4->fetch_assoc();
					$rnd = $row["rnd"];
					echo "พบ URL และรหัส rnd: " . $rnd;
				} else {
					// ไม่พบ URL ในฐานข้อมูล
					// สร้างรหัส rnd แบบสุ่ม
					$rnd = bin2hex(random_bytes(16));

					// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล URL และ rnd
					$insert_sql = "INSERT INTO shot_url (rnd, url) VALUES ('$rnd', '$map_url')";

					if ($conn->query($insert_sql) === TRUE) {
						echo "เพิ่มข้อมูล URL และรหัส rnd สำเร็จ";
					} else {
						echo "การเพิ่มข้อมูลล้มเหลว: " . $conn->error;
					}
				}


				$map_msg_url = $SERVER_NAME . "sht.php?r=" . $rnd;

				/*

				echo "\n";
				echo "\n" . $row3['location_code'];
				echo "\n" . $row3['map_url'];
				echo "\n" . $row3['JSC'];
				echo "\n" . $row3['Color'];
				*/

				//$jobActionLog[] = array(
				//	"action" => $JSC,
				//	"color" => $Color,
				//	"code" => $location_code,
				//	"link" => $googleMapsLink
				//);

				$jobActionLog[] = array(
					"action" => $JSC,
					"color" => $Color,
					"code" => $location_code,
					"link" => $map_msg_url
				);
				$jobActionLogtext = $jobActionLogtext . "\n" . $JSC . " : " . $location_code;
			}

			// สร้าง Array สำหรับ JSON ที่เราต้องการสร้าง
			$jsonJobActionTimeLine = array();

			// วนลูปเพื่อสร้างส่วนของ JSON จากแต่ละองค์ประกอบใน $jobActionLog
			$idxjobActionLog = 0;
			foreach ($jobActionLog as $log) {
				$idxjobActionLog = $idxjobActionLog + 1;
				$jsonJobActionTimeLine[] = createActionBox($log['action'], $log['color'], $log['code'], $log['link']);

				//echo $idxjobActionLog < count($jobActionLog);
				if ($idxjobActionLog < count($jobActionLog)) {
					$jsonJobActionTimeLine[] = [
						'type' => 'box',
						'layout' => 'horizontal',
						'contents' => [
							0 => [
								'type' => 'box',
								'layout' => 'baseline',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
								],
								'flex' => 2,
							],
							1 => [
								'type' => 'box',
								'layout' => 'horizontal',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
									1 => [
										'type' => 'box',
										'layout' => 'vertical',
										'contents' => [],
										'width' => '2px',
										'backgroundColor' => '#B7B7B7',
									],
									2 => [
										'type' => 'filler',
									],
								],
								'flex' => 1,
							],
							2 => [
								'type' => 'box',
								'layout' => 'vertical',
								'contents' => [],
								'flex' => 4,
							],
						],
						'spacing' => 'lg',
						'height' => '30px',
					];
				}
			}

			// แปลง Array เป็น JSON
			//$jsonJobActionTimeLine = json_encode($jsonArray, JSON_PRETTY_PRINT);


			// Send Line Notification =======================================================
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
			$formattedJobDate = $thai_date;

			$fullAddress = " ";

			if (!empty($insInvAdd1)) {
				$fullAddress .= $insInvAdd1 . "\n";
			}

			if (!empty($insInvAdd2)) {
				// "\n" คือ การขึ้นบรรทัดใหม่
				$fullAddress .= $insInvAdd2 . "\n";
			}

			if (!empty($insInvAdd3)) {
				$fullAddress .= $insInvAdd3 . "\n";
			}

			// ลบบรรทัดว่างที่สุดท้ายออก
			$fullAddress = rtrim($fullAddress, "\n");

			$link = $SERVER_NAME . 'tripDetail.php?r=' . $random_code;


			//print_r($jsonJobActionTimeLine);

			// Confirm Only Client
			/*
			$main_msg = generateMainMsgNoticeNewJob(
				$job_name,
				$job_no,
				$tripNo,
				$driver_name,
				$formattedJobDate,
				$formattedDate,
				$refDoc_Data,
				$jsonJobActionTimeLine,
				$fullAddress,
				$hdRemark,
				$link
			);
			*/



			//echo $message;
			// Send Line Notice to Driver 
			//if (trim($User_line_id != "")) {

			//	SendNoticeJobConfirm($User_line_id, $Line_Token, $main_msg);
			//}
		}


		/* RELEASE HERE ===========================================================================*/
		// Update Job Status 
		$sql = "UPDATE job_order_header set client_confirmed = 1, update_by = '$update_user' WHERE id = $MAIN_JOB_ID";
		//echo $sql;
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}

		$totalQTYDataText = countValues($totalQTYData);

		// Create MSG for Line Notification
		$main_msgforCustomer = createMainMsgForCustomer($job_name, $formattedJobDate, $formattedDate, $refDoc_Data, $totalQTYDataText, $jsonJobActionTimeLine, $fullAddress, $hdRemark);


		$messagefor_lineNotification = "คอนเฟิร์มงาน
$job_name
วันที่ : $formattedJobDate
เริ่มงาน : $formattedDate
เอกสารอ้างอิง : 
$refDoc_Data
ขนาด : $totalQTYDataText
=== แผนปฏิบัติงาน ===$jobActionLogtext

=== ที่อยู่ออกใบเสร็จ ===
$fullAddress
หมายเหตุ : 
$hdRemark";

		//echo $messagefor_lineNotification ;

		// Process after finished each trip =======================================
		$prefix = "NOTIFY_";
		if (trim($client_line_token != "")) {

			//SendNoticeJobConfirmforCustomerClient($client_line_token, $Line_Token, 'คอนเฟิร์มงาน', $messageforClientandCustomer);

			if (substr($client_line_token, 0, strlen($prefix)) == $prefix) {
				$client_line_token = substr($client_line_token, strlen($prefix));
				sendLineNotify($client_line_token, $messagefor_lineNotification);
			} else {
				SendNoticeJobConfirm($client_line_token, $Line_Token, $main_msgforCustomer);
			}
		}

		if (trim($customer_line_token != "")) {

			//SendNoticeJobConfirmforCustomerClient($customer_line_token, $Line_Token, 'คอนเฟิร์มงาน', $messageforClientandCustomer);
			if (substr($customer_line_token, 0, strlen($prefix)) == $prefix) {
				$customer_line_token = substr($customer_line_token, strlen($prefix));
				sendLineNotify($customer_line_token, $messagefor_lineNotification);
			} else {
				SendNoticeJobConfirm($customer_line_token, $Line_Token, $main_msgforCustomer);
			}
		}
	}

	mysqli_close($conn);
}

// F=20
function update_trip_status_set()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$MAIN_trip_id = $_POST['MAIN_trip_id'];
	$planOrder = $_POST['planOrder'];
	$update_user = $_POST['update_user'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
	//$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $MAIN_trip_id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
	$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $MAIN_trip_id AND minor_order = 9 AND plan_order = $planOrder  ORDER BY id ASC LIMIT 1";
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


			//$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = 1, timestamp = CURRENT_TIMESTAMP(), complete_user = '$update_user' WHERE id = $id2";

			$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = 1, timestamp = CURRENT_TIMESTAMP(), complete_user = '$update_user' WHERE id <= $id2 AND trip_id = $MAIN_trip_id and main_order = 3";
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

// F=21
function update_trip_status_CloseJob()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$MAIN_trip_id = $_POST['MAIN_trip_id'];
	$planOrder = $_POST['planOrder'];
	$update_user = $_POST['update_user'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
	//$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $MAIN_trip_id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
	$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $MAIN_trip_id AND minor_order = 1 AND main_order = 7  ORDER BY id ASC LIMIT 1";
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


			//$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = 1, timestamp = CURRENT_TIMESTAMP(), complete_user = '$update_user' WHERE id = $id2";

			$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = 1, timestamp = CURRENT_TIMESTAMP(), complete_user = '$update_user' WHERE id <= $id2 AND trip_id = $MAIN_trip_id AND timestamp IS NULL";
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

//load_jobDescforSelectCgangeLocation
// F=22
function load_jobDescforSelectCgangeLocation()
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
		b.attr1 AS JobDESC, 
		a.location_id ,  a.plan_order, a.job_note
	FROM 
		job_order_detail_trip_list a 
		Inner Join master_data b ON a.job_characteristic_id = b.id 
		AND b.type = 'job_characteristic' 
	Where 
		a.job_id = $job_id 
		AND a.trip_id = (
		SELECT 
			MIN(a.trip_id) 
		FROM 
			job_order_detail_trip_list a 
		Where 
			a.job_id = $job_id 
		Group By 
			a.job_id
		)";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}

// F=23
function updateTripRoute_onlyLocationAllTrip()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}




	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL UPDATE
	$sql = "UPDATE job_order_detail_trip_list SET 
		location_id = '$location_id',
		branch = '$branch',
		showName = '$showName',
		job_note = '$job_note',
		unique_key = '$unique_key',
		location_code = '$location_code',
		location_name = '$location_name',
		customer_id = '$customer_id',
		address = '$address',
		map_url = '$map_url',
		latitude = '$latitude',
		longitude = '$longitude',
		location_type = '$location_type',
		active = '$active',
		customer_name = '$customer_name'
		WHERE job_id = '$job_id' AND plan_order = '$plan_order'";


	//echo $sql;

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	mysqli_close($conn);
}


// F=24
function cancelTrip()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$MAIN_TRIP_ID = $_POST['MAIN_TRIP_ID'];
	$update_user = $_POST['update_user'];

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// คำสั่ง SQL สำหรับหา job_order_detail_trip_info.id ที่มี job_id = MAIN_JOB_ID
	//$sql = "SELECT id FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID and id = $MAIN_TRIP_ID and complete_flag IS NULL";
	$sql = "SELECT a.id, a.status, b.line_id FROM job_order_detail_trip_info a 
	Inner Join truck_driver_info b ON a.driver_id = b.driver_id
	WHERE a.job_id = $MAIN_JOB_ID and a.id = $MAIN_TRIP_ID and complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	if ($result->num_rows > 0) {
		// วนลูปแสดงผลลัพธ์
		while ($row = $result->fetch_assoc()) {
			// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
			$id = $row['id'];
			$line_id = trim($row['line_id']);
			$Job_status = trim($row['status']);
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


			// Send Line Notification if Line Exist 
			if (($line_id != "") && ($Job_status != "รอเจ้าหน้าที่ยืนยัน")) {
				// Get Line Token 
				$sql = "SELECT * FROM master_data WHERE type = 'system_value' AND name = 'Line Token'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$Line_Token = $row['value'];


				// Get Job Info
				$sql = "SELECT a.job_no, a.tripNo, a.jobStartDateTime, b.job_name 
				FROM job_order_detail_trip_info a Inner Join job_order_header b ON a.job_id = b.id Where a.id = $id";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$job_no = $row['job_no'];
				$tripNo = $row['tripNo'];
				$jobStartDateTime = $row['jobStartDateTime'];
				$job_name = $row['job_name'];

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

				$main_msg =  [
					[
						'type' => 'flex',
						'altText' => "แจ้งยกเลิกงาน",
						'contents' => [
							'type' => 'bubble',
							'header' => [
								'type' => 'box',
								'layout' => 'vertical',
								'contents' => [
									0 => [
										'type' => 'text',
										'text' => 'แจ้งยกเลิกงาน',
										'size' => 'md',
										'color' => '#FFFFFF',
										'wrap' => true,
										'weight' => 'bold',
										'style' => 'normal',
										'align' => 'end',
									],
									1 => [
										'type' => 'text',
										'text' => $job_name,
										'size' => 'lg',
										'color' => '#FFFFFF',
										'wrap' => true,
										'weight' => 'bold',
										'style' => 'normal',
										'align' => 'start',
									],
									2 => [
										'type' => 'box',
										'layout' => 'horizontal',
										'contents' => [
											0 => [
												'type' => 'text',
												'text' =>  $job_no,
												'color' => '#FFFFFF',
												'align' => 'start',
												'weight' => 'bold',
											],
											1 => [
												'type' => 'text',
												'text' =>  $tripNo,
												'color' => '#FFFFFF',
												'align' => 'end',
											],
										],
										'paddingTop' => 'sm',
									],
								],
								'backgroundColor' => '#FF3137',
								'paddingTop' => '20px',
							],
							'body' => [
								'type' => 'box',
								'layout' => 'vertical',
								'contents' => [
									0 => [
										'type' => 'box',
										'layout' => 'vertical',
										'margin' => 'lg',
										'spacing' => 'sm',
										'contents' => [
											0 => [
												'type' => 'box',
												'layout' => 'baseline',
												'spacing' => 'sm',
												'contents' => [
													0 => [
														'type' => 'text',
														'text' => 'เริ่มงานเดิม',
														'color' => '#aaaaaa',
														'flex' => 1,
														'size' => 'sm',
														'wrap' => true,
													],
													1 => [
														'type' => 'text',
														'text' => $formattedDate,
														'flex' => 5,
														'size' => 'sm',
														'wrap' => true,
														'color' => '#666666',
													],
												],
											],
										],
									],
								],
								'paddingTop' => 'xs',
							],
						]
					]
				];

				SendNoticeJobConfirm($line_id, $Line_Token, $main_msg);
			}
		}

		// Send notify if Line Exist
	}
	mysqli_close($conn);
}


// F=25
function confirmedChangeJobName()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}
	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL UPDATE
	$sql = "UPDATE job_order_header 
		SET job_name = '$MAIN_JobName'
		, job_type = '$MAIN_jobType'
		, job_template_id = '$MAIN_JobselectID'
		WHERE id = $job_id";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	mysqli_close($conn);
}


// F=26
function loadImageforSelect()
{
	//sleep(1);
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select 
				* 
			From 
				(
				SELECT 
					c.job_no, 
					c.tripNo, 
					c.driver_name, 
					b.thumbnail_path, 
					b.file_path, 
					a.date_time as create_date 
				FROM 
					jobattachedlog a 
					Inner Join attached_files b ON a.random_code = b.random_code 
					Inner Join job_order_detail_trip_info c ON a.trip_id = c.id 
				Where 
					c.job_id = $job_id 
				UNION ALL 
				SELECT 
					'Line' as job_no, 
					'Line' as tripNo, 
					IFNULL(
					b.driver_name, 'ไม่ระบุ'
					) AS driver_name, 
					a.path as thumbnail_path, 
					a.path as file_path, 
					a.create_date 
				FROM 
					line_attached_file a 
					Left Join truck_driver_info b ON a.user_id = b.line_id 
				WHERE 
					path IS NOT NULL 
					AND deleted_date IS NULL
				) z 
			Order By 
				z.create_date DESC
			";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}

	echo json_encode($data_Array);
}

// F=27
function confirmJobbyTrip()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$update_user = $_POST['update_user'];
	$selectTrip = $_POST['selectTrip'];

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

	// Delete for ลานตู้ and ท่าเรือ
	$sql = "DELETE FROM job_order_detail_trip_action_log WHERE id IN (SELECT a.id FROM job_order_detail_trip_action_log a
	Inner Join job_order_detail_trip_list b ON a.trip_id = b.trip_id AND a.plan_order = b.plan_order
	WHERE a.job_id = $MAIN_JOB_ID AND a.main_order = 3 AND a.minor_order NOT IN (1, 9) AND (b.location_type like '%ลาน%' OR b.location_type like '%ท่าเรือ%'))"; // Add ท่าเรือ

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	// คำสั่ง SQL สำหรับหา job_order_detail_trip_info.id ที่มี job_id = MAIN_JOB_ID
	//$sql = "SELECT id FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID AND status = 'รอเจ้าหน้าที่ยืนยัน' and complete_flag IS NULL";
	/*
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
	*/


	// สร้างคำสั่ง SQL สำหรับดึงข้อมูล refDoc_Data
	$sql = "SELECT customer_job_no, booking, customer_po_no, bill_of_lading, customer_invoice_no, agent, goods, quantity
	FROM job_order_header where id = $MAIN_JOB_ID";

	$result = $conn->query($sql);

	$client_line_token = "";
	$customer_line_token = "";

	$refDoc_Data = " "; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
	$agent = "";
	if ($result->num_rows > 0) {
		// วนลูปผลลัพธ์ที่ได้จากฐานข้อมูล
		while ($row = $result->fetch_assoc()) {
			// ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
			$customerJobNo = $row['customer_job_no'];
			if (!empty($customerJobNo)) {
				$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "\n";
			}

			$booking = $row['booking'];
			if (!empty($booking)) {
				$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "\n";
			}

			$customerPoNo = $row['customer_po_no'];
			if (!empty($customerPoNo)) {
				$refDoc_Data .= "PO No.: " . $customerPoNo . "\n";
			}

			$billOfLading = $row['bill_of_lading'];
			if (!empty($billOfLading)) {
				$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "\n";
			}

			$customerInvoiceNo = $row['customer_invoice_no'];
			if (!empty($customerInvoiceNo)) {
				$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "\n";
			}

			$agent = $row['agent'];
			if (!empty($agent)) {
				$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "\n";
			}

			$goods = $row['goods'];
			if (!empty($goods)) {
				$refDoc_Data .= "ชื่อสินค้า: " . $goods . "\n";
			}

			$quantity = $row['quantity'];
			if (!empty($quantity)) {
				$refDoc_Data .= "QTY/No. of Package: " . $quantity . "\n";
			}
		}
	}
	/*
	$sql = "SELECT 
			a.id, 
			a.job_id,
			a.driver_name, 
			c.job_name, 
			a.job_no, 
			a.tripNo, 
			a.status, 
			a.random_code, 
			b.line_id,
			a.jobStartDateTime,
			a.containersize,
			d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
			c.remark
		FROM 
			job_order_detail_trip_info a 
			Inner Join job_order_header c ON a.job_id = c.id
			LEFT Join truck_driver_info b ON a.driver_id = b.driver_id 
			inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
		WHERE 
			a.job_id = $MAIN_JOB_ID
			AND a.status = 'รอเจ้าหน้าที่ยืนยัน' 
			and a.complete_flag IS NULL;";
*/

	$sql = "SELECT 
		a.id, 
		a.job_id,
		a.driver_name, 
		c.job_name, 
		a.job_no, 
		a.tripNo, 
		a.status, 
		a.random_code, 
		b.line_id,
		a.jobStartDateTime,
		a.containersize,
		d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
		c.remark,
		c.client_confirmed,
		e.Line_token AS client_line_token,
		f.line_token AS customer_line_token
	FROM 
		job_order_detail_trip_info a 
		Inner Join job_order_header c ON a.job_id = c.id
		LEFT Join truck_driver_info b ON a.driver_id = b.driver_id
		inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
		LEFT JOIN client_info e ON c.ClientID = e.ClientID
		LEFT JOIN customers f ON c.customer_id = f.customer_id
	WHERE 
		a.job_id = $MAIN_JOB_ID
		AND a.status = 'รอเจ้าหน้าที่ยืนยัน'
		AND a.id IN ($selectTrip)
		and a.complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	$totalQTYData = array();
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
			$containersize = $row['containersize'];
			$insInvAdd1 = $row['insInvAdd1'];
			$insInvAdd2 = $row['insInvAdd2'];
			$insInvAdd3 = $row['insInvAdd3'];
			$hdRemark = $row['remark'];
			$client_line_token = $row['client_line_token'];
			$customer_line_token = $row['customer_line_token'];
			$client_confirmed = $row['client_confirmed'];
			$progress = "";

			if (trim($containersize) == "") {
				$containersize = "ไม่ระบุ";
			}

			array_push($totalQTYData, $containersize);



			$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
			$result2 = $conn->query($sql);

			// ตรวจสอบผลลัพธ์การค้นหา
			if ($result2->num_rows > 0) {
				// แสดงผลลัพธ์และอัพเดทค่าในฐานข้อมูล
				while ($row2 = $result2->fetch_assoc()) {
					$progress = $row2['progress'];
					$id2 = $row2['id'];

					/* RELEASE HERE ===========================================================================*/
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
					//echo json_encode($row2);


				}
			} else {
				echo "0 results";
			}


			//$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, a.map_url, b.attr1 AS JSC , b.attr2 AS Color
			//FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			//WHERE a.trip_id = $id Order By a.plan_order";

			$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, c.map_url, b.attr1  AS JSC , c.latitude, c.longitude , b.attr2 AS Color, c.location_name
			FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			Left Join locations c ON a.location_id = c.location_id
			WHERE a.trip_id = $id  Order By a.plan_order";

			$result3 = $conn->query($sql);
			$jobActionLog = array();
			$jobActionLogtext = "";

			while ($row3 = $result3->fetch_assoc()) {
				$job_characteristic_id = $row3['job_characteristic_id'];
				$job_characteristic = $row3['job_characteristic'];
				$location_code = $row3['location_code'];
				$map_url = $row3['map_url'];
				$JSC = $row3['JSC'];
				$Color = $row3['Color'];
				$latitude = $row3['latitude'];
				$longitude = $row3['longitude'];
				$location_name = $row3['location_name'];

				// URL encode the place name
				$placeName = urlencode($location_name);



				// Generate the Google Maps link
				$googleMapsLink = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}&query_place_id={$placeName}";


				// สร้างคำสั่ง SQL สำหรับการค้นหา URL
				$sql4 = "SELECT rnd FROM shot_url WHERE url = '$map_url'";
				$result4 = $conn->query($sql4);
				// ตรวจสอบว่าพบ URL หรือไม่
				$rnd = "";
				if ($result4->num_rows > 0) {
					// พบ URL ในฐานข้อมูล
					$row = $result4->fetch_assoc();
					$rnd = $row["rnd"];
					echo "พบ URL และรหัส rnd: " . $rnd;
				} else {
					// ไม่พบ URL ในฐานข้อมูล
					// สร้างรหัส rnd แบบสุ่ม
					$rnd = bin2hex(random_bytes(16));

					// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล URL และ rnd
					$insert_sql = "INSERT INTO shot_url (rnd, url) VALUES ('$rnd', '$map_url')";

					if ($conn->query($insert_sql) === TRUE) {
						echo "เพิ่มข้อมูล URL และรหัส rnd สำเร็จ";
					} else {
						echo "การเพิ่มข้อมูลล้มเหลว: " . $conn->error;
					}
				}


				$map_msg_url = $SERVER_NAME . "sht.php?r=" . $rnd;

				/*

				echo "\n";
				echo "\n" . $row3['location_code'];
				echo "\n" . $row3['map_url'];
				echo "\n" . $row3['JSC'];
				echo "\n" . $row3['Color'];
				*/

				//$jobActionLog[] = array(
				//	"action" => $JSC,
				//	"color" => $Color,
				//	"code" => $location_code,
				//	"link" => $googleMapsLink
				//);

				$jobActionLog[] = array(
					"action" => $JSC,
					"color" => $Color,
					"code" => $location_code,
					"link" => $map_msg_url
				);
				$jobActionLogtext = $jobActionLogtext . "\n" . $JSC . " : " . $location_code;
			}

			// สร้าง Array สำหรับ JSON ที่เราต้องการสร้าง
			$jsonJobActionTimeLine = array();

			// วนลูปเพื่อสร้างส่วนของ JSON จากแต่ละองค์ประกอบใน $jobActionLog
			$idxjobActionLog = 0;
			foreach ($jobActionLog as $log) {
				$idxjobActionLog = $idxjobActionLog + 1;
				$jsonJobActionTimeLine[] = createActionBox($log['action'], $log['color'], $log['code'], $log['link']);

				//echo $idxjobActionLog < count($jobActionLog);
				if ($idxjobActionLog < count($jobActionLog)) {
					$jsonJobActionTimeLine[] = [
						'type' => 'box',
						'layout' => 'horizontal',
						'contents' => [
							0 => [
								'type' => 'box',
								'layout' => 'baseline',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
								],
								'flex' => 2,
							],
							1 => [
								'type' => 'box',
								'layout' => 'horizontal',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
									1 => [
										'type' => 'box',
										'layout' => 'vertical',
										'contents' => [],
										'width' => '2px',
										'backgroundColor' => '#B7B7B7',
									],
									2 => [
										'type' => 'filler',
									],
								],
								'flex' => 1,
							],
							2 => [
								'type' => 'box',
								'layout' => 'vertical',
								'contents' => [],
								'flex' => 4,
							],
						],
						'spacing' => 'lg',
						'height' => '30px',
					];
				}
			}

			// แปลง Array เป็น JSON
			//$jsonJobActionTimeLine = json_encode($jsonArray, JSON_PRETTY_PRINT);


			// Send Line Notification =======================================================
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
			$formattedJobDate = $thai_date;

			$fullAddress = " ";

			if (!empty($insInvAdd1)) {
				$fullAddress .= $insInvAdd1 . "\n";
			}

			if (!empty($insInvAdd2)) {
				// "\n" คือ การขึ้นบรรทัดใหม่
				$fullAddress .= $insInvAdd2 . "\n";
			}

			if (!empty($insInvAdd3)) {
				$fullAddress .= $insInvAdd3 . "\n";
			}

			// ลบบรรทัดว่างที่สุดท้ายออก
			$fullAddress = rtrim($fullAddress, "\n");

			$link = $SERVER_NAME . 'tripDetail.php?r=' . $random_code;


			//print_r($jsonJobActionTimeLine);

			$main_msg = generateMainMsgNoticeNewJob(
				$job_name,
				$job_no,
				$tripNo,
				$driver_name,
				$formattedJobDate,
				$formattedDate,
				$refDoc_Data,
				$jsonJobActionTimeLine,
				$fullAddress,
				$hdRemark,
				$link
			);
			//echo $message;
			// Send Line Notice to Driver 
			if (trim($User_line_id != "")) {

				SendNoticeJobConfirm($User_line_id, $Line_Token, $main_msg);
			}
		}
	}

	mysqli_close($conn);
}


// F=28
function Change_Driver_Notify()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$MAIN_TRIP_ID  = $_POST['MAIN_trip_id'];
	$update_user = $_POST['update_user'];
	$selectTrip = $_POST['MAIN_trip_id'];
	$oldDriverID = $_POST['oldDriverID'];

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
	/*
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
	*/


	// สร้างคำสั่ง SQL สำหรับดึงข้อมูล refDoc_Data
	$sql = "SELECT customer_job_no, booking, customer_po_no, bill_of_lading, customer_invoice_no, agent, goods, quantity
	FROM job_order_header where id = $MAIN_JOB_ID";

	$result = $conn->query($sql);

	$client_line_token = "";
	$customer_line_token = "";

	$refDoc_Data = " "; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
	$agent = "";
	if ($result->num_rows > 0) {
		// วนลูปผลลัพธ์ที่ได้จากฐานข้อมูล
		while ($row = $result->fetch_assoc()) {
			// ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
			$customerJobNo = $row['customer_job_no'];
			if (!empty($customerJobNo)) {
				$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "\n";
			}

			$booking = $row['booking'];
			if (!empty($booking)) {
				$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "\n";
			}

			$customerPoNo = $row['customer_po_no'];
			if (!empty($customerPoNo)) {
				$refDoc_Data .= "PO No.: " . $customerPoNo . "\n";
			}

			$billOfLading = $row['bill_of_lading'];
			if (!empty($billOfLading)) {
				$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "\n";
			}

			$customerInvoiceNo = $row['customer_invoice_no'];
			if (!empty($customerInvoiceNo)) {
				$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "\n";
			}

			$agent = $row['agent'];
			if (!empty($agent)) {
				$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "\n";
			}

			$goods = $row['goods'];
			if (!empty($goods)) {
				$refDoc_Data .= "ชื่อสินค้า: " . $goods . "\n";
			}

			$quantity = $row['quantity'];
			if (!empty($quantity)) {
				$refDoc_Data .= "QTY/No. of Package: " . $quantity . "\n";
			}
		}
	}
	/*
	$sql = "SELECT 
			a.id, 
			a.job_id,
			a.driver_name, 
			c.job_name, 
			a.job_no, 
			a.tripNo, 
			a.status, 
			a.random_code, 
			b.line_id,
			a.jobStartDateTime,
			a.containersize,
			d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
			c.remark
		FROM 
			job_order_detail_trip_info a 
			Inner Join job_order_header c ON a.job_id = c.id
			LEFT Join truck_driver_info b ON a.driver_id = b.driver_id 
			inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
		WHERE 
			a.job_id = $MAIN_JOB_ID
			AND a.status = 'รอเจ้าหน้าที่ยืนยัน' 
			and a.complete_flag IS NULL;";
*/

	$sql = "SELECT 
		a.id, 
		a.job_id,
		a.driver_name, 
		c.job_name, 
		a.job_no, 
		a.tripNo, 
		a.status, 
		a.random_code, 
		b.line_id,
		a.jobStartDateTime,
		a.containersize,
		d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
		c.remark,
		c.client_confirmed,
		e.Line_token AS client_line_token,
		f.line_token AS customer_line_token
	FROM 
		job_order_detail_trip_info a 
		Inner Join job_order_header c ON a.job_id = c.id
		LEFT Join truck_driver_info b ON a.driver_id = b.driver_id
		inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
		LEFT JOIN client_info e ON c.ClientID = e.ClientID
		LEFT JOIN customers f ON c.customer_id = f.customer_id
	WHERE 
		a.job_id = $MAIN_JOB_ID
		AND a.id IN ($selectTrip)
		and a.complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	$totalQTYData = array();
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
			$containersize = $row['containersize'];
			$insInvAdd1 = $row['insInvAdd1'];
			$insInvAdd2 = $row['insInvAdd2'];
			$insInvAdd3 = $row['insInvAdd3'];
			$hdRemark = $row['remark'];
			$client_line_token = $row['client_line_token'];
			$customer_line_token = $row['customer_line_token'];
			$client_confirmed = $row['client_confirmed'];
			$progress = "";

			if (trim($containersize) == "") {
				$containersize = "ไม่ระบุ";
			}

			array_push($totalQTYData, $containersize);



			$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
			$result2 = $conn->query($sql);




			//$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, a.map_url, b.attr1 AS JSC , b.attr2 AS Color
			//FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			//WHERE a.trip_id = $id Order By a.plan_order";

			$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, c.map_url, b.attr1  AS JSC , c.latitude, c.longitude , b.attr2 AS Color, c.location_name
			FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			Left Join locations c ON a.location_id = c.location_id
			WHERE a.trip_id = $id  Order By a.plan_order";

			$result3 = $conn->query($sql);
			$jobActionLog = array();
			$jobActionLogtext = "";

			while ($row3 = $result3->fetch_assoc()) {
				$job_characteristic_id = $row3['job_characteristic_id'];
				$job_characteristic = $row3['job_characteristic'];
				$location_code = $row3['location_code'];
				$map_url = $row3['map_url'];
				$JSC = $row3['JSC'];
				$Color = $row3['Color'];
				$latitude = $row3['latitude'];
				$longitude = $row3['longitude'];
				$location_name = $row3['location_name'];

				// URL encode the place name
				$placeName = urlencode($location_name);



				// Generate the Google Maps link
				$googleMapsLink = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}&query_place_id={$placeName}";


				// สร้างคำสั่ง SQL สำหรับการค้นหา URL
				$sql4 = "SELECT rnd FROM shot_url WHERE url = '$map_url'";
				$result4 = $conn->query($sql4);
				// ตรวจสอบว่าพบ URL หรือไม่
				$rnd = "";
				if ($result4->num_rows > 0) {
					// พบ URL ในฐานข้อมูล
					$row = $result4->fetch_assoc();
					$rnd = $row["rnd"];
					echo "พบ URL และรหัส rnd: " . $rnd;
				} else {
					// ไม่พบ URL ในฐานข้อมูล
					// สร้างรหัส rnd แบบสุ่ม
					$rnd = bin2hex(random_bytes(16));

					// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล URL และ rnd
					$insert_sql = "INSERT INTO shot_url (rnd, url) VALUES ('$rnd', '$map_url')";

					if ($conn->query($insert_sql) === TRUE) {
						echo "เพิ่มข้อมูล URL และรหัส rnd สำเร็จ";
					} else {
						echo "การเพิ่มข้อมูลล้มเหลว: " . $conn->error;
					}
				}


				$map_msg_url = $SERVER_NAME . "sht.php?r=" . $rnd;

				/*

				echo "\n";
				echo "\n" . $row3['location_code'];
				echo "\n" . $row3['map_url'];
				echo "\n" . $row3['JSC'];
				echo "\n" . $row3['Color'];
				*/

				//$jobActionLog[] = array(
				//	"action" => $JSC,
				//	"color" => $Color,
				//	"code" => $location_code,
				//	"link" => $googleMapsLink
				//);

				$jobActionLog[] = array(
					"action" => $JSC,
					"color" => $Color,
					"code" => $location_code,
					"link" => $map_msg_url
				);
				$jobActionLogtext = $jobActionLogtext . "\n" . $JSC . " : " . $location_code;
			}

			// สร้าง Array สำหรับ JSON ที่เราต้องการสร้าง
			$jsonJobActionTimeLine = array();

			// วนลูปเพื่อสร้างส่วนของ JSON จากแต่ละองค์ประกอบใน $jobActionLog
			$idxjobActionLog = 0;
			foreach ($jobActionLog as $log) {
				$idxjobActionLog = $idxjobActionLog + 1;
				$jsonJobActionTimeLine[] = createActionBox($log['action'], $log['color'], $log['code'], $log['link']);

				//echo $idxjobActionLog < count($jobActionLog);
				if ($idxjobActionLog < count($jobActionLog)) {
					$jsonJobActionTimeLine[] = [
						'type' => 'box',
						'layout' => 'horizontal',
						'contents' => [
							0 => [
								'type' => 'box',
								'layout' => 'baseline',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
								],
								'flex' => 2,
							],
							1 => [
								'type' => 'box',
								'layout' => 'horizontal',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
									1 => [
										'type' => 'box',
										'layout' => 'vertical',
										'contents' => [],
										'width' => '2px',
										'backgroundColor' => '#B7B7B7',
									],
									2 => [
										'type' => 'filler',
									],
								],
								'flex' => 1,
							],
							2 => [
								'type' => 'box',
								'layout' => 'vertical',
								'contents' => [],
								'flex' => 4,
							],
						],
						'spacing' => 'lg',
						'height' => '30px',
					];
				}
			}

			// แปลง Array เป็น JSON
			//$jsonJobActionTimeLine = json_encode($jsonArray, JSON_PRETTY_PRINT);


			// Send Line Notification =======================================================
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
			$formattedJobDate = $thai_date;

			$fullAddress = " ";

			if (!empty($insInvAdd1)) {
				$fullAddress .= $insInvAdd1 . "\n";
			}

			if (!empty($insInvAdd2)) {
				// "\n" คือ การขึ้นบรรทัดใหม่
				$fullAddress .= $insInvAdd2 . "\n";
			}

			if (!empty($insInvAdd3)) {
				$fullAddress .= $insInvAdd3 . "\n";
			}

			// ลบบรรทัดว่างที่สุดท้ายออก
			$fullAddress = rtrim($fullAddress, "\n");

			$link = $SERVER_NAME . 'tripDetail.php?r=' . $random_code;


			//print_r($jsonJobActionTimeLine);
			// Switch Driver 
			$main_msg = generateMainMsgNoticeNewJob(
				$job_name,
				$job_no,
				$tripNo,
				$driver_name,
				$formattedJobDate,
				$formattedDate,
				$refDoc_Data,
				$jsonJobActionTimeLine,
				$fullAddress,
				$hdRemark,
				$link
			);
			//echo $message;
			// Send Line Notice to Driver 
			if (trim($User_line_id != "")) {

				SendNoticeJobConfirm($User_line_id, $Line_Token, $main_msg);
			}
		}
	}


	// Send CC Msg ==========================================================================================

	// คำสั่ง SQL สำหรับหา job_order_detail_trip_info.id ที่มี job_id = MAIN_JOB_ID
	//$sql = "SELECT id FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID and id = $MAIN_TRIP_ID and complete_flag IS NULL";

	$sql = "SELECT line_id FROM truck_driver_info Where driver_id = $oldDriverID";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$line_id = $row['line_id'];

	$sql = "SELECT a.id, a.status, b.line_id FROM job_order_detail_trip_info a 
	Inner Join truck_driver_info b ON a.driver_id = b.driver_id
	WHERE a.job_id = $MAIN_JOB_ID and a.id = $MAIN_TRIP_ID and complete_flag IS NULL";

	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	if ($result->num_rows > 0) {
		// วนลูปแสดงผลลัพธ์
		while ($row = $result->fetch_assoc()) {
			// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
			$id = $row['id'];
			// Get Old Line ID ===============================================

			$Job_status = trim($row['status']);

			// Send Line Notification if Line Exist 
			if (($line_id != "") && ($Job_status != "รอเจ้าหน้าที่ยืนยัน")) {
				// Get Job Info
				$sql = "SELECT a.job_no, a.tripNo, a.jobStartDateTime, b.job_name 
				FROM job_order_detail_trip_info a Inner Join job_order_header b ON a.job_id = b.id Where a.id = $id";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$job_no = $row['job_no'];
				$tripNo = $row['tripNo'];
				$jobStartDateTime = $row['jobStartDateTime'];
				$job_name = $row['job_name'];

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

				$main_msg = createMainMsgforCancelJob($job_name, $job_no, $tripNo, $formattedDate);

				SendNoticeJobConfirm($line_id, $Line_Token, $main_msg);
			}
		}

		// Send notify if Line Exist
	}
	mysqli_close($conn);
}

// F=29
function deleteAttachedImage()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}
	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL UPDATE
	$sql = "Delete From attached_files WHere random_code = '$random_code'";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}
	mysqli_close($conn);
}

// 30
function sendJobNoticetosub()
{
	// รับค่า MAIN_JOB_ID จาก Ajax
	$MAIN_JOB_ID = $_POST['MAIN_JOB_ID'];
	$subContractID = $_POST['subContractID'];
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


	// Delete for ลานตู้ and ท่าเรือ
	$sql = "DELETE FROM job_order_detail_trip_action_log WHERE id IN (SELECT a.id FROM job_order_detail_trip_action_log a
    Inner Join job_order_detail_trip_list b ON a.trip_id = b.trip_id AND a.plan_order = b.plan_order
    WHERE a.job_id = $MAIN_JOB_ID AND a.main_order = 3 AND a.minor_order NOT IN (1, 9) AND (b.location_type like '%ลาน%' OR b.location_type like '%ท่าเรือ%'))"; // Add ท่าเรือ

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	// สร้างคำสั่ง SQL สำหรับดึงข้อมูล refDoc_Data
	$sql = "SELECT customer_job_no, booking, customer_po_no, bill_of_lading, customer_invoice_no, agent, goods, quantity
    FROM job_order_header where id = $MAIN_JOB_ID";

	$result = $conn->query($sql);

	$client_line_token = "";
	$customer_line_token = "";

	$refDoc_Data = " "; // ตัวแปรสำหรับเก็บข้อมูลที่ต้องแสดง
	$agent = "";
	if ($result->num_rows > 0) {
		// วนลูปผลลัพธ์ที่ได้จากฐานข้อมูล
		while ($row = $result->fetch_assoc()) {
			// ตรวจสอบและเก็บข้อมูลที่ไม่ใช่ Null
			$customerJobNo = $row['customer_job_no'];
			if (!empty($customerJobNo)) {
				$refDoc_Data .= "Job NO ของลูกค้า: " . $customerJobNo . "\n";
			}

			$booking = $row['booking'];
			if (!empty($booking)) {
				$refDoc_Data .= "Booking (บุ๊กกิ้ง): " . $booking . "\n";
			}

			$customerPoNo = $row['customer_po_no'];
			if (!empty($customerPoNo)) {
				$refDoc_Data .= "PO No.: " . $customerPoNo . "\n";
			}

			$billOfLading = $row['bill_of_lading'];
			if (!empty($billOfLading)) {
				$refDoc_Data .= "B/L(ใบขน): " . $billOfLading . "\n";
			}

			$customerInvoiceNo = $row['customer_invoice_no'];
			if (!empty($customerInvoiceNo)) {
				$refDoc_Data .= "Invoice No.: " . $customerInvoiceNo . "\n";
			}

			$agent = $row['agent'];
			if (!empty($agent)) {
				$refDoc_Data .= "Agent(เอเย่นต์): " . $agent . "\n";
			}

			$goods = $row['goods'];
			if (!empty($goods)) {
				$refDoc_Data .= "ชื่อสินค้า: " . $goods . "\n";
			}

			$quantity = $row['quantity'];
			if (!empty($quantity)) {
				$refDoc_Data .= "QTY/No. of Package: " . $quantity . "\n";
			}
		}
		$refDoc_Data = rtrim($refDoc_Data, "\n");
	}
	/*
    $sql = "SELECT 
        a.id, 
        a.job_id,
        a.driver_name, 
        c.job_name, 
        a.job_no, 
        a.tripNo, 
        a.status, 
        a.random_code, 
        b.line_id,
        a.jobStartDateTime,
        a.containersize,
        d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
        c.remark,
        e.Line_token AS client_line_token,
        f.line_token AS customer_line_token
    FROM 
        job_order_detail_trip_info a 
        Inner Join job_order_header c ON a.job_id = c.id
        LEFT Join truck_driver_info b ON a.driver_id = b.driver_id
        inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
        LEFT JOIN client_info e ON c.ClientID = e.ClientID
        LEFT JOIN customers f ON c.customer_id = f.customer_id
    WHERE 
        a.job_id = $MAIN_JOB_ID
        AND a.status = 'รอเจ้าหน้าที่ยืนยัน' 
        and a.complete_flag IS NULL";

        */
	$sql = "SELECT 
        a.id, 
        a.job_id,
        a.driver_name, 
        c.job_name, 
        a.job_no, 
        a.tripNo, 
        a.status, 
        a.random_code, 
        b.line_id,
        a.jobStartDateTime,
        a.containersize,
        d.insInvAdd1, d.insInvAdd2, d.insInvAdd3,
        c.remark,
        e.Line_token AS client_line_token,
        f.line_token AS customer_line_token,
        g.line_group_id
        
    FROM 
        job_order_detail_trip_info a 
        Inner Join job_order_header c ON a.job_id = c.id
        LEFT Join truck_driver_info b ON a.driver_id = b.driver_id
        inner Join job_order_detail_trip_cost d ON a.id = d.trip_id AND a.job_id = d.job_id
        LEFT JOIN client_info e ON c.ClientID = e.ClientID
        LEFT JOIN customers f ON c.customer_id = f.customer_id
        LEFT JOIN subcontractcarcompanies g ON b.subContractCompany = g.id
    WHERE 
        a.job_id = $MAIN_JOB_ID
        AND g.id = $subContractID
		AND a.status <> 'ยกเลิก'";
	// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
	$result = $conn->query($sql);
	$progress = "";
	// ตรวจสอบผลลัพธ์การค้นหา
	$totalQTYData = array();
	$jsonJoblist = array();
	$tripCount = 0;
	if ($result->num_rows > 0) {
		// วนลูปแสดงผลลัพธ์
		$jsonJoblist[] = [
			'type' => 'text',
			'text' => 'รายการทริปในใบงาน',
			'size' => 'lg',
			'color' => '#000000',
			'weight' => 'bold',
		];
		$tripCount = 0;
		while ($row = $result->fetch_assoc()) {
			// ค้นหา job_order_detail_trip_action_log.id ที่มีค่าน้อยที่สุดที่มี complete_flag == NULL
			$tripCount = $tripCount + 1;
			$id = $row['id'];
			$driver_name = $row['driver_name'];
			$job_name = $row['job_name'];
			$job_no = $row['job_no'];
			$tripNo = $row['tripNo'];
			$status = $row['status'];
			$random_code = $row['random_code'];
			$jobStartDateTime = $row['jobStartDateTime'];
			$User_line_id = $row['line_id'];
			$containersize = $row['containersize'];
			$insInvAdd1 = $row['insInvAdd1'];
			$insInvAdd2 = $row['insInvAdd2'];
			$insInvAdd3 = $row['insInvAdd3'];
			$hdRemark = $row['remark'];
			$client_line_token = $row['client_line_token'];
			$customer_line_token = $row['customer_line_token'];
			$subcontractLineGroupID = $row['line_group_id'];
			$progress = "";

			if (trim($containersize) == "") {
				$containersize = "ไม่ระบุ";
			}

			array_push($totalQTYData, $containersize);



			$sql = "SELECT id, progress FROM job_order_detail_trip_action_log WHERE trip_id = $id AND complete_flag IS NULL ORDER BY id ASC LIMIT 1";
			$result2 = $conn->query($sql);

			// ตรวจสอบผลลัพธ์การค้นหา
			if ($result2->num_rows > 0) {
				// แสดงผลลัพธ์และอัพเดทค่าในฐานข้อมูล
				while ($row2 = $result2->fetch_assoc()) {
					$progress = $row2['progress'];
					$id2 = $row2['id'];
					/* RELEASE HERE ===========================================================================
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
                    //echo json_encode($row2);
                    */
				}
			} else {
				echo "0 results";
			}


			//$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, a.map_url, b.attr1 AS JSC , b.attr2 AS Color
			//FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
			//WHERE a.trip_id = $id Order By a.plan_order";

			$sql = "SELECT a.job_characteristic_id, a.job_characteristic, a.location_code, c.map_url, b.attr1  AS JSC , c.latitude, c.longitude , b.attr2 AS Color, c.location_name
            FROM job_order_detail_trip_list a Inner JOIN master_data b ON a.job_characteristic_id = b.id AND b.type = 'job_characteristic' 
            Left Join locations c ON a.location_id = c.location_id
            WHERE a.trip_id = $id  Order By a.plan_order";

			$result3 = $conn->query($sql);
			$jobActionLog = array();
			$jobActionLogtext = "";

			while ($row3 = $result3->fetch_assoc()) {
				$job_characteristic_id = $row3['job_characteristic_id'];
				$job_characteristic = $row3['job_characteristic'];
				$location_code = $row3['location_code'];
				$map_url = $row3['map_url'];
				$JSC = $row3['JSC'];
				$Color = $row3['Color'];
				$latitude = $row3['latitude'];
				$longitude = $row3['longitude'];
				$location_name = $row3['location_name'];

				// URL encode the place name
				$placeName = urlencode($location_name);

				// Generate the Google Maps link
				$googleMapsLink = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}&query_place_id={$placeName}";

				// สร้างคำสั่ง SQL สำหรับการค้นหา URL
				$sql4 = "SELECT rnd FROM shot_url WHERE url = '$map_url'";
				$result4 = $conn->query($sql4);
				// ตรวจสอบว่าพบ URL หรือไม่
				$rnd = "";
				if ($result4->num_rows > 0) {
					// พบ URL ในฐานข้อมูล
					$row = $result4->fetch_assoc();
					$rnd = $row["rnd"];
					echo "พบ URL และรหัส rnd: " . $rnd;
				} else {
					// ไม่พบ URL ในฐานข้อมูล
					// สร้างรหัส rnd แบบสุ่ม
					$rnd = bin2hex(random_bytes(16));

					// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล URL และ rnd
					$insert_sql = "INSERT INTO shot_url (rnd, url) VALUES ('$rnd', '$map_url')";

					if ($conn->query($insert_sql) === TRUE) {
						echo "เพิ่มข้อมูล URL และรหัส rnd สำเร็จ";
					} else {
						echo "การเพิ่มข้อมูลล้มเหลว: " . $conn->error;
					}
				}


				$map_msg_url = $SERVER_NAME . "sht.php?r=" . $rnd;


				$jobActionLog[] = array(
					"action" => $JSC,
					"color" => $Color,
					"code" => $location_code,
					"link" => $map_msg_url
				);
				$jobActionLogtext = $jobActionLogtext . "\n" . $JSC . " : " . $location_code;
			}

			// สร้าง Array สำหรับ JSON ที่เราต้องการสร้าง
			$jsonJobActionTimeLine = array();

			// วนลูปเพื่อสร้างส่วนของ JSON จากแต่ละองค์ประกอบใน $jobActionLog
			$idxjobActionLog = 0;
			foreach ($jobActionLog as $log) {
				$idxjobActionLog = $idxjobActionLog + 1;
				$jsonJobActionTimeLine[] = createActionBox($log['action'], $log['color'], $log['code'], $log['link']);

				//echo $idxjobActionLog < count($jobActionLog);
				if ($idxjobActionLog < count($jobActionLog)) {
					$jsonJobActionTimeLine[] = [
						'type' => 'box',
						'layout' => 'horizontal',
						'contents' => [
							0 => [
								'type' => 'box',
								'layout' => 'baseline',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
								],
								'flex' => 2,
							],
							1 => [
								'type' => 'box',
								'layout' => 'horizontal',
								'contents' => [
									0 => [
										'type' => 'filler',
									],
									1 => [
										'type' => 'box',
										'layout' => 'vertical',
										'contents' => [],
										'width' => '2px',
										'backgroundColor' => '#B7B7B7',
									],
									2 => [
										'type' => 'filler',
									],
								],
								'flex' => 1,
							],
							2 => [
								'type' => 'box',
								'layout' => 'vertical',
								'contents' => [],
								'flex' => 4,
							],
						],
						'spacing' => 'lg',
						'height' => '30px',
					];
				}
			}

			// แปลง Array เป็น JSON
			//$jsonJobActionTimeLine = json_encode($jsonArray, JSON_PRETTY_PRINT);


			// Send Line Notification =======================================================
			$thai_date = date('j F', strtotime($jobStartDateTime));
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
			$formattedDate = $thai_date . ' ' . $formattedTime . ' น.';
			$formattedJobDate = $thai_date;

			$fullAddress = " ";

			if (!empty($insInvAdd1)) {
				$fullAddress .= $insInvAdd1 . "\n";
			}

			if (!empty($insInvAdd2)) {
				// "\n" คือ การขึ้นบรรทัดใหม่
				$fullAddress .= $insInvAdd2 . "\n";
			}

			if (!empty($insInvAdd3)) {
				$fullAddress .= $insInvAdd3 . "\n";
			}

			// ลบบรรทัดว่างที่สุดท้ายออก
			$fullAddress = rtrim($fullAddress, "\n");

			$link = $SERVER_NAME . 'tripDetail.php?r=' . $random_code;


			//print_r($jsonJobActionTimeLine);

			// Confirm Only Client
			/*
            $main_msg = generateMainMsgNoticeNewJob(
                $job_name,
                $job_no,
                $tripNo,
                $driver_name,
                $formattedJobDate,
                $formattedDate,
                $refDoc_Data,
                $jsonJobActionTimeLine,
                $fullAddress,
                $hdRemark,
                $link
            );
            */



			//echo $message;
			// Send Line Notice to Driver 
			//if (trim($User_line_id != "")) {

			//  SendNoticeJobConfirm($User_line_id, $Line_Token, $main_msg);
			//}



			$jsonJoblist[] = [
				'type' => 'box',
				'layout' => 'baseline',
				'paddingTop' => 'lg',
				'contents' => [
					[
						'type' => 'text',
						'text' => $tripCount . ". " . $driver_name,
						'weight' => 'bold',
					],
					[
						'type' => 'text',
						'text' => $formattedDate,
						'align' => 'end',
						'color' => '#AAAAAA',
					],
				],
				'action' => [
					'type' => 'uri',
					'uri' => $link,
				]
			];
		}




		$totalQTYDataText = countValues($totalQTYData);

		// Create MSG for Line Notification
		$main_msgforCustomer = createMainMsgForSubcontract($job_name, $formattedJobDate, $formattedDate, $refDoc_Data, $totalQTYDataText, $jsonJobActionTimeLine, $fullAddress, $hdRemark, $jsonJoblist);


		$messagefor_lineNotification = "คอนเฟิร์มงาน
$job_name
วันที่ : $formattedJobDate
เริ่มงาน : $formattedDate
เอกสารอ้างอิง : 
$refDoc_Data
ขนาด : $totalQTYDataText
=== แผนปฏิบัติงาน ===$jobActionLogtext

=== ที่อยู่ออกใบเสร็จ ===
$fullAddress
หมายเหตุ : 
$hdRemark";

		//echo $messagefor_lineNotification ;

		// Process after finished each trip =======================================
		$prefix = "NOTIFY_";
		/*
        if (trim($client_line_token != "")) {

            //SendNoticeJobConfirmforCustomerClient($client_line_token, $Line_Token, 'คอนเฟิร์มงาน', $messageforClientandCustomer);

            if (substr($client_line_token, 0, strlen($prefix)) == $prefix) {
                $client_line_token = substr($client_line_token, strlen($prefix));
                sendLineNotify($client_line_token, $messagefor_lineNotification);
            } else {
                SendNoticeJobConfirm($client_line_token, $Line_Token, $main_msgforCustomer);
            }
        }

        if (trim($customer_line_token != "")) {

            //SendNoticeJobConfirmforCustomerClient($customer_line_token, $Line_Token, 'คอนเฟิร์มงาน', $messageforClientandCustomer);
            if (substr($customer_line_token, 0, strlen($prefix)) == $prefix) {
                $customer_line_token = substr($customer_line_token, strlen($prefix));
                sendLineNotify($customer_line_token, $messagefor_lineNotification);
            } else {
                SendNoticeJobConfirm($customer_line_token, $Line_Token, $main_msgforCustomer);
            }
        }
        */
		SendNoticeJobConfirm($subcontractLineGroupID, $Line_Token, $main_msgforCustomer);
	}

	$sql = "UPDATE job_order_header SET sub_confirmed = 1, update_by = '$update_user' WHERE id = $MAIN_JOB_ID";
	//echo $sql;
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	mysqli_close($conn);
}

// F=31
function addNewtriptoJob()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}
	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";
	$data_Array = array();


	// Get max Seq 
	$sql = "SELECT * FROM job_order_detail_trip_info WHERE job_id = $MAIN_JOB_ID AND tripSeq = (Select MAX(a.tripSeq) AS maxSEQ From job_order_detail_trip_info a Where a.job_id = $MAIN_JOB_ID)";
	$result = $conn->query(trim($sql));

	$row = $result->fetch_assoc();
	$maxSEQ = $row['tripSeq'];
	$job_no = $row['job_no'];
	$LasttripNo = $row['tripNo'];
	$LasttripID = $row['id'];
	$maxSEQ = $maxSEQ + 1;

	// Get Job Header 
	$sql = "SELECT * From job_order_header a Where a.id = $MAIN_JOB_ID";
	$result = $conn->query(trim($sql));
	$jobHeader = $result->fetch_assoc();
	$tripNo = getRunningNo('TripNo', 'T', $jobHeader['job_date']);

	// #1 : Create job_order_detail_trip_info ---------------------------------------------------------------------------------------
	$random_code = gen_rnd_str();
	$sql = "INSERT INTO job_order_detail_trip_info (job_id, job_no, tripNo, tripSeq, truck_id, truck_licenseNo, driver_id, driver_name, subcontrackCheckbox, containersize, containerID, seal_no, containerWeight, containerID2, containersize2, seal_no2, containerWeight2, truckType, jobStartDateTime, status, random_code, create_date, create_user, update_date, update_user) 
		VALUES ('$MAIN_JOB_ID', '$job_no', '$tripNo', '$maxSEQ', '$truckinJob', '$truck_licenseNo', '$truckDriver', '$truckDriverName', '$subcontrackCheckbox', '$containersize', '$containerID','$sealNo', '$containerWeight', '$containerID2', '$containersize2', '$sealNo2', '$containerWeight2',
		'$truckType', '$jobStartDateTime', 'รอเจ้าหน้าที่ยืนยัน', '$random_code', NOW(), '$update_user', NOW(), '$update_user')";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Get Job ID
	$trip_id  = mysqli_insert_id($conn);

	// Get 

	// Insert Trip job_order_detail_trip_list 
	$sql = "INSERT INTO job_order_detail_trip_list (job_id, job_no, trip_id, trip_no, job_order_template_header_id, location_id, plan_order, branch, showName, job_characteristic, job_characteristic_id, job_note, unique_key, cardColor, job_characteristicShow, create_datetime, location_code, location_name, customer_id, address, map_url, latitude, longitude, location_type, active, customer_name)
	SELECT job_id, job_no, $trip_id AS trip_id, '$tripNo' AS trip_no, job_order_template_header_id, location_id, plan_order, branch, showName, job_characteristic, job_characteristic_id, job_note, unique_key, cardColor, job_characteristicShow, create_datetime, location_code, location_name, customer_id, address, map_url, latitude, longitude, location_type, active, customer_name
	FROM job_order_detail_trip_list
	WHERE job_id = $MAIN_JOB_ID AND trip_no = '$LasttripNo'";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Insert Trip job_order_detail_trip_cost
	$sql = "INSERT INTO job_order_detail_trip_cost 
	(job_id, job_no, trip_id, hire_price, overtime_fee, port_charge, yard_charge, container_return, container_cleaning_repair, container_drop_lift, other_charge, deduction_note, total_expenses, wage_travel_cost, vehicle_expenses, expenses_1, expenses_2, expenses_3, insInvAdd1, insInvAdd2, insInvAdd3, remark)
	SELECT 
	job_id, job_no, $trip_id, hire_price, overtime_fee, port_charge, yard_charge, container_return, container_cleaning_repair, container_drop_lift, other_charge, deduction_note, total_expenses, wage_travel_cost, vehicle_expenses, expenses_1, expenses_2, expenses_3, insInvAdd1, insInvAdd2, insInvAdd3, remark
	FROM job_order_detail_trip_cost
	WHERE job_id = $MAIN_JOB_ID AND trip_id = $LasttripID";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	// Process Trip Action Log==========================
	$sql = "INSERT INTO job_order_detail_trip_action_log 
	(id, job_id, job_no, trip_id, trip_no, trip_list_id, main_order, minor_order, plan_order, step_desc, stage, button_name, progress)
	SELECT NULL, job_id, job_no, $trip_id as trip_id, trip_no, trip_list_id, main_order, minor_order, plan_order, step_desc, stage, button_name, progress
	FROM job_order_detail_trip_action_log
	WHERE job_id = $MAIN_JOB_ID AND trip_id = $LasttripID";

	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}

	if ($jobHeader['status'] == 'กำลังดำเนินการ') {
		// Update job_order_detail_trip_info
		$sql = "UPDATE job_order_detail_trip_info SET status = 'เจ้าหน้าที่ยืนยันแล้ว' Where id = $trip_id";
		
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
		
		// Update Log
		$sql = "UPDATE job_order_detail_trip_action_log SET complete_flag = 1, timestamp = CURRENT_TIMESTAMP, complete_user = '$update_user'
		WHERE trip_id = $trip_id AND main_order = 1 AND minor_order = 1";
		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
		
	}


	mysqli_close($conn);
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
	case 15: {
			updateTripRoute();
			break;
		}
	case 16: {
			updateTripRoute_onlyLocation();
			break;
		}
	case 17: {
			loadTrip_DetailforViewIndex();
			break;
		}
	case 18: {
			loadTripTimeLineOverAll();
			break;
		}
	case 19: {
			confirmJobOnlyClient();
			break;
		}
	case 20: {
			update_trip_status_set();
			break;
		}
	case 21: {
			update_trip_status_CloseJob();
			break;
		}
	case 22: {
			load_jobDescforSelectCgangeLocation();
			break;
		}
	case 23: {
			updateTripRoute_onlyLocationAllTrip();
			break;
		}
	case 24: {
			cancelTrip();
			break;
		}
	case 25: {
			confirmedChangeJobName();
			break;
		}
	case 26: {
			loadImageforSelect();
			break;
		}
	case 27: {
			confirmJobbyTrip();
			break;
		}
	case 28: {
			Change_Driver_Notify();
			break;
		}
	case 29: {
			deleteAttachedImage();
			break;
		}
	case 30: {
			sendJobNoticetosub();
			break;
		}
	case 31: {
			addNewtriptoJob();
			break;
		}
}
