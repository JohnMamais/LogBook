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

      //getting data from the DB to generate the constraints
      //look at the coresponding loops to understand the logic

      //getting count of period id
      $query = "SELECT id FROM edperiod;"; // Alias the COUNT(id) as 'count'
      $result = $conn->query($query);

      if ($result) {
          $row = $result->fetch_assoc();
          //$edPeriodCount = $row['count']; // Access the result using the alias
          $edPeriodids = $row['id'];
          foreach($ as $id){
            echo "Ids: ". $id;
          }
      } else {
          echo "Error: " . $conn->error;
      }

      $query = "SELECT MAX(edPeriodID) AS maxP FROM class;";
      $result = $conn->query($query);

      if ($result) {
          $row = $result->fetch_assoc();
          $lastPeriod = $row['maxP']; // Access the result using the alias
      } else {
          echo "Error: " . $conn->error;
      }

      //getting count of specialties
      $query = "SELECT COUNT(specialtyID) AS count FROM specialty;"; // Alias the COUNT(id) as 'count'
      $result = $conn->query($query);

      if ($result) {
          $row = $result->fetch_assoc();
          $specialtyCount = $row['count']; // Access the result using the alias
      } else {
          echo "Error: " . $conn->error;
      }

      if($lastPeriod>0){

      }

      foreach($edPeriodids as $id) {//first loop runs once for every semester(edperiod)
          if($id>$lastPeriod){
            $edPeriodID = $id;
            for($j=1;$j<=$specialtyCount;$j++){ //creating a class for every specialty
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
      }
      return $classes;
  }



  require_once 'conn.php';//DB connection


  //if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Generate test data for class table
    $class_data = generate_class_data($conn);
    $class_query = "INSERT INTO class (numOfClasses, specialtyID, edPeriodID, semester) VALUES " . implode(",", $class_data);
    echo $class_query;
    //execute_query($conn, $class_query);

  //}

  // Close connection
  mysqli_close($conn);

 ?>
