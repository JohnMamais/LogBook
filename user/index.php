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
    //database connection file
        include_once '../databaseConnection.php';

        session_start();
        //$_SESSION['user'] = 'john_doe';

        echo "Sess: ". $_SESSION['user'];
        $username=$_SESSION['user'];

        if($username==''){
            echo "<p>Δεν έχετε πρόσβαση σε αυτή τη σελίδα. Συνδεθείτε <a href='../index.php'>εδώ</a>.</p>";
        }
        else{
            include 'mainform.php';
        }


    ?>



</body>
</html>
