<?php
    include_once '../Configs/Conn.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';

    if(isset($_POST["get_subjects"])&& !empty($_POST['get_subjects'])){
        $calledFunction = $_POST['get_subjects'];
        $specialty = $_POST['specialty'];

        get_subjects($specialty);
    }

    function get_subjects($specialty){
        $query = "SELECT * FROM subject WHERE specialtyID = '". $specialty . "' ;";
        $result = $GLOBALS['conn']->query($query);
        if($result->num_rows > 0){
            echo "<div id='new_available_subjects_div'>";
            $semester_count = 0;
            while($row = $result->fetch_assoc()){

                $semester = $row['semester'];
                if($semester == "A" && $semester_count == 0){
                    echo "<label for='checkAllA'>Α' Εξάμηνο: </label>";
                    echo "<input type='checkbox' class='check-all' id='checkAllA'> <br><br>"; // Check All for semester A
                    $semester_count = $semester_count+1;
                }
                if($semester == "B" && $semester_count == 1){
                    echo "<br>";
                    echo "<label for='checkAllB'>Β' Εξάμηνο: </label>";
                    echo "<input type='checkbox' class='check-all' id='checkAllB'><br><br>"; // Check All for semester B
                    $semester_count+=1;
                }
                if($semester == "C" && $semester_count == 2){
                    echo "<br>";
                    echo "<label for='checkAllC'>Γ' Εξάμηνο: </label>";
                    echo "<input type='checkbox' class='check-all' id='checkAllC'><br><br>"; // Check All for semester C
                    $semester_count+=1;
                }
                if($semester == "D" && $semester_count == 3){
                    echo "<br>";
                    echo "<label for='checkAllD'>Δ' Εξάμηνο: </label>";
                    echo "<input type='checkbox' class='check-all' id='checkAllD'><br><br>"; // Check All for semester D
                    $semester_count+=1;
                }
                echo "<input type='checkbox' class='Checkbox".$semester."' id= 'selectedSubjects".$row['subjectID']."' name='selectedSubjects[]' value='". $row['subjectID']. "'> " ;
                echo $row['name'];
                echo "<br>";
            }
             echo "</div>";
        }

        else{
            echo '<option value="">Δεν βρέθηκαν μαθήματα</option>';
        }
    }

?>
