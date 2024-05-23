<?php

//Author: Ilias Motsenigos
//Last Updated: 7/5/2024

//handling of unauthorized users
$_PERMISSIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);
include_once '../common/checkAuthorization.php';

   include_once '../Configs/Conn.php';

    if(isset($_POST["get_subjects"])&& !empty($_POST['get_subjects'])){
        $calledFunction = $_POST['get_subjects'];
        $specialty = $_POST['specialty'];
        $semester = $_POST['semester'];
        $date = $_POST['date'];
        $year = substr($date, 0, 4);

        //getting season
        $season="";
            if($semester == 'a' || $semester == 'c'){
                $season = 'b';
            }
            elseif($semester == 'b' || $semester == 'd'){
                $season = 'a';
            }

        //getting edPeriodid
        $query = "SELECT id FROM edperiod WHERE year = " . $year . " AND season = '". $season ."';";
        $result = $GLOBALS['conn']->query($query);
        $row = $result->fetch_assoc();
        $edPeriodID = $row['id'];


        //getting classID
        $query = "SELECT id FROM class WHERE specialtyID = $specialty AND edperiodID = $edPeriodID AND semester = '$semester';";
        $result = $GLOBALS['conn']->query($query);
        $row = $result->fetch_assoc();
        if($row){
          $classID = $row['id'];

        } else {
          $classID = 0;
        }

        get_subjects($specialty, $classID);
    }

    function get_subjects($specialty, $classID){
        $query = "SELECT activesubjects.subjectID, subject.name FROM activesubjects JOIN subject ON subject.subjectID = activesubjects.subjectID WHERE activesubjects.specialtyID = $specialty AND activesubjects.classID = $classID;";
        $result = $GLOBALS['conn']->query($query);
        if ($result->num_rows>0){
            echo "<select id='subject' name='subject' length='20'>";
            echo "<option value=''>Επιλέξτε Mάθημα</option>";
        while($row = $result->fetch_assoc()){

            echo "<option value='".$row['subjectID']."'>".$row['name']."</option>";
        }
        echo "</select>";
        }
        else{
            echo "<select id='subject' name='subject' length='20'>";
            echo "<option value=''>Δεν βρέθηκαν μαθήματα.</option>";
            echo "</select>";
        }
    }
?>
