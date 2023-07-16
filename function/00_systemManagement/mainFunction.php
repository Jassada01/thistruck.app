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

// Send Line Notify Image ==================
function sendImageToLineNotify($imageUrl, $lineNotifyToken)
{
	// อ่านรูปภาพจาก URL
	$imageContent = file_get_contents($imageUrl);

	// สร้าง multipart/form-data สำหรับส่งไปยัง Line Notify
	$postData = array(
		'message' => 'ส่งรูปภาพ',
		'imageFile' => new CURLFile($imageUrl, 'image/jpeg', 'image.jpg')
	);

	// กำหนด HTTP header สำหรับการส่ง multipart/form-data
	$header = array(
		'Authorization: Bearer ' . $lineNotifyToken
	);

	// ส่งรูปภาพไปยัง Line Notify
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/notify');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	curl_close($ch);

	// ตรวจสอบผลลัพธ์
	if ($result === false) {
		echo 'เกิดข้อผิดพลาดในการส่งรูปภาพผ่าน Line Notify: ' . curl_error($ch);
	} else {
		echo 'ส่งรูปภาพผ่าน Line Notify เรียบร้อยแล้ว';
	}
}




// ======== Function ========
// F=1
function createNewUser()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL Insert ข้อมูล
	$sql = "INSERT INTO users (user_id , password , name , position_name , email , line_id , picture , user_level )
	VALUES ('$user_id', '$password', '$name', '$position_name', '$email', '$line_id', '$picture', $user_level)";

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


// F=2
function LoadUserInfobyID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select * From users where id = '$USER_ID'";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}


// F=3
function updateUserInfoByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับการอัพเดตข้อมูลในตาราง users
	$sql = "UPDATE users SET name='$name', position_name='$position_name', email='$email', line_id='$line_id', picture='$picture', user_level='$user_level', active='$active' WHERE id=$USER_ID";


	//echo $sql;
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	// Close connection
	mysqli_close($conn);
}



// F=4
function updateUserpasswordByID()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับการอัพเดตข้อมูลในตาราง users
	$sql = "Update users SET password='$password' Where id = $USER_ID";


	//echo $sql;
	//$result = $conn->query($sql);
	if (!$conn->query($sql)) {
		echo  $conn->errno;
		exit();
	}


	// Close connection
	mysqli_close($conn);
}

// F=5
function commonInsertDataToAttachedTable()
{
	// Load All Data from Paramitor
	//foreach ($_POST as $key => $value) {
	//	$a = htmlspecialchars($key);
	//	$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	//}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	$MAINfileUploadOjb = json_decode($_POST['fileUploadOjb'], true);



	foreach ($MAINfileUploadOjb as $file) {
		// Get values from the JSON object
		$document_group = $conn->real_escape_string($file['document_group']);
		$document_group_code = $conn->real_escape_string($file['document_group_code']);
		$file_path = $conn->real_escape_string($file['file_path']);
		$document_type = $conn->real_escape_string($file['document_type']);
		$description = $conn->real_escape_string($file['description']);
		$file_type = $conn->real_escape_string($file['file_type']);
		$isImage = intval($file['isImage']);
		$thumbnail_path = $conn->real_escape_string($file['thumbnail_path']);
		$random_code = $conn->real_escape_string($file['random_code']);
		$originalFileName = $conn->real_escape_string($file['originalFileName']);

		// Insert the data into the attached_files table
		$sql = "INSERT INTO attached_files (document_group, document_group_code, originalFileName, file_path, document_type, description, file_type, isImage, thumbnail_path, random_code)
				VALUES ('$document_group', '$document_group_code', '$originalFileName', '$file_path', '$document_type', '$description', '$file_type', $isImage, '$thumbnail_path', '$random_code')";

		if (!$conn->query($sql)) {
			echo  $conn->errno;
			exit();
		}
	}

	// Close connection
	mysqli_close($conn);
}

// F=6
function loadAttachedData()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// สร้างคำสั่ง SQL สำหรับอัพเดตข้อมูล
	$sql = "Select * From attached_files a Where document_group = '$DOCUMENT_GROUP' AND document_group_code = '$DOCUMENT_GROUP_CODE' order by id DESC";

	$res = $conn->query(trim($sql));
	mysqli_close($conn);
	$data_Array = array();

	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	echo json_encode($data_Array);
}

