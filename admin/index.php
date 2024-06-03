<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω: Διαχείρηση</title>

    <!--<link rel="stylesheet" href="../Styles/adminStyleSheet.css">
    <link rel="stylesheet" href="../Styles/mainStyleSheet.css">-->
    <link rel="stylesheet" href="../Styles/semesterCreationStyleSheet.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

</head>
<body>

  <?php


    //PHP Setup
    //connecting to DB and including top menu
    include_once '../Configs/Conn.php';
    include_once '../Configs/Config.php';
    include_once '../common/commonFunctions.php';

    //handling of unauthorized users
    $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 0, 'super' => 1);
    include_once '../common/checkAuthorization.php';

  ?>
    <h1>Δημιουργία Τμημάτων</h1>

    
        <!-- main form -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <div id="mainPage" class="flexbox">
            <div id=leftMenu>

                <div id="selections">
                    <!-- select year -->
                    <label for="year">• Έτος: </label>
                    <input type="number" min="2000" max="2099" step="1" name="year" id="year" class="dropdown">

                    <!-- select educational period -->
                    <label for="edPeriod">• Περίοδος: </label>
                    <select name ="edPeriod" id="edPeriod" class="dropdown">
                        <option value="" selected disabled>Επιλέξτε Περίοδο</option>
                        <option value="a">Α' (Εαρινή) </option>
                        <option value="b">Β' (Χειμερινή) </option>
                    </select>

                    <!-- select specialty -->
                    <label for="specialty">• Eιδικότητα: </label>
                    <select name="specialty" id="specialty" class="dropdown">
                        <option value="" selected disabled>Επιλέξτε Ειδικότητα</option>
                        <?php
                                $query = "SELECT specialtyID, name FROM specialty;";
                                $result = $conn->query($query);

                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        echo "<option value='".$row['specialtyID']."'>".$row['name']."</option>";
                                    }
                                }
                                else{
                                    echo '<option value="">Δεν βρέθηκαν μαθήματα</option>';
                                }
                            ?>
                    </select>

                    <!-- select semester -->
                    <span id="semester_span">
                        <label for="semester">• Εξάμηνο: </label>
                        <select name="semester" id="semester" class="dropdown">
                        <option value=''selected disabled>Επιλέξτε Εξάμηνο</option>
                        </select>
                    </span>

                    <!-- set number of classes -->
                    <label for="numOfClasses">• Αριθμός Τμημάτων:</label>
                    <input type="number" min="1" max="5" step="1" id="numOfClasses" name="numOfClasses" class="dropdown">

                </div>
                 
                <br><br>

                <div id="buttonDiv">
                    <button type="submit" value="submit" name="submit">Δημιουργία Τμήματος</button> 
                    <button type="reset">Απαλοιφή</button>
                </div>

            </div>

             <!-- insert active subjects -->
            <div id="available_subjects_div">
                <p>• Διαθέσιμα Μαθήματα<br><br>Παρακαλώ συμπληρώστε στα στοιχεία αριστερά για να εμφανιστούν τα διαθέσιμα μαθήματα.</p>
            </div>
          </div>  
        </form>
   

    <!-- AJAX for dynamic fields of the form -->

    <!-- getting available subjects -->
    <script>
    $(document).ready(function(){ //όταν είναι ready το αρχείο
        $('#specialty').change(function(){//.change() ενεργοποιείται όταν αλλάζει το στοιχείο
            $.ajax({//update σελίδας χωρίς reload
                type: 'POST',
                url: 'getAvailableSubjects.php',
                data: {get_subjects: 'get_subjects', specialty: $('#specialty').val()},
                success: function (get_subjects){
                      $('#available_subjects_div').html(get_subjects);
                }
            })
        });
    });
    </script>

    <!-- restricting available semesters -->
    <script>
        $(document).ready(function(){
            $('#edPeriod').change(function(){
            $.ajax({
                type: 'POST',
                url: 'getAvailableSemesters.php',
                data: {edPeriod: $('#edPeriod').val()},
                success: function (get_semesters){
                    console.log("Received semesters:", get_semesters);
                      $('#semester_span').html(get_semesters);
                }
            })
        });
    });
    </script>


    <!-- check all -->
    <script>

    $(document).ready(function() {
        $(document).on('change', '#checkAllA', function() {
            $('.CheckboxA').prop('checked', $(this).prop('checked'));
        });
        $(document).on('change', '#checkAllB', function() {
            $('.CheckboxB').prop('checked', $(this).prop('checked'));
        });
        $(document).on('change', '#checkAllC', function() {
            $('.CheckboxC').prop('checked', $(this).prop('checked'));
        });
        $(document).on('change', '#checkAllD', function() {
            $('.CheckboxD').prop('checked', $(this).prop('checked'));
        });
    });

    </script>

