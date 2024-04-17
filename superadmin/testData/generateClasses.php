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
      $faker = Faker\Factory::create(); //init faker

      $classes = [];
      $edPeriodIDs = [];
      //getting data from the DB to generate the constraints
      //look at the coresponding loops to understand the logic

      //getting count of period id
      $query = "SELECT edPeriod.id
                FROM edPeriod
                LEFT JOIN class ON edperiod.id = class.edPeriodID
                WHERE class.edPeriodID IS NULL;
                "; // Alias the COUNT(id) as 'count'
      $result = $conn->query($query);

      if ($result) {
          while($row = $result->fetch_assoc()){
            echo "Ids: ". $row['id'];
            array_push($edPeriodIDs, $row['id']);
          }
      } else {
          echo "Error: " . $conn->error;
      }

      $query = "SELECT COUNT(specialtyID) AS count FROM  specialty"; // Alias the COUNT(id) as 'count'
      $result = $conn->query($query);

      if ($result) {
          $row = $result->fetch_assoc();
          $specialtyCount = $row['count'];
      } else {
          echo "Error: " . $conn->error;
      }

      foreach($edPeriodIDs as $id) {//first loop runs once for every semester(edperiod)
            $edPeriodID = $id;
            for($j=1;$j<$specialtyCount;$j++){ //creating a class for every specialty
              $specialtyID = $j;
              for($l=0;$l<=1;$l++){
                if($edPeriodID%2==0){
                  $semester = $l ? 'B' : 'D';
                } else {
                  $semester = $l ? 'A' : 'D';
                }
                $numOfClasses = $faker->numberBetween($min = 1, $max = 5); //creating 1-5 classes for each
                $classes[] = "($numOfClasses, $specialtyID, $edPeriodID, '$semester')";
              }
            }
          }
      return $classes;
  }



  include_once '../../Configs/Conn.php';


  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Generate test data for class table
    $class_data = generate_class_data($conn);
    $class_query = "INSERT INTO class (numOfClasses, specialtyID, edPeriodID, semester) VALUES " . implode(",", $class_data);
    echo $class_query;
    execute_query($conn, $class_query);

  }

  // Close connection
  mysqli_close($conn);

 ?>
