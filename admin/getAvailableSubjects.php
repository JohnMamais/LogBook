<?php 
    include_once '../databaseConnection.php';

    if(isset($_POST["get_subjects"])&& !empty($_POST['get_subjects'])){
        $calledFunction = $_POST['get_subjects'];
        $specialty = $_POST['specialty'];

        echo "<script>console.log('bike stin if tou arxeiou');</script>";
        get_subjects($specialty);
    }
    
    function get_subjects($specialty){
        $query = "SELECT * FROM subject WHERE specialtyID = '". $specialty . "' ;";
        $result = $GLOBALS['conn']->query($query);
        if($result->num_rows > 0){
            $semester_count = 0;
            while($row = $result->fetch_assoc()){
                
                $semester = $row['semester'];
                if($semester == "A" && $semester_count == 0){
                    echo "<br>Εξάμηνο Α: <br>";
                    $semester_count = $semester_count+1;
                }
                if($semester == "B" && $semester_count == 1){
                    echo "<br>Εξάμηνο Β: <br>";
                    $semester_count+=1;
                }
                if($semester == "C" && $semester_count == 2){
                    echo "<br>Εξάμηνο Γ: <br>";
                    $semester_count+=1;
                }
                if($semester == "D" && $semester_count == 3){
                    echo "<br>Εξάμηνο Δ: <br>";
                    $semester_count+=1;
                }
                echo "<input type='checkbox' name='selected_subjects' value='". $row['specialtyID']. "'> " ;
                echo $row['name'];
                echo "<br>";
            }   
        }
        else{
            echo '<option value="">Δεν βρέθηκαν μαθήματα</option>';
        }
    }
    
?>