<!-- Getting the data from the form PHP HANDLING -->
<?php
    if(isset($_POST['submit'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //initializing error variables
            $yearError = $edPeriodError = $specialtyError = $semesterError = $numOfClassesError = $selectedSubjectsError = "";

            //intializing value variables
            $year = $edPeriod = $specialty = $semester = $numOfClasses = $selectedSubjects = "";

            //checking input for all data and passing them into php variables if filled out

            //year
            if(empty($_POST['year'])){
                $yearError = "Παρακαλώ επιλέξτε έτος! ";
                echo "<script>
                        document.getElementById('year').style.borderColor='#d95f57';
                    </script>";
            }
            else{
                $year = $_POST['year'];
                $year = trim($year);
                $year = stripslashes($year);
                $year = htmlspecialchars($year);

            }

            //edPeriod
            if(empty($_POST['edPeriod'])){
                $edPeriodError = "Παρακαλώ επιλέξτε διδακτική περίοδο! ";
                echo "<script>
                        document.getElementById('edPeriod').style.borderColor='#d95f57';
                    </script>";
            }
            else{
                $edPeriod=$_POST['edPeriod'];
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

            //numOfClasses
            if(empty($_POST['numOfClasses'])){
                $numOfClassesError = "Παρακαλώ επιλέξτε αριθμό τμημάτων. ";
                echo "<script>document.getElementById('numOfClasses').style.borderColor='#d95f57';</script>";
            }
            else{
                $numOfClasses = $_POST['numOfClasses'];
                $numOfClasses = trim($numOfClasses);
                $numOfClasses = stripslashes($numOfClasses);
                $numOfClasses = htmlspecialchars($numOfClasses);

            }

            //selectedSubjects
            if(empty($_POST['selectedSubjects'])){
                $selectedSubjectsError = "Παρακαλώ επιλέξτε τουλάχιστον ένα μάθημα για το εξάμηνο. ";
                echo "<script>document.getElementById('selectedSubjects').style.borderColor='#d95f57';</script>";
            }
            else{
                if (isset($_POST['selectedSubjects']) && is_array($_POST['selectedSubjects'])) {
                    // Process the selected checkbox values
                    $selectedSubjects = $_POST['selectedSubjects'];
                }
            }

            //inputing data to the database by creating the selected entitites
            if(!empty($year) && !empty($edPeriod) && !empty($specialty) && !empty($semester) && !empty($numOfClasses) && !empty($selectedSubjects)){

                // ----- STEPS TO COMPLETE THE ACTION -----

                //1) check to see if the edPeriod with the selected "year" and "edPeriod" exists in the Database
                    // and create it if it does not already exist

                //2) create a class with edPeriodID(from previous step), specialtyID, semester and numOfClasses

                //3) make the neccesary activesubjects entries with subjectID, specialtyID and classID

                //firstly check to see if the edPeriod already exists in the database
                $query = "SELECT id FROM edperiod WHERE year = " . $year . " AND season = '". $edPeriod ."';";
                $result = $conn->query($query);

                //in    case the edPeriod already exists
                if($result->num_rows != 0){
                    //------ STEP 1 ----
                    //saving the edPeriod's id
                    $row = $result->fetch_assoc();
                    $edPeriodID = $row['id'];

                    echo "<br>";
                        echo $numOfClasses;

                    //-------- STEP 2 -------

                    $query = "INSERT INTO class (specialtyID, edPeriodID, semester, numOfClasses) VALUES ( $specialty, $edPeriodID, '$semester', $numOfClasses);";
                    if ($conn->query($query) === TRUE){

                        //fetching and saving the id of the class we just created
                        $query = "SELECT id FROM class WHERE specialtyID = $specialty AND edPeriodID = $edPeriodID AND semester = '$semester';";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        $classID = $row['id'];

                        //------- STEP 3 -------
                        foreach($selectedSubjects as $subject){
                            $query = "INSERT INTO activesubjects (subjectID, specialtyID, classID) VALUES ($subject, $specialty, $classID);";
                            if ($conn->query($query) === TRUE){
                                continue;
                            }
                            else{
                                $log.= "Error: " . $query . "<br>" . $conn->error." | ";
                                break;
                            }
                        }
                        echo "<script>alert('Το τμήμα δημιουργήθηκε και τα μαθήματα προστέθηκαν επιτυχώς!');</script>";
                    }
                    //error in creating class
                    else{
                        $log.= "create class Err.: " . $query . $conn->error. " | ";

                        $log.= "numOfCl:".$numOfClasses." | ";
                    }
                }

                //in case edPeriod does not exist
                else{
                    // ------ STEP 1 -----
                    //create the edPeriod in the database.
                    $query = "INSERT INTO edperiod (year, season) VALUES (". $year . ", '" . $edPeriod . "' );";
                    if ($conn->query($query) === TRUE) {

                        //fetching and saving the id of the edperiod we just created
                        $query = "SELECT id FROM edperiod WHERE year = " . $year . " AND season = '". $edPeriod ."';";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        $edPeriodID = $row['id'];

                        //-------- STEP 2 -------

                        $query = "INSERT INTO class (specialtyID, edPeriodID, semester, numOfClasses) VALUES ( $specialty, $edPeriodID, '$semester', $numOfClasses);";
                        if ($conn->query($query) === TRUE){

                            //fetching and saving the id of the class we just created
                            $query = "SELECT id FROM class WHERE specialtyID = $specialty AND edPeriodID = $edPeriodID AND semester = '$semester';";
                            $result = $conn->query($query);
                            $row = $result->fetch_assoc();
                            $classID = $row['id'];

                            //------- STEP 3 -------
                            foreach($selectedSubjects as $subject){
                                $query = "INSERT INTO activesubjects (subjectID, specialtyID, classID) VALUES ($subject, $specialty, $classID);";
                                if ($conn->query($query) === TRUE){
                                    continue;
                                }
                                else{
                                    $log.= "Error: " . $query . $conn->error . " | ";
                                    break;
                                }
                            }
                            echo "<script>alert('Το τμήμα δημιουργήθηκε και τα μαθήματα προστέθηκαν επιτυχώς!');</script>";
                        }
                        //error in creating class
                        else{
                            $log.= "Error: " . $query . $conn->error . " | ";
                        }
                    }
                    //error in creating edPeriod
                    else {
                        $log.= "Error: " . $query .  $conn->error . " | ";
                    }
                }
            }

            //error in case fields are empty
            else{
                echo "<script>alert('".$yearError. $specialtyError . $semesterError . $edPeriodError . $numOfClassesError . $selectedSubjectsError ."');</script>";
                $log.= "Empty: ". $yearError. $specialtyError . $semesterError . $edPeriodError . $numOfClassesError . $selectedSubjectsError . " | ";
                }

            if(isset($log)){
              insertLog($conn, $log);
            }
        }
    }

?>

</body>
</html>
