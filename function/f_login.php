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

	session_start();

	// ตรวจสอบว่า Session มีหมดอายุหรือยัง
	/*
	if (isset($_SESSION['expire_time']) && time() > $_SESSION['expire_time']) {
		session_unset(); // ยกเลิก Session ทั้งหมด
		session_destroy(); // ลบ Session ทั้งหมด
		header("Location: ../login.php"); // ไปยังหน้า Login
	} 
*/
	require_once('connectionDb.php'); // ติดต่อ MySQL Database
	$user_id = mysqli_real_escape_string($conn, $_POST['uid']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	//$password = md5($password); // การเข้ารหัส (hash) password

	$sql = "SELECT a.*, b.name as user_levelName FROM users a Inner Join master_data b ON a.user_level = b.value AND b.type = 'user_level' WHERE user_id = '$user_id' AND password = '$password' AND active = '1'";
	$result = mysqli_query($conn, $sql);


	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);


		// Create an empty object
		$MAIN_USER_DATA = new stdClass();

		// Assign values to the object properties from the session variables
		$MAIN_USER_DATA->user_MAIN_id = $row['id'];
		$MAIN_USER_DATA->user_id = $row['user_id'];
		$MAIN_USER_DATA->name = $row['name'];
		$MAIN_USER_DATA->position_name = $row['position_name'];
		$MAIN_USER_DATA->picture = $row['picture'];
		$MAIN_USER_DATA->user_level = $row['user_level'];
		$MAIN_USER_DATA->user_levelName = $row['user_levelName'];
		$MAIN_USER_DATA->temp_password_flag = $row['temp_password_flag'];
		$MAIN_USER_DATA->password_expire_date = $row['password_expire_date'];
		$MAIN_USER_DATA->email = $row['email'];

		// Store the object in a session variable for later use
		$_SESSION['MAIN_USER_DATA'] = $MAIN_USER_DATA;



		//echo $_SESSION['user_id'];
		$_SESSION['expire_time'] = time() + (7 * 24 * 60 * 60); // ตั้งค่า Session หมดอายุใน 7 วัน
		echo "1";
	} else {
		session_unset(); // ยกเลิก Session ทั้งหมด
		session_destroy(); // ลบ Session ทั้งหมด
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
