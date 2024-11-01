<?php
    include_once '../Configs/Conn.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';
    
     if(isset($_POST["getNumOfClasses"]) && !empty($_POST["getNumOfClasses"])){
        //getting data from the form
        $calledFunction = $_POST['getNumOfClasses'];
        $semester = $_POST['semester'];
        $specialty = $_POST['specialty'];
        $date = $_POST['date'];
        $season = "error";
        $year;
        $month=substr($date, 5, 2);

        //setting seasonal aspect based on the class' semester
        if($semester == 'a' || $semester == 'c'){
            $season = 'B';
        }
        elseif($semester == 'b' || $semester == 'd'){
            $season = 'A';
        }


        //getting year from date
        $year = substr($date, 0, 4);

        /*For January and February the actual year doesn't match the academic semester's year.
        For example a semester 2023B belongs to 2023 but runs from October to February. For January and February the actual year (2024)
        doesn't match the semester's year (2023). To account for this abnormality:
        */
        if($season == 'B' && ($month == 01 || $month == 02)){
            $year -= 1;
        }

        getNumOfClasses($semester, $specialty, $year, $season);

     }

     function getNumOfClasses($semester, $specialty, $year, $season){

        $query = "SELECT id FROM edperiod WHERE year = $year AND season = '$season';";
        $result = $GLOBALS['conn']->query($query);
        $row = $result->fetch_assoc();
        $edPeriodID = $row['id'];

        $query = "SELECT numOfClasses FROM class WHERE specialtyID ='".$specialty."' AND edperiodID = '".$edPeriodID."' AND semester = '".$semester."';";
        $result = $GLOBALS['conn']->query($query);


        if ($result && $result->num_rows > 0){
            echo "<option value=''disabled selected>Επιλέξτε Tμήμα</option>";
            while($row = $result->fetch_assoc()){
                $numOfClasses = $row['numOfClasses'];
                for($i = 1; $i <= $numOfClasses; $i++){
                    echo "<option value='$i'>$i</option>";
                }
            }
        }
        //in case of 0 returned results
        else{
            echo "<option value=''> Δεν βρέθηκαν τμήματα </option>";
        }
        echo "</select>";
     }
?>
