<?php
    /*
    Author: Ilias Motsenigos
    Date: 7/5/2024
    Last Updated: 7/5/2024
    Description: This php file is complementary to index.php and it dynamically updates its fields through AJAX.
                By receiving the selected season (edPeriod) from the parent file and populates the drop down menu
                (<select id='semester'>) in the main form of the page with appropriate options: "a" and "c" for
                winter seasons (edPeriod = 'b') and "b" and "d" for spring seasons (edPeriod = 'a').
    */

    include_once '../Configs/Conn.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';
    
    if(isset($_POST["edPeriod"])){
        //getting data from the form
        $edPeriod = $_POST['edPeriod'];

        getSemesters($edPeriod);
     }

     function getSemesters($edPeriod){
        if($edPeriod == 'a'){
            echo "<span id='semester_span'>
                    <label for='semester'>Εξάμηνο: </label>
                    <select name='semester' id='semester' class='dropdown'>
                        <option value='' selected disabled>Επιλέξτε Εξάμηνο</option>
                        <option value='b'>Β`</option>
                        <option value='d'>Δ`</option>
                    </select>
                </span>";
        }
        if($edPeriod == 'b'){
            echo "<span id='semester_span'>
                    <label for='semester'>Εξάμηνο: </label>
                    <select name='semester' id='semester' class='dropdown'>
                        <option value='' selected disabled>Επιλέξτε Εξάμηνο</option>
                        <option value='a'>A`</option>
                        <option value='c'>Γ`</option>
                    </select>
                </span>";
        }
        if($edPeriod == ''){
            echo "<span id='semester_span'>
                    <label for='semester'>Εξάμηνο: </label>
                    <select name='semester'id='semester' class='dropdown'>
                        <option value='' selected disabled>Επιλέξτε Εξάμηνο</option>
                    </select>
                </span>";
        }
     }
?>
