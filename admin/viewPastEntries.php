<!DOCTYPE html>
<html lang="en">
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
    ?>
    <h1>Εκτύπωση Εγγραφών από το Βιβλίο Ύλης</h1>

    <!--main form for user input-->
    <form name="pastEntriesForm" method="post" action="">

        <!-- edPeriod -->
        <label for="edPeriod">Ακαδημαϊκή Περίοδος: </label>
        <select name="edPeriod" id="edPeriod">
            <option>Επιλέξτε Ακαδημαϊκή Περίοδο</option>
            <?php 
                //fetching data from database for edPeriod
                $query = "SELECT id, year, season FROM edPeriod;";
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
            <option value="">Επιλέξτε Ειδικότητα</option>
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
            <option value="">Επιλέξτε Εξάμηνο</option>
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
            <option value="">Επιλέξτε Μάθημα</option>
        </select>

        <br><br>
        <!--displaying results using ajax-->
        <div></div>
        <button type="submit">Εκτύπωση σε PDF</button>
        <button type="reset">Απαλοιφή</button>
    </form>

    <!--JAVASCRIPT AJAX SCRIPTS-->

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
                    }
                })
            });
        });
    </script>

    <!-- getting number of classes for selected entity -->
    <script>
        $(document).ready(function(){
            $('#edPeriod').change(function(){
                $.ajax({
                    type: 'POST',
                    url: 'getNumOfClasses_viaEdPeriod.php',
                    data: {edPeriod: $('#edPeriod').val(), specialty: $('#specialty').val(), semester: $('#semester').val()},
                    success: function (getNumOfClasses){
                     $('#class').html(getNumOfClasses);
                    }
                })
            })
        })
    </script>
</body>
</html>