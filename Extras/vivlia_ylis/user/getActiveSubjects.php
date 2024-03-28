<?php
   include_once '../databaseConnection.php';

    if(isset($_POST["get_subjects"])&& !empty($_POST['get_subjects'])){
        $calledFunction = $_POST['get_subjects'];
        $specialty = $_POST['specialty'];

        get_subjects($specialty);
    }

    function get_subjects($specialty){
        $query = "SELECT DISTINCT activesubjects.subjectID, subject.name FROM activesubjects JOIN subject ON subject.subjectID = activesubjects.subjectID WHERE activesubjects.specialtyID ='".$specialty."';";
        $result = $GLOBALS['conn']->query($query);
        
        if ($result->num_rows>0){
            echo "<select id='subject' name='subject' length='20'>";
            echo "<option value=''>Επιλέξτε Mάθημα</option>";
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['subjectID']."'>".$row['name']."</option>";
        }
       echo "</select>";
        }
    }
?>