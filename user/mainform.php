<?php
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
 <h1>• Ηλεκτρονικό Βιβλίο Ύλης •</h1>

<!--main form-->
<form  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

<fieldset id="mainInfo">
    <label for="entryDate">• Ημερομηνία</label>
    <input type="date" name="entryDate" id="entryDate">

    <label for="specialty">• Eιδικότητα: </label>
    <select name="specialty" id="specialty">
    <option value="">Επιλέξτε Ειδικότητα</option>
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
            <option value="">Επιλέξτε Εξάμηνο</option>
        </select>
    </span>

    <label for="class">• Τμήμα: </label>
        <span id="class_span">
        <select name="class" id="class">
        <option value="">Επιλέξτε Τμήμα</option>
        </select>
    </span>

    <label for="subject">• Μάθημα: </label>
    <span id="subject_span">
        <select  name="subject" id="subject">
            <option value="">Επιλέξτε Μάθημα</option>
        </select>
    </span>

    </fieldset>
    <br>

    <fieldset id="periodField">
        <legend>Διδακτικές Ώρες:</legend>
        <label for="period_0">0η ώρα</label>
        <input type="checkbox" id="period_0" name="period[]" value="0">&emsp;
        <label for="period_1">1η ώρα</label>
        <input type="checkbox" id="period_1" name="period[]" value="1">&emsp;
        <label for="period_2">2η ώρα</label>
        <input type="checkbox" id="period_2" name="period[]" value="2">&emsp;
        <label for="period_3">3η ώρα</label>
        <input type="checkbox" id="period_3" name="period[]" value="3">&emsp;
        <label for="period_4">4η ώρα</label>
        <input type="checkbox" id="period_4" name="period[]" value="4">&emsp;
        <label for="period_5">5η ώρα</label>
        <input type="checkbox" id="period_5" name="period[]" value="5">&emsp;
        <label for="period_6">6η ώρα</label>
        <input type="checkbox" id="period_6" name="period[]" value="6">&emsp;
    </fieldset>
    <br>
    <textarea name="entry" id="entry" cols="50" rows="10" maxlength="512"></textarea>
    <br>
    <p id="teacher-info">Διδάσκων/ουσα: <?php echo "• $fname $lname ($username)";?></p>
    <br>
    <div style="text-align:center;">
        <button type="submit" value="submit" id="submit" name="submit">Υποβολή</button> &emsp; <button type="reset">Απαλοιφή</button>
    </div>
</form>
<!-- log out
<form action="logoutscript.php" method="post">
    <div style="text-align:center;">
        <button type="submit" value="submit" id="logout " name="submit">Αποσύνδεση</button>
    </div>
</form>
-->

<div id="myFooter">
    <p>Τμήμα ΤΕΠ • Δ'2 • 2024<br>Ιωάννης Μαμάης • Ηλίας Μοτσενίγος</p>
</div>

<!--JAVASCRIPT SCRIPTS-->

<script>// getting available semesters
     $(document).ready(function(){ //όταν είναι ready το αρχείο
        $('#entryDate').change(function(){//.change() ενεργοποιείται όταν αλλάζει το στοιχείο
            $.ajax({//update σελίδας χωρίς reload
                type: 'POST',
                url: 'getSeasons.php',
                data: {getDate: 'getDate', date: $('#entryDate').val()},
                success: function (getSeasons){
                     $('#semester').html(getSeasons);
                }
            })
        });
    });
</script>

<script> //getting available classes
     $(document).ready(function(){ //όταν είναι ready το αρχείο
        $('#semester').change(function(){//.change() ενεργοποιείται όταν αλλάζει το στοιχείο
            $.ajax({//update σελίδας χωρίς reload
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
    $(document).ready(function(){ //όταν είναι ready το αρχείο
        $('#semester').change(function(){//.change() ενεργοποιείται όταν αλλάζει το στοιχείο
            $.ajax({//update σελίδας χωρίς reload
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
