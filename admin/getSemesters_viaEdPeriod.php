<?php
    include_once '../Configs/Conn.php'; 

    if(isset($_POST['edPeriod'])){
        //getting data from the form
        $edPeriod = $_POST['edPeriod'];
        getSemesters($edPeriod);
    }

    function getSemesters($edPeriod){
    //fetching the type of edPeriod (season) from the database
        $season;
        $query = "SELECT season FROM edPeriod WHERE id = $edPeriod;";
        $result = $GLOBALS['conn']->query($query);
        if ($result && $result->num_rows > 0){
            echo "<select name='semester' id='semester'>";
            echo "<option value=''>Επιλέξτε Εξάμηνο</option>";
            while($row = $result->fetch_assoc()){
                $season = $row['season'];
            }
            if($season == 'a'){
                echo "<option value='b'>Β' Εξάμηνο</option>";
                echo "<option value='d'>Δ' Εξάμηνο</option>";
            }
            else if($season == 'b'){
                echo "<option value='a'>Α' Εξάμηνο</option>";
                echo "<option value='c'>Γ' Εξάμηνο</option>";
            }
            echo "</select>";
        }
        //in case of 0 returned results
        else{
            echo "<option value=''> Δεν βρέθηκαν τμήματα </option>";
        }


    }

?>