<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/usernavbar.css">
    <link rel="stylesheet" href="../Styles/TeacherStyleSheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <title>Βιβλίο Ύλης Δ.Ι.Ε.Κ. Αιγάλεω</title>
</head>
<body>

    <?php
        include_once '../Configs/Conn.php';
        include_once '../Configs/Config.php';

        //handling of unauthorized users
        $_PERMISSIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);
        include_once '../common/checkAuthorization.php';


        $username=$_SESSION['user'];
        include 'mainform.php';

    ?>



</body>
</html>
