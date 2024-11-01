<?php
   /*
    Author: Ilias Motsenigos
    Date: 12/12/2023
    Last Updated: 25/5/2024
    Description: This page serves as an online tool for teachers to log and manage their teaching activities. The form allows teachers 
                to input specific details about the lessons they conduct and submit this information to the server for storage 
                and later retrieval. The main form includes input fields for a date input for specifying the date of the lesson, 
                a dynamically populated dropdown menu for selecting class's specialty from the database, a dropdown menu for choosing 
                the semester (initially empty and intended to be populated based on the date), a dropdown menu for selecting the class 
                (dynamically populated based on the chosen semester), and a dropdown menu for selecting the subject (populated based on 
                the chosen class). Teachers can select the teaching periods using checkboxes for each hour (0th to 6th hour). There is 
                also a large text area for inputting detailed information about the lesson. The logged-in teacher's name and username 
                are also displayed and recorded. The form includes a "Submit" button to send the data to the server for processing 
                and storage, and a "Reset" button to clear all inputs. Additionally, the page features a section for past entries, 
                allowing users to view recent entries related to the selected subject.
                Form data is submitted using the POST method to the same PHP file for processing. PHP handles form submissions, 
                retrieves data from the database, and dynamically populates dropdown menus through JavaScript's JQuery and AJAX. 
                The page includes necessary form validation and error handling to ensure robust data entry and submission.
    */


  //handling of unauthorized users
  $_PERMISSIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);
  include_once '../common/checkAuthorization.php';

  //getting first and last name of user from the database based on their username
  $fname = $lname = $userid = "";
  $userid=$_SESSION['user_id'];
  $nameQuery = "SELECT fname, lname FROM USER WHERE username = '$username';";
  $result = $GLOBALS['conn']->query($nameQuery);
  if ($result->num_rows>0){
      while($row = $result->fetch_assoc()){
          $fname = $row['fname'];
          $lname = $row['lname'];
      }
  }
?>
<div id="pageTitle">
    <h1>• Ηλεκτρονικό Βιβλίο Ύλης •</h1>
</div>

<!--main form-->
<div class="flexbox" id="mainpage">

    <div id="entryInfo">
        <form  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <div id="mainInfo">
                <fieldset id="mainInfoFieldset">
                    <label for="entryDate">• Ημερομηνία</label>
                    <input type="date" name="entryDate" id="entryDate">
                    <br>

                    <label for="specialty">• Eιδικότητα: </label>
                    <select name="specialty" id="specialty">
                    <option value="" disabled selected>Επιλέξτε Ειδικότητα</option>
                    <?php
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

                    <label for="semester">• Εξάμηνο: </label>
                    <span id=semester_span>
                        <select name="semester" id="semester">
                            <option value="" disabled selected>Επιλέξτε Εξάμηνο</option>
                        </select>
                    </span>
                    <br>
                    <label for="class">• Τμήμα: </label>
                        <span id="class_span">
                        <select name="class" id="class">
                        <option value="" disabled selected>Επιλέξτε Τμήμα</option>
                        </select>
                    </span>

                    <label for="subject">• Μάθημα: </label>
                    <span id="subject_span">
                        <select  name="subject" id="subject">
                            <option value="" disabled selected>Επιλέξτε Μάθημα</option>
                        </select>
                    </span>

                    </fieldset>
            </div>
            <br>
            <div id="secondaryInfoContainer">
                <fieldset id="periodField">
                    <legend>• Διδακτικές Ώρες •</legend>
                    <label for="period_0">0η ώρα</label>
                    <input type="checkbox" id="period_0" name="period[]" value="0"><br>
                    <label for="period_1">1η ώρα</label>
                    <input type="checkbox" id="period_1" name="period[]" value="1">&emsp;
                    <label for="period_2">2η ώρα</label>
                    <input type="checkbox" id="period_2" name="period[]" value="2">&emsp;
                    <label for="period_3">3η ώρα</label>
                    <input type="checkbox" id="period_3" name="period[]" value="3"><br>
                    <label for="period_4">4η ώρα</label>
                    <input type="checkbox" id="period_4" name="period[]" value="4">&emsp;
                    <label for="period_5">5η ώρα</label>
                    <input type="checkbox" id="period_5" name="period[]" value="5">&emsp;
                    <label for="period_6">6η ώρα</label>
                    <input type="checkbox" id="period_6" name="period[]" value="6">
                </fieldset>
                <br>
                <textarea name="entry" id="entry" cols="50" rows="10" maxlength="512"></textarea>
                <br>
            </div>
            <div>
                <p id="teacher-info">Διδάσκων/ουσα: <?php echo "• $fname $lname ($username)";?></p>
            </div>
            <br>
            <div style="text-align:center;">
                <button type="submit" value="submit" id="submit" name="submit">Υποβολή</button> &emsp; <button type="reset">Απαλοιφή</button>
            </div>
        </form>
    </div>
        <div id="pastEntries">
            <p>
                Επιλέξτε μάθημα για να εμφανιστούν πρόσφατες εγγραφές.
            </p>
        </div>
