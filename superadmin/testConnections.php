<?php
echo "Heeeeeeelp!!!";


function testConnection($host, $user, $password, $database, $connType){
	//connecting
	$conn = mysqli_connect($host, $user, $password, $database);

	if (!$conn) {
		echo "Nope!";
		die("Connection failed: " . mysqli_connect_error());
	} else {
		echo "$connType Connected successfully<br>";
	}

	$conn->close();

}


//Testing connections
testConnection("localhost","teacher","Log_Book_2024_IEK_AIGALEO@teacheruser","log_book","Teacher");
testConnection("localhost","bookAdmin","Log_Book_2024_IEK_AIGALEO@adminuser","log_book","Admin");
testConnection("localhost","login","Log_Book_2024_IEK_AIGALEO@login","log_book","Login");

?>
