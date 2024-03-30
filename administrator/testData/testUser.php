<?php
// Function to establish a connection to MySQL database
function create_connection($host_name, $user_name, $user_password, $db_name) {
    $conn = mysqli_connect($host_name, $user_name, $user_password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully";

    return $conn;
}

// Function to execute a SQL query
function execute_query($conn, $query) {
    if (mysqli_query($conn, $query)) {
        echo "Query executed successfully";
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}

// Function to generate test data for the user table
function generate_user_data() {
    $users = [];
    for ($i = 0; $i < 10; $i++) {
        $username = faker()->userName;
        $password = faker()->password;
        $fname = faker()->firstName;
        $lname = faker()->lastName;
        $isAdmin = rand(0, 1);
        $users[] = "('$username', '$password', '$fname', '$lname', $isAdmin)";
    }
    return $users;
}
/*
// Database connection details
$host = "localhost";
$user = "your_username";
$password = "your_password";
$database = "your_database_name";

// Create connection to MySQL database
$conn = create_connection($host, $user, $password, $database);

// Generate test data for user table
$user_data = generate_user_data();
$user_query = "INSERT INTO user (username, password, fname, lname, isAdmin) VALUES " . implode(",", $user_data);
execute_query($conn, $user_query);

// Close connection
mysqli_close($conn);
*/
require_once 'vendor/autoload.php'; // Include the Faker autoloader
$faker = Faker\Factory::create();

$user_data = generate_user_data();
echo "User data: ".implode(",", $user_data);
?>
