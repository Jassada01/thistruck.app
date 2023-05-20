<?php
// Connection settings
$servername = "localhost";
$username = "root";
$password = "}Ww]3v2CX<2mSH$7";
$dbname = "mysystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Validate input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];
  $name = $_POST["name"];
  $user_level = $_POST["user_level"];
  $temp_password = isset($_POST["temp_password"]) ? 1 : 0;
  $expire_days = isset($_POST["expire_days"]) ? $_POST["expire_days"] : null;

  if (empty($username)) {
    die("Username is required");
  }
  if (empty($password)) {
    die("Password is required");
  }
  if (strlen($password) < 8) {
    die("Password must be at least 8 characters long");
  }
  if ($password != $confirm_password) {
    die("Confirm password does not match password");
  }
  if (empty($name)) {
    die("Name is required");
  }
  if (empty($user_level)) {
    die("User level is required");
  }
  if ($temp_password && empty($expire_days)) {
    die("Expire days is required for temporary password");
  }

  // Hash the password using MD5
  $hashed_password = md5($password);

  // Create SQL statement to insert new user data
  $sql = "INSERT INTO users (username, password, name, user_level, active, temp_password, password_expire_date, profile_picture_path, create_datetime, update_datetime)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          
  // Prepare the SQL statement
  $stmt = $conn->prepare($sql);
  
  // Bind the parameters
  $stmt->bind_param("sssiisssss", $username, $hashed_password, $name, $user_level, 1, $temp_password, $expire_date, "", $create_datetime, $update_datetime);
  
  // Set the parameter values
  $expire_date = $temp_password ? date('Y-m-d', strtotime("+{$expire_days} days")) : null;
  $create_datetime = date('Y-m-d H:i:s');
  $update_datetime = date('Y-m-d H:i:s');
  
  // Execute the statement and check for errors
  if ($stmt->execute() === TRUE) {
  echo "New user created successfully";
  } else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  // Close the statement and connection
  $stmt->close();
  $conn->close();
  }
  ?>