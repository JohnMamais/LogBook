<?php
    /*
    Author: Ilias Motsenigos
    Date: 7/5/2024
    Last Updated: 7/5/2024
    Description: This php file is complementary to viewPastEntries.php and it dynamically updates its fields through AJAX.
                By receiving all of the imput data from the main form of the parent file it runs a query to the application's
                database to fetch previous log book entries matching the data provided and then updates the appropriate
                element of the page (<div id="returnedEntries">).
    */
    include_once '../Configs/Conn.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';
    

    if(isset($_POST["subject"])&& !empty($_POST['subject'])&& !empty($_POST['edPeriod'])&& !empty($_POST['semester'])&& !empty($_POST['class'])&& !empty($_POST['specialty'])){

        //fetching data from main form
        $edPeriod = $_POST['edPeriod'];
        $specialty = $_POST['specialty'];
        $semester = $_POST['semester'];
        $class = $_POST['class'];
        $subject = $_POST['subject'];

        getEntries($edPeriod, $specialty, $semester, $class, $subject);
    }

    function getEntries($edPeriod, $specialty, $semester, $class, $subject){

        //fetching year and season from edPeriod
        $year = $season = '';
        $query = "SELECT year, season FROM edperiod WHERE id = $edPeriod";
        $result = $GLOBALS['conn']->query($query);
        if ($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $year = $row['year'];
                $season = $row['season'];
            }
        }
        else{
            $year = $season = 0;
        }

        //fetching entries

        $query = "SELECT bookentry.date, bookentry.description, bookentry.periods, user.fname, user.lname FROM bookentry
                JOIN user ON user.id = bookentry.username
                WHERE year = $year AND season = '$season' AND specialtyID = $specialty AND semester = '$semester'
                AND subjectID = $subject AND class = $class;";

        $result = $GLOBALS['conn']->query($query);

        if ($result->num_rows>0){

            echo "<table>";
            echo "<tr><th>Ημερομηνία</th><th>Περιγραφή</th><th>Περίοδοι</th><th>Όνομα</th><th>Επώνυμο</th></tr>";

            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['periods'] . "</td>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td>" . $row['lname'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        else{
            echo "Δεν βρέθηκαν εγγραφές.";
        }
    }
?>
