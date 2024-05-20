<?php
    /*
    Author: Ilias Motsenigos
    Date: 7/5/2024
    Last Updated: 7/5/2024
    Description: This php file is complementary to viewPastEntries.php and it dynamically updates its fields through AJAX.
                By receiving the selected educational period (edPeriod) specialty and semester from the parent file it runs
                a query to the application's database to fetch the number of classes that said semester has and then updates
                the drop down menu (<select id='class'>) in the main form of the page.
    */
    include_once '../Configs/Conn.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';
    
    if(isset($_POST["semester"]) && !empty($_POST["semester"])){
        $edPeriod = $_POST['edPeriod'];
        $specialty = $_POST['specialty'];
        $semester = $_POST['semester'];

        echo "semester = $semester";
        getNumOfClasses($edPeriod, $specialty, $semester);
    }

    function getNumOfClasses($edPeriod, $specialty, $semester){

        $query = "SELECT numOfClasses FROM class WHERE specialtyID = $specialty AND edperiodID = $edPeriod AND semester = '$semester';";
        $result = $GLOBALS['conn']->query($query);

        echo "semester = $semester";

        echo "<select name='class' id='class'>";
        if ($result && $result->num_rows > 0){
            echo "<option value=''>Επιλέξτε Tμήμα</option>";
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
