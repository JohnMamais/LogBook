<!DOCTYPE html>
<html lang="en">
<!--
    Author: Ilias Motsenigos
    Date: 1/5/2024
    Last Updated: 7/5/2024
    Description: This page allows the school's admins to fetch all the log book entries that have been created through this system.
                By selecting the educational period, specialty, semester, class and subject they want to check the approptiate results
                are displayed in a table. The menus are updated with information from the database dynamically using AJAX to update
                the fields in real time based on previous selections. Additionally the admin has the option to export the results in
                a PDF file using the appropriate button (TO BE ADDED).



-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <title>Εγγραφές Βιβλίων Ύλης</title>
</head>
<body>

    <?php
    //connecting to database
    include_once '../Configs/Conn.php';
    //including header menu
    include_once '../Configs/Config.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';
    
    ?>
    <h1>Εκτύπωση Εγγραφών από το Βιβλίο Ύλης</h1>

    <!--main form for user input-->
    <form name="pastEntriesForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

        <!-- edPeriod -->
        <label for="edPeriod">Ακαδημαϊκή Περίοδος: </label>
        <select name="edPeriod" id="edPeriod">
            <option value='' selected disabled>Επιλέξτε Ακαδημαϊκή Περίοδο</option>
            <?php
                //fetching data from database for edPeriod
                $query = "SELECT id, year, season FROM edperiod;";
                $result = $conn->query($query);

                if($result->num_rows > 0){
                    //making the data more readable for displaying to the users
                    $season;
                    while($row = $result->fetch_assoc()){
                        if($row['season'] == 'a'){
                            $season = " Α' (Εαρινή)";
                        }
                        if($row['season'] == 'b'){
                            $season = " Β' (Χειμερινή)";
                        }

                        //populating the select menu with options
                        echo "<option value='".$row['id']."'>".$row['year'].$season."</option>";
                    }
                }
                else{
                    echo '<option value="">Δεν βρέθηκαν ακαδημαϊκές περίοδοι.</option>';
                }
            ?>
        </select>
        <br>

        <!-- specialty -->
        <label for="specialty">Ειδικότητα: </label>
        <select name="specialty" id="specialty">
            <option value="" selected disabled>Επιλέξτε Ειδικότητα</option>
            <?php
                //fetching data from database for specialties
                $query = "SELECT specialtyID, name FROM specialty;";
                $result = $conn->query($query);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<option value='".$row['specialtyID']."'>".$row['name']."</option>";
                    }
                }
                else{
                    echo '<option value="">Δεν βρέθηκαν ειδικότητες.</option>';
                }
            ?>
        </select>
        <br>

        <!-- semester -->
        <label for="semester">Εξάμηνο: </label>
        <select name="semester" id="semester">
            <option value="" selected disabled>Επιλέξτε Εξάμηνο</option>
        </select>
        <br>

        <!-- class -->
        <label for="class">Τμήμα: </label>
        <select name="class" id="class">
            <option value="">Επιλέξτε Τμήμα</option>
        </select>
        <br>

        <!-- subject -->
        <label for="subject">Μάθημα: </label>
        <select name="subject" id="subject">
            <option value="" selected disabled>Επιλέξτε Μάθημα</option>
        </select>

        <br><br>

        <button type="submit" name="submit" value='submit'>Εκτύπωση σε PDF</button>
        <button type="reset">Απαλοιφή</button>
    </form>

    <!--Log Book entries returned-->
    <div id="returnedEntries"></div>

    <!--------------------------------------JAVASCRIPT AJAX SCRIPTS------------------------------------->

    <!-- getting available semesters -->
    <script>
        $(document).ready(function(){
            $('#edPeriod').change(function(){
                $.ajax({
                    type: 'POST',
                    url: 'getSemesters_viaEdPeriod.php',
                    data: {edPeriod: $('#edPeriod').val()},
                    success: function (getSemesters){
                        $('#semester').html(getSemesters);
                        //resetting dependent fields
                        $('#class').html('<option value="" disabled selected>Επιλέξτε Τμήμα</option>');
                        $('#subject').html('<option value="" disabled selected>Επιλέξτε Μάθημα</option>');
                    }
                })
            });
        });
    </script>

    <!-- getting number of classes for selected entity -->
    <script>
        $(document).ready(function(){
            $('#semester').change(function(){
                $.ajax({
                    type: 'POST',
                    url: 'getNumOfClasses_viaEdPeriod.php',
                    data: {edPeriod: $('#edPeriod').val(), specialty: $('#specialty').val(), semester: $('#semester').val()},
                    success: function (getNumOfClasses){
                     $('#class').html(getNumOfClasses);
                    //resetting dependent fields
                    $('#subject').html('<option value="" disabled selected>Επιλέξτε Μάθημα</option>');
                    }
                })
            })
        })
    </script>

    <!-- getting available subjects -->
    <script>
        $(document).ready(function(){
            $('#semester').change(function(){
                $.ajax({
                    type: 'POST',
                    url: 'getAvailableSubjects_viaEdPeriod.php',
                    data: {edPeriod: $('#edPeriod').val(), specialty: $('#specialty').val(), semester: $('#semester').val()},
                    success: function (getAvailableSubjects){
                     $('#subject').html(getAvailableSubjects);
                    }
                })
            })
        })
    </script>

    <!-- fetching log book entries -->
    <script>
        $(document).ready(function(){
            $('#subject').change(function(){
                $.ajax({
                    type: 'POST',
                    url: 'getLogBookEntries.php',
                    data: {edPeriod: $('#edPeriod').val(), specialty: $('#specialty').val(), semester: $('#semester').val(), class: $('#class').val(), subject: $('#subject').val()},
                    success: function (getEntries){
                     $('#returnedEntries').html(getEntries);
                    }
                })
            })
        })
    </script>
