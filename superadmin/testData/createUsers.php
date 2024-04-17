<?php

// Function to execute a SQL query
function execute_query($conn, $query) {
    if (mysqli_query($conn, $query)) {
        echo "Query executed successfully";
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}

// Function to generate test data for the user table
function generate_user_data($faker, $count) {
    $users = [];
    for ($i = 0; $i < $count; $i++) {
        $username = $faker->userName;
        $password = $faker->bothify('##?##?##?');
        $fname = $faker->firstName;
        do{//checking for names like O'Riley cause it messes with the string
          $lname = $faker->lastName;
        }while(str_contains($lname,"'"));

        $isAdmin = rand(0, 1);
        $users[] = "('$username', '$password', '$fname', '$lname', $isAdmin)";

    }
    return $users;
}

require_once '../../vendor/autoload.php'; // Include the Faker autoloader
$faker = Faker\Factory::create(); //init faker
include_once '../../Configs/Conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $count=$_POST['count'];//getting user ammount
  $user_data = generate_user_data($faker, $count);//generate user data using the faker
  $user_query = "INSERT INTO user (username, password, fname, lname, isAdmin) VALUES " . implode(",", $user_data);

  execute_query($conn, $user_query);

}

// Close connection
mysqli_close($conn);

?>
