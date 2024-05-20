<?php
    /*
    Author: Ilias Motsenigos
    Date: 7/5/2024
    Last Updated: 7/5/2024
    Description: This php file is complementary to viewPastEntries.php and it dynamically updates its fields through AJAX.
                By receiving the selected educational period (edPeriod) specialty and semester from the parent file it runs
                a query to the application's database to fetch the available subjects in the selected semester and then updates
                the drop down menu (<select id='subjects'>) in the main form of the page.
    */
    include_once '../Configs/Conn.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';
    
    if(isset($_POST["semester"])&& !empty($_POST['semester'])){

        //fetching data from main form
        $edPeriod = $_POST['edPeriod'];
        $specialty = $_POST['specialty'];
        $semester = $_POST['semester'];

        //getting classID

        $classID;

        $query = "SELECT id FROM class WHERE specialtyID = $specialty AND edperiodID = $edPeriod AND semester = '$semester';";
        $result = $GLOBALS['conn']->query($query);
        $row = $result->fetch_assoc();
        if($row){
          $classID = $row['id'];

        } else {
          $classID = 0;
        }

        //getting the subjects
        getAvailableSubjects($specialty, $classID);

    }

    function getAvailableSubjects($specialty, $classID){
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
