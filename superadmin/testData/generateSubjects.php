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

      $subjects = [];
      $class_ids = [];
      //getting data from the DB to generate the constraints
      //look at the coresponding loops to understand the logic

      //getting ids of classes that don't have subjects
      $query = "SELECT class.id AS id
                FROM class
                LEFT JOIN activesubjects ON class.id = activesubjects.classID
                WHERE activesubjects.classID IS NULL;
                ";
      $result = $conn->query($query);

      if ($result) {
          while($row = $result->fetch_assoc()){
            echo "Ids: ". $row['id'];
            array_push($class_ids, $row['id']);
          }
      } else {
          echo "Error: " . $conn->error;
      }

      //Select count of specialties
      $query = "SELECT COUNT(specialtyID) AS count FROM  specialty";
      $result = $conn->query($query);

      if ($result) {
          $row = $result->fetch_assoc();
          $specialtyCount = $row['count'];
      } else {
          echo "Error: " . $conn->error;
      }

      foreach($class_ids as $id) {//loop runs through every classID
        $classID = $id;

        //Select specialty and semester
        $query = "SELECT class.specialtyID AS specID, semester
                  FROM  class
                  WHERE class.id=$id;
                  ";
        $result = $conn->query($query);
        //get results (single row)
        if ($result) {
            $row = $result->fetch_assoc();
            $specialty = $row['specID'];
            $semester = $row['semester'];
        } else {
            echo "Error: " . $conn->error;
        }

        $subject_ids = [];
        //Select subject ids
        $query = "SELECT subjectID AS id
                  FROM  subject
                  WHERE specialtyID=? AND semester=?;
                  ";

        $stmt = $conn->prepare($query);//prepare query
        $stmt->bind_param("is", $specialty,$semester);//bind parameters
        $stmt->execute();
        $result = $stmt->get_result();
        //get results (multiple rows)
        if ($result) {
            while($row = $result->fetch_assoc()){
              array_push($subject_ids, $row['id']);
            }
        } else {
            echo "Error: " . $conn->error;
        }
        //loop for every subject in specialty semester
        foreach($subject_ids as $sID){
          $subjects[] = "($sID, $specialty, $id)";
        }
      }
      return $subjects;
  }



  include_once '../../Configs/Conn.php';


  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Generate test data for class table
    $subject_data = generate_class_data($conn);
    $subjects_query = "INSERT INTO activesubjects (subjectID, specialtyID, classID) VALUES " . implode(",", $subject_data);
    echo $subjects_query;
    execute_query($conn, $subjects_query);

  }

  // Close connection
  mysqli_close($conn);

 ?>