// F=7
function testSendLine()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	$sql = "SELECT * FROM master_data WHERE type = 'system_value' AND name = 'Line Token'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$Line_Token = $row['value'];
	mysqli_close($conn);


	$accessToken = $Line_Token;
	$userId = $line_id; // เปลี่ยนเป็น User ID ของผู้รับข้อความ

	$message = 'ข้อความทดสอบจากระบบ'; // เปลี่ยนเป็นข้อความที่ต้องการส่ง

	$url = 'https://api.line.me/v2/bot/message/push';

	$data = [
		'to' => $userId,
		'messages' => [
			[
				'type' => 'text',
				'text' => $message
			]
		]
	];

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

	// เช็คผลลัพธ์
	if ($result === false) {
		echo 'เกิดข้อผิดพลาดในการส่งข้อความ: ' . curl_error($ch);
	} else {
		echo 'ส่งข้อความ Line Message API สำเร็จ!';
	}
}


// F=8
function sendLineMSG()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}




	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Line_Token
	$sql = "SELECT * FROM master_data WHERE type = 'system_value' AND name = 'Line Token'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$Line_Token = $row['value'];

	// Server Name 
	$sql = "SELECT * FROM master_data WHERE type = 'server_name'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$server_name = $row['value'];


	mysqli_close($conn);


	$accessToken = $Line_Token;
	$userId = $line_id; // เปลี่ยนเป็น User ID ของผู้รับข้อความ
	$link = $server_name . $link;


	$data = [
		'to' => $userId,
		'messages' => [
			[
				'type' => 'flex',
				'altText' => 'ข้อความจากเจ้าหน้าที่',
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


	//if ($result === false) {
	//	echo 'เกิดข้อผิดพลาดในการส่งข้อความ: ' . curl_error($ch);
	//} else {
	//	echo 'ส่งข้อความและลิงก์ Line Message API สำเร็จ!';
	//}
}







// F=9
function sendLineMSGtoCliandCus()
{
	// Load All Data from Paramitor
	foreach ($_POST as $key => $value) {
		$a = htmlspecialchars($key);
		$$a = preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value))));
	}

	// เชื่อมต่อฐานข้อมูล MySQL
	include "../connectionDb.php";

	// Line_Token
	$sql = "SELECT * FROM master_data WHERE type = 'system_value' AND name = 'Line Token'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$Line_Token = $row['value'];

	// Server Name 
	$sql = "SELECT * FROM master_data WHERE type = 'server_name'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$server_name = $row['value'];

	mysqli_close($conn);



	$imageUrls = [];
	$imageMessages = [];
	$imageMessagesforNotify = [];
	if (trim($attachedImage) != "") {
		$imageUrls = explode(",", $attachedImage);
	}

	if (!empty($imageUrls)) {
		foreach ($imageUrls as $imageUrl) {
			$imageMessages[] = [
				'type' => 'image',
				'originalContentUrl' => $server_name . $imageUrl,
				'previewImageUrl' => $server_name . $imageUrl
			];
			$imageMessagesforNotify[] = $server_name . $imageUrl;
		}
	}


	$prefix = "NOTIFY_";
	if (substr($line_id, 0, strlen($prefix)) == $prefix) {
		$line_id = substr($line_id, strlen($prefix));
		sendLineNotify($line_id, $message);

		foreach ($imageMessagesforNotify as $value) {
			//echo "$value <br>";
			sendImageToLineNotify($value, $line_id);
		}
	} else {


		$accessToken = $Line_Token;
		$userId = $line_id; // เปลี่ยนเป็น User ID ของผู้รับข้อความ





		$data = [
			'to' => $userId,
			'messages' => [
				[
					'type' => 'text',
					'text' => $message
				]
			]
		];

		if (!empty($imageUrls)) {
			$data['messages'] = array_merge($data['messages'], $imageMessages);
		}


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
		//if ($result === false) {
		//	echo 'เกิดข้อผิดพลาดในการส่งข้อความ: ' . curl_error($ch);
		//} else {
		//	echo 'ส่งข้อความและลิงก์ Line Message API สำเร็จ!';
		//}
	}
}


//============================ MAIN =========================================================
switch ($f) {
	case 1: {
			createNewUser();
			break;
		}
	case 2: {
			LoadUserInfobyID();
			break;
		}
	case 3: {
			updateUserInfoByID();
			break;
		}
	case 4: {
			updateUserpasswordByID();
			break;
		}
	case 5: {
			commonInsertDataToAttachedTable();
			break;
		}
	case 6: {
			loadAttachedData();
			break;
		}
	case 7: {
			testSendLine();
			break;
		}
	case 8: {
			sendLineMSG();
			break;
		}
	case 9: {
			sendLineMSGtoCliandCus();
			break;
		}
}
