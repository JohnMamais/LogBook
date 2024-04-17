<?php
  //Server Info
  $serverName="localhost";
  $serverUsername="bookAdmin";
  $password="Log_Book_2024_IEK_AIGALEO@adminuser";
  $dbname="log_book";

  //connecting to database
  $GLOBALS['conn'] = mysqli_connect($serverName, $serverUsername, $password, $dbname);
  if(!$conn){
      die("Connection to database failed.". mysqli_connect_error());
  }

  $new_password = '$argon2id$v=19$m=65536,t=11,p=2$M2h2MlF1T1E1SXVrcWtPRg$KDchizFbhs2+vsYXCSoILZcI5tZ317VH2GBwQdG1L6E';
  $user_id=1;
  // Step 3: Update the user's password in the database
  // Assuming $db_connection is your database connection object
  $update_query = "UPDATE user SET password = ? WHERE id = ?";
  $stmt = $db_connection->prepare($update_query);
  $stmt->bind_param("si", $new_password, $user_id);
  $stmt->execute();

  // Check if the update was successful
  if ($stmt->affected_rows > 0) {
      echo "Password updated successfully!";
  } else {
      echo "Failed to update password.";
  }
 ?>
