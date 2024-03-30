<?php
// Database connection details
$host = "localhost";
$user = "user";
$password = "";
$database = "log_book";

//connecting
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

?>
