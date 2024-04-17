<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Query Executor</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#execute_query").click(function(){
                var query = $("#query").val();
                $.ajax({
                    url: 'execute_query.php',
                    type: 'post',
                    data: {query: query},
                    success: function(response){
                        $("#query_result").html(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
  <?php
    include_once '../../Configs/Conn.php';
    include_once '../../Configs/Config.php';
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
        header("Location: __ROOT__/logout.php");
        exit();
    } else {

    }

  ?>
    <h1>SQL Query Executor</h1>
    <textarea id="query" rows="5" cols="50" placeholder="Enter your SQL query here"></textarea><br>
    <button id="execute_query">Execute Query</button>
    <div id="query_result"></div>
</body>
</html>
