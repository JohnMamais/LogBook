<?php
     /*
    Author: Ilias Motsenigos
    Date: 20/5/2024
    Last Updated: 20/5/2024
    Description: This php file is complementary to mainform.php and it dynamically updates a specific field through AJAX.
                By receiving the date, specialty, semester, class and subject from the main form of the parent file it runs a query to the application's
                database to fetch previous log book entries matching the data provided and then updates the appropriate
                element of the page (<div id="pastEntries">). In summary this code fetches the latest entries matching the class and
                subject selected by the user.
    */

    //database connection
    include_once '../Configs/Conn.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';

    if(!empty($_POST["date"])&& !empty($_POST['specialty'])&& !empty($_POST['semester'])&& !empty($_POST['class'])&& !empty($_POST['subject'])){
        $date = $_POST['date'];
        $specialty = $_POST['specialty'];
        $semester = $_POST['semester'];
        $class = $_POST['class'];
        $subject = $_POST['subject'];
        $season = "";
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        
        //getting season
            if($semester == 'a' || $semester == 'c'){
                $season = 'b';
            }
            elseif($semester == 'b' || $semester == 'd'){
                $season = 'a';
            }

        //year adjustment
            if($season == 'b' && ($month == 01 || $month == 02)){
                $year -= 1;
            }
        
        getRecentEntries($year, $season, $specialty, $semester, $class, $subject, $conn);
    }

    function getRecentEntries($year, $season, $specialty, $semester, $class, $subject, $conn){
        $query = "SELECT bookentry.date, bookentry.description, bookentry.periods, user.fname, user.lname FROM bookentry
        JOIN user ON user.id = bookentry.username
        WHERE year = $year AND season = '$season' AND specialtyID = $specialty 
        AND semester = '$semester' AND subjectID = $subject AND class = $class;";

        $result = $GLOBALS['conn']->query($query);
        
        if ($result->num_rows>0){

            echo "<table>";
            echo "<tr><th class='leftEdge'>Ημερομηνία</th><th>Περιγραφή</th><th>Περίοδοι</th><th>Όνομα</th><th class='rightEdge'>Επώνυμο</th></tr>";

            while($row = $result->fetch_assoc()){
                echo "<tr class='logRow'>";
                echo "<td class='leftEdge'>" . $row['date'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['periods'] . "</td>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td class='rightEdge'>" . $row['lname'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        else{
            echo "Δεν βρέθηκαν εγγραφές.";
        }
    }

?>
