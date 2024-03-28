<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="logBookMainStyleSheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <title>Βιβλίο Ύλης Δ.Ι.Ε.Κ. Αιγάλεω</title>
</head>
<body>

    <?php 
        include_once 'databaseConnection.php';
    ?>
    <div class="grid-container">
        <div class="grid-item">← Επιστροφή</div>
        <div class="grid-item">Εγγραφή Μαθήματος</div>
        <div class="grid-item">Προηγούμενες Εγγραφές</div>
        <div class="grid-item">Log Out</div>
    </div>
    <h1>• Ηλεκτρονικό Βιβλίο Ύλης •</h1>

    <form  method="POST" action="<?php echo htmlspecialchars('logBookEntryProcess.php');?>">

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
                    echo '<option value="">Δεν βρέθηκαν μαθήματα</option>';
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
        <p>Διδάσκων/ουσα: </p>
        <br>
        <button type="submit" value="submit" id="submit" name="submit">Υποβολή</button> &emsp; <button type="reset">Αρχικοποίηση</button>
    </form>

    <div id="myFooter">
        <p>Τμήμα ΤΕΠ • Γ'2 • 2023<br>Ιωάννης Μαμάης • Ηλίας Μοτσενίγος • Ιάκωβος Χαραλαμπόπουλος</p>
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
            $('#specialty').change(function(){//.change() ενεργοποιείται όταν αλλάζει το στοιχείο
                $.ajax({//update σελίδας χωρίς reload
                    type: 'POST',
                    url: 'getActiveSubjects.php',
                    data: {get_subjects: 'get_subjects', specialty: $('#specialty').val()},
                    success: function (get_subjects){
                            $('#subject').html(get_subjects);
                    }
                })
            });
        });
    </script>

<!-- form data processing-->
<?php
    if(isset($_POST['submit'])){
        echo "<script>document.getElementById('specialty').style.border=2px solid red;</script>";
    }
?>


</body>
</html>