</div>

    <!--JAVASCRIPT AJAX SCRIPTS-->

<script>// getting available semesters
     $(document).ready(function(){
        $('#entryDate').change(function(){
            $.ajax({
                type: 'POST',
                url: 'getSeasons.php',
                data: {getDate: 'getDate', date: $('#entryDate').val()},
                success: function (getSeasons){
                     $('#semester').html(getSeasons);
                     //resetting dependent fields 
                     $('#class').html('<option value="" disabled selected>Επιλέξτε Τμήμα</option>');
                    $('#subject').html('<option value="" disabled selected>Επιλέξτε Μάθημα</option>');
                }
            })
        });
    });
</script>

<script> //getting available classes
     $(document).ready(function(){
        $('#semester').change(function(){
            $.ajax({
                type: 'POST',
                url: 'getNumOfClasses.php',
                data: {getNumOfClasses: 'getNumOfClasses', semester: $('#semester').val(), specialty: $('#specialty').val(), date: $('#entryDate').val()},
                success: function (getNumOfClasses){
                     $('#class').html(getNumOfClasses);
                }
            })
        });
    });
</script>


 <script> // getting available subjects
    $(document).ready(function(){
        $('#semester').change(function(){
            $.ajax({
                type: 'POST',
                url: 'getActiveSubjects.php',
                data: {get_subjects: 'get_subjects', specialty: $('#specialty').val(), date: $('#entryDate').val(), semester: $('#semester').val()},
                success: function (get_subjects){
                        $('#subject_span').html(get_subjects);
                }
            })
        });
    });
</script>

<script> // fetching recent entries for the selected class and subject
    $(document).ready(function(){
        $(document).on('change', '#subject', function(){
            $.ajax({
                type: 'POST',
                url: 'getRecentEntries.php',
                data: {
                    specialty: $('#specialty').val(),
                    date: $('#entryDate').val(),
                    semester: $('#semester').val(),
                    class: $('#class').val(),
                    subject: $('#subject').val()
                },
                success: function(response){
                    console.log("AJAX request successful");
                    $('#pastEntries').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.error('AJAX Error: ' + textStatus + ': ' + errorThrown);
                    $('#pastEntries').html('Error occurred while fetching entries.');
                }
            });
        });
    });

</script>

<!--------------------------------------------------->
<!-- form data processing-->
<?php
if(isset($_POST['submit'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //initializing error variables
        $dateError = $specialtyError = $semesterError = $classError = $subjectError = $periodError = $entryError = "";

        //initializing value variables
        $date = $specialty = $semester = $class = $subject = $periods = $entry= $season ="";

        //checking input for all data and passing them into php variables if filled

        //date
        if(empty($_POST['entryDate'])){
            $dateError = "Παρακαλώ επιλέξτε ημερομηνία. ";
            echo "<script>document.getElementById('entryDate').style.borderColor='#d95f57';
            </script>";
        }
        else{
            $date = $_POST['entryDate'];
            $year = substr($date, 0, 4);
            $month = substr($date,  5, 2);

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
            $season="";
            if($semester == 'a' || $semester == 'c'){
                $season = 'B';
            }
            elseif($semester == 'b' || $semester == 'd'){
                $season = 'A';
            }
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

        //taught periods
        if(empty($_POST['period'])){
            $periodError = "Παρακαλώ επιλέξτε διδακτικές ώρες. ";
            echo "<script>document.getElementById('periodField').style.borderColor='#d95f57';</script>";
        }
        else{
            if (isset($_POST['period']) && is_array($_POST['period'])) {
                // Process the selected checkbox values
                $periods = $_POST['period'];
                $periodsString = implode(" ",$periods); //converting the array to a string
            }
        }

        //entry
        if(empty($_POST['entry'])){
            $entryError = "Παρακαλώ συμπληρώστε την ύλη του μαθήματος. ";
            echo "<script>document.getElementById('entry').style.borderColor='#d95f57';</script>";
        }
        else{
            $entry = $_POST['entry'];
            $entry = trim($entry);
            $entry = stripslashes($entry);
            $entry = htmlspecialchars($entry);
        }

        if($season == 'B' && ($month == 01 || $month == 02)){
            $year -= 1;
        }


        if(!empty($date) && !empty($specialty) && !empty($semester) && !empty($class) && !empty($subject) && !empty($periods) && !empty($entry)){
            //adding the entry data to the system's database
            $sql = "INSERT INTO bookentry (date, specialtyID, semester, class, subjectID, periods, description, username, year, season)
            VALUES ('$date', $specialty, '$semester', $class, $subject, '$periodsString', '$entry', $userid, $year, '$season')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Οι εγγραφές προστέθηκαν επιτυχώς!');</script>";
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
        else{
        echo "<script>alert('".$dateError. $specialtyError . $semesterError . $classError . $subjectError . $periodError . $entryError."');</script>";
        }
    }
}
?>
