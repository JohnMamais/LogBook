<?php
    //Ilias Motsenigos
    
    //limiting the available semesters shown to the user according to the selected educational period
    include_once '../ConnectionConfigs/adminConfig.php';

    if(isset($_POST["edPeriod"])){
        //getting data from the form
        $edPeriod = $_POST['edPeriod'];

        getSemesters($edPeriod);
     }

     function getSemesters($edPeriod){
        //spring semesters
        if($edPeriod == 'a'){
            echo "<span id='semester_span'>
                    <label for='semester'>Εξάμηνο: </label>
                    <select name='semester' id='semester' class='dropdown'>
                        <option value=''>Επιλέξτε Εξάμηνο</option>
                        <option value='b'>Β`</option>
                        <option value='d'>Δ`</option>
                    </select>
                </span>";
        }

        //winter semesters
        if($edPeriod == 'b'){
            echo "<span id='semester_span'>
                    <label for='semester'>Εξάμηνο: </label>
                    <select name='semester' id='semester' class='dropdown'>
                        <option value=''>Επιλέξτε Εξάμηνο</option>
                        <option value='a'>A`</option>
                        <option value='c'>Γ`</option>
                    </select>
                </span>";
        }
        if($edPeriod == ''){
            echo "<span id='semester_span'>
                    <label for='semester'>Εξάμηνο: </label>
                    <select name='semester'id='semester' class='dropdown'>
                        <option value=''>Επιλέξτε Εξάμηνο</option>
                    </select>
                </span>";
        }
     }
?>
