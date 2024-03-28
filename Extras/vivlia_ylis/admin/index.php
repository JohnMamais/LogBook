<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Δ.Σ.Α.Ε.Κ. Αιγάλεω: Διαχείρηση</title>

    <link rel="stylesheet" href="../mainStyleSheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <?php 
            include_once '../databaseConnection.php';
        ?>
</head>
<body>
    <h1>Δημιουργία Τμημάτων</h1>

    <form method="post" action="">

        <!-- select year -->
        <label for="year">Έτος: </label>
        <input type="number" min="2000" max="2099" step="1" name="year">

        <!-- select educational period -->
        <label for="ed_period">Περίοδος: </label>
        <select name ="ed_period">
            <option value="a">Α' (Εαρινή) </option>
            <option value="b">Β' (Χειμερινή) </option>
        </select>

        <!-- select specialty -->
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

        <!-- select semester -->
        <label for="semester">Εξάμηνο: </label>
        <select name="semester">
            <optgroup label="Χειμερινά:">
                <option value="a">A'</option>
                <option value="c">Γ'</option>
            </optgroup>
            <optgroup label="Εαρινά:">
                <option value="b">Β'</option>
                <option value="d">Δ'</option>
            </optgroup>
        </select>

        <!-- set number of classes -->
        <label for="num_of_classes">Αριθμός Τμημάτων:</label>
        <input type="number" min="1" max="5" step="1">

        <!-- insert active subjects -->
        <div id="available_subjects_div">
        </div>
            
        <br><br>
        <button type="submit" value="submit">Δημιουργία Τμήματος</button>
    </form>

    <script> // getting available subjects
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
</body>
</html>