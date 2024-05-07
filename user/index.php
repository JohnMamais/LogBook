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

        //handling of intruders
        //performing log out routine, redirect to login and logging to the DB
        if(!isset($_SESSION['user']) || ($_SESSION['isAdmin']!=0 && $_SESSION['isAdmin']!=2)){

            $log="Unauthorized user attempted to acces user index.";
            if(isset($_SESSION['user'])){
              $username=$_SESSION['user'];
              $log.="Username: $username";
            }
            $sql="INSERT INTO serverLog(logDesc) VALUES(?);";
            $stmt = $conn->prepare($sql);
            //binding parameters
            $stmt->bind_param("s",$log);
            if($stmt->execute()){
              //log inserted
            }
            //closing statment
            $stmt->close();
            $conn->close();
          //  header("Location: ../logout.php");
          //  exit();
        } else {
            $username=$_SESSION['user'];
            include 'mainform.php';
        }


    ?>



</body>
</html>
