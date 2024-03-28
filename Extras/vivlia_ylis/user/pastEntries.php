<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="logBookMainStyleSheet.css">
    <title>Document</title>
</head>
<body>
    <?php 
        //database connection file
        include_once '../databaseConnection.php';
        $currentSemester;
    ?>
    <h1>Προηγούμενες Εγγραφές</h1>
    <form action="" method="post" >
        <label for="specialty">Ειδικότητα: </label>
        <select name="specialty">
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
        
        <label for="semester">Εξάμηνο: </label>
        <select name="semester" id="semester">
            <option value="">Επιλέξτε Εξάμηνο</option>
        </select>

        <label for="class">Τμήμα: </label>
        <select name="class" id="class">
            <option value="">Επιλέξτε Τμήμα</option>
        </select>

        <label for="subject">• Μάθημα: </label>
        <select  name="subject" id="subject">
            <option value="">Επιλέξτε Μάθημα</option>
        </select>
    </form>

</body>
</html>