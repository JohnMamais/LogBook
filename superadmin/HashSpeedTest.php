<?php
/**
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 10 is a good baseline, and more is good if your servers
 * are fast enough. The code below aims for ≤ 350 milliseconds stretching time,
 * which is an appropriate delay for systems handling interactive logins.
 */
 include_once '../Configs/Conn.php';
 include_once '../Configs/Config.php';
 //handling of intruders
 //performing log out routine, redirect to login and logging to the DB
 if(!isset($_SESSION['user']) || $_SESSION['isAdmin']!=2){

     $log="Unauthorized user attempted to acces admin index.";
     if(isset($_SESSION['user'])){
       $uname=$_SESSION['user'];
       $log.="Username: $uname";
     }
     $sql="INSERT INTO serverLog(logDesc) VALUES(?);";
     $stmt = $conn->prepare($sql);
     //binding parameters
     $stmt->bind_param("s",$log);
     if($stmt->execute()){
       //meow
       //log inserted
     }
     //closing statment
     $stmt->close();
     $conn->close();
     header("Location: ../logout.php");
     exit();
 }
$timeTarget = 0.35; // 350 milliseconds

$cost = 5;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_ARGON2ID, ['memory_cost' => 65536, // 64 MB
                                              'time_cost'   => $cost,
                                              'threads'     => 4,     // 3 threads
                                            ]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost;
?>
