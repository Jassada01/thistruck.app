<?php
// Read Function_code

$f = $_POST['f'];

// End Read Function =============================

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

function safe($value)
{
	//return mysql_real_escape_string($value);
	$value = str_replace("'", '', $value); //reject '
	$value = str_replace('"', '', $value); //reject "
	$value = str_replace(';', '', $value); //reject ;
	$value = str_replace('-', '', $value); //reject -
	$value = str_replace(' ', '', $value); //reject (space)
	return $value;
}


// ======== Function ========
// 1
function login_process()
{
	foreach ($_POST as $key => $value) {
		//$data[htmlspecialchars($key)] = htmlspecialchars($value);
		$a = htmlspecialchars($key);
		$$a = safe(preg_replace('~[^a-z0-9_ก-๙\s/,//.//://;//?//_//^//>//<//=//%//#//@//!//{///}//[//]/-//&//+//*///]~ui ', '', trim(str_replace("'", "", htmlspecialchars($value)))));
	}
	
	//echo $password;
	$sql = "Select count(*) AS cnt From sys_user a where a.user_id = '$uid' AND a.password = '$password' AND a.active = 1";
	include "connectionDb.php";
	$res = $conn->query(trim($sql));

	$data_Array = array();
	while ($row = $res->fetch_assoc()) {
		$data_Array[] = $row;
	}
	if ($data_Array[0]['cnt'] == 1) {
		// GET Current IP Address
		$ip = $_SERVER['REMOTE_ADDR'];
		//$ip = 'kalsklakslaksla';

		// Generate HisKey
		$hiskey = gen_rnd_str(64);

		// Clear flag for last login
		$sql = "UPDATE sys_user_history SET Active = 0 WHERE user_id = '$uid' AND ip_address = '$ip'";
		//echo $sql;
		if (!$conn->query($sql)) {
			exit();
		}

		// Insert new record  ============================
		$sql = "Insert Into sys_user_history VALUES ('$uid', '$ip', '$hiskey', current_timestamp, TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL -1 day)),1)";
		if (!$conn->query($sql)) {
			exit();
		}

		date_default_timezone_set("Asia/Bangkok");
		$limit_time =  date("U",  strtotime(date("d-m-Y",  strtotime('+1 day'))));
		setcookie('system_hiskey', $hiskey, $limit_time);
		//mysqli_close($conn);
		echo "1";
	} else {
		sleep(3);
		echo "0";
	}
	mysqli_close($conn);






	//echo json_encode($data_Array);
}



//============================ MAIN =========================================================
switch ($f) {
	case 1: {
			login_process();
			break;
		}
}