</body>

<!-------------------------------  Form Handling  --------------------------------------------->
<?php
    if(isset($_POST['submit'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            //initializig data variables
            $edPeriod = $specialty = $semester = $class = $subject = $year = $season = "";
            
            //initializing error variables that will hold error messages in case of empty fields
            $edPeriodError = $specialtyError = $semesterError = $classError = $subjectError = "";

            //checking input for all data and passing them into php variables if filled
            //edPeriod
            if(empty($_POST['edPeriod'])){
                $edPeriodError = "Παρακαλώ επιλέξτε ακαδημαϊκή περίοδο.";
                echo "<script>document.getElementById('edPeriod').style.borderColor='#d95f57';
            </script>";
            }
            else{
                $edPeriod = $_POST['edPeriod'];

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
            }

            //specialty
            if(empty($_POST['specialty'])){
                $specialtyError = "Παρακαλώ επιλέξτε ειδικότητα. ";
                echo "<script>document.getElementById('specialty').style.borderColor='#d95f57';</script>";
            }
            else{
                $specialty = $_POST['specialty'];
            }

            //semester
            if(empty($_POST['semester'])){
                $semesterError = "Παρακαλώ επιλέξτε εξάμηνο. ";
                echo "<script>document.getElementById('semester').style.borderColor='#d95f57';</script>";
            }
            else{
                $semester = $_POST['semester'];
            }

             //class
            if(empty($_POST['class'])){
                $classError = "Παρακαλώ επιλέξτε τμήμα. ";
                echo "<script>document.getElementById('class').style.borderColor='#d95f57';</script>";
            }
            else{
                $class = $_POST['class'];
            }

            //subject
            if(empty($_POST['subject'])){
                $subjectError = "Παρακαλώ επιλέξτε μάθημα. ";
                echo "<script>document.getElementById('subject').style.borderColor='#d95f57';</script>";
            }
            else{
                $subject = $_POST['subject'];
            }

            //pdf
            if(!empty($edPeriod) && !empty($specialty) && !empty($semester) && !empty($class) && !empty($subject)){

            }
            else{
                echo "<script>alert('".$edPeriodError. $specialtyError . $semesterError . $classError . $subjectError."');</script>";
            }
        }
    }
?>

</html>
