<?php
// Function to execute a SQL query
function execute_query($conn, $query) {
    if (mysqli_query($conn, $query)) {
        echo "Query executed successfully";
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}

function generate_class_data($conn) {
    require_once '../../vendor/autoload.php'; // Include the Faker autoloader
    $faker = Faker\Factory::create(); // Initialize Faker

    //Initializing arrays
    $classes = [];
    $edPeriodIDs = [];
    $specialtyIDs = [];

    // Fetch edperiod IDs and seasons
    $query = "SELECT edperiod.id, edperiod.season
              FROM edperiod
              LEFT JOIN class ON edperiod.id = class.edperiodID
              WHERE class.edperiodID IS NULL";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            //each ID corresponds to a season
            $edPeriodIDs[$row['id']] = $row['season'];
        }
    } else {
        echo "Error: " . $conn->error;
    }

    // Fetch available specialty IDs
    $query = "SELECT specialtyID AS id FROM specialty";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            //assigning IDs of available specialties
            $specialtyIDs[] = $row['id'];
        }
    } else {
        echo "Error: " . $conn->error;
    }

    // Generate class data
    foreach ($edPeriodIDs as $edPeriodID => $season) {//loop runs once for each season with no classes
        foreach ($specialtyIDs as $specialtyID) {//this loops through the specialties
            for ($l = 0; $l <= 1; $l++) {//bool to represent the two semesters in each season(A, B)
                //Assigning semesters acording to season:
                //For season A semesters B and D
                //For season B semester A and C
                $semester = ($season == 'A') ? ($l ? 'D' : 'B') : ($l ? 'C' : 'A');
                //random number of classes between 1 and 5
                $numOfClasses = $faker->numberBetween($min = 1, $max = 5);
                //creating string and pushing to array
                $classes[] = "($numOfClasses, $specialtyID, $edPeriodID, '$semester')";
            }
        }
    }
    //return classes array of stings
    return $classes;
}

include_once '../../Configs/Conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate test data for class table
    $class_data = generate_class_data($conn);
    //implode array into a string compatible with SQL
    $class_query = "INSERT INTO class (numOfClasses, specialtyID, edperiodID, semester) VALUES " . implode(",", $class_data);
    //execute
    execute_query($conn, $class_query);
}

// Close connection
mysqli_close($conn);
?>
