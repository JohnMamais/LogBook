<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Εγγραφές Βιβλίων Ύλης</title>
</head>
<body>
    <h1>Εκτύπωση Εγγραφών από το Βιβλίο Ύλης</h1>

    <!--main form for user input-->
    <form name="pastEntriesForm" method="post" action="">
        <label for="edPeriod">Ακαδημαϊκή Περίοδος: </label>
        <select name="edPeriod" id="edPeriod">
            <option>Επιλέξτε Ακαδημαϊκή Περίοδο</option>
        </select>
        <br>
        <label for="specialty">Ειδικότητα: </label>
        <select name="specialty" id="specialty">
            <option value="">Επιλέξτε Ειδικότητα</option>
        </select>
        <br>
        <label for="semester">Εξάμηνο: </label>
        <select name="semester" id="semester">
            <option value="">Επιλέξτε Εξάμηνο</option>
        </select>
        <br>
        <label for="class">Τμήμα: </label>
        <select name="class" id="class">
            <option value="">Επιλέξτε Τμήμα</option>
        </select>
        <br>
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

    
</body>
</html>