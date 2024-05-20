<?php

//handling of unauthorized users
$_PERMISSIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);
include_once '../common/checkAuthorization.php';

    echo "<link rel='stylesheet' href='logBookMainStyleSheet.css'>";
    function formatString($inputString){ //cleaning up strings
        $inputString = trim($inputString);
        $inputString = stripslashes($inputString);
        $inputString = htmlspecialchars($inputString);
        return $inputString;
    }

    echo " <div class='grid-container'>
                <div class='grid-item'>← Επιστροφή</div>
                <div class='grid-item'>Εγγραφή Μαθήματος</div>
                <div class='grid-item'>Προηγούμενες Εγγραφές</div>
                <div class='grid-item'>Log Out</div>
         </div>";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $entryDate = $specialty = $semester = $class = $subject = $hours = $entry = "";

        $entryDate = $_POST['entryDate'];
        $specialty = $_POST['specialty'];
        $semester = $_POST['semester'];
        $class = $_POST['class'];
        $subject = $_POST['subject'];
        $hours = $_POST['period'];
        $entry = formatString($_POST['entry']);

        if(isset($entryDate)&& isset($specialty) && isset($semester) && isset($class) && isset($subject) && isset($hours) && isset($entry)){
            echo "<script>alert('Τα στοιχεία σας αποθηκεύτηκαν. Ευχαριστούμε.')</script>";
            echo "Ημερομηνία: $entryDate <br>";
            echo "Ειδικότητα: $specialty <br>";
            echo "Εξάμηνο: $semester<br>";
            echo "Τμήμα: $class<br>";
            echo "Μάθημα: $subject<br>";
            echo "Ώρες: $hours<br>";
            echo "Περιγραφή: $entry<br>";
        }
        else{
            echo "<p id='error',
            style='background-color: tomato;
            border-radius: 10px;
            padding:10px;
            font-family: sans-serif;
            color: white;
            text-align: center;'    >Παρακαλώ συμπληρώστε όλα τα πεδία και προσπαθήστε ξανά.</p>";
        }
    }

?>
