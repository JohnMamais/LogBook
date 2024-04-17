<?php
  // Function to execute a SQL query
  function execute_query($conn, $query) {
      if (mysqli_query($conn, $query)) {
          echo "Query executed successfully";
      } else {
          echo "Error executing query: " . mysqli_error($conn);
      }
  }

  function generate_ed_period_data($min, $max) {
    $ed_periods = [];
    for ($i=$min; $i <= $max; $i++) {
        echo $i;
        $year = $i;
        for($j=0;$j<=1;$j++){
            $season= $j ? $season='A' : $season='B';
            $ed_periods[] = "($year, '$season')";
        }
    }
    return $ed_periods;
  }

  include_once '../../Configs/Conn.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $min=$_POST['min'];
    $max=$_POST['max'];

    echo $min.$max;
    $data = generate_ed_period_data($min, $max);//generate data

    $query="INSERT INTO edPeriod (year, season) VALUES " . implode(",", $data);
    echo $query;

    execute_query($conn, $query);

  }

  // Close connection
  mysqli_close($conn);

  //include_once('generateClasses.php');
 ?>
