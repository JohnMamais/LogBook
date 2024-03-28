<?php
        //database server info
        $serverName = 'localhost';
        $serverUsername = 'root';
        $password = '*LetM31nH03!';
        $dbname = "Log_Book";

        //connecting to database
        $GLOBALS['conn'] = mysqli_connect($serverName, $serverUsername, $password, $dbname);
        if(!$conn){
            die("Connection to database failed.". mysqli_connect_error());
        }
    ?>