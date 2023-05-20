<?php
$server_name = "localhost";
$UID = "root";
$Pass = "}Ww]3v2CX<2mSH$7";
$DB_name = "mysystem";
$conn = new mysqli($server_name,$UID,$Pass,$DB_name);

// Setting for support Thai
mysqli_set_charset($conn, "utf8");

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
	}
?>