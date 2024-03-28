<?php
   include_once '../databaseConnection.php';

     $month = "-";
     if(isset($_POST["date"])){
        //getting data from the form
        $calledFunction = $_POST['getDate'];
        $date = $_POST['date'];
        $monthIni = substr($date, 5, 2);
        $month .= $monthIni;
        $month .= "-";
     }
     
     getSeasons($month);
     
     function getSeasons($month){

        $winterMonths = "--09-10-11-12-01-";//additional dash at the start to prohibit strpos from returning 0
        $springMonths = "--03-04-05-06-07-";//additional dash at the start to prohibit strpos from returning 0 

        if(strpos($winterMonths, $month)){
            echo "<select id='semester' name='semester'>";
            echo "<option value=''>Επιλέξτε Eξάμηνο</option>";
            echo "<option value='a'>Α</option>";
            echo "<option value='c'>Γ</option>";
            echo "</select>";
        }
        elseif(strpos($springMonths, $month)){
            echo "<select id='semester' name='semester'>";
            echo "<option value=''>Επιλέξτε Eξάμηνο</option>";
            echo "<option value='b'>Β</option>";
            echo "<option value='d'>Δ</option>";
            echo "</select>";
        }
        //Both fall and spring semesters can run during February
        elseif(strpos("--02-", $month)){
            echo "<select id='semester' name='semester'>";
            echo "<option value=''>Επιλέξτε Eξάμηνο</option>";
            echo "<option value='a'>Α</option>";
            echo "<option value='c'>Γ</option>";
            echo "<option value='b'>Β</option>";
            echo "<option value='d'>Δ</option>";
            echo "</select>";
        }
        else{
            echo "<select id='semester' name='semester'>";
            echo "<option value='error'>error". $month . "</option>";

            echo "</select>";
        }
    }
    ?>