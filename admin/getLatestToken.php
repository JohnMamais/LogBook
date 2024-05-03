<?php
  header('Content-Type: application/json');

  include_once '../Configs/Conn.php';

  $sql="
  SELECT  token AS token, endDate AS expire
  FROM registrationTokens
  WHERE id=(SELECT MAX(id) FROM registrationTokens WHERE isActive=1);
  ";
  $stmt = $conn->prepare($sql);

  $empty="Non Active";
  $result = [];
  if ($stmt->execute()) {
      $stmt->bind_result($token, $expire); // Bind result variables
      if ($stmt->fetch()) {
          $result[] = ['token' => $token, 'expire' => $expire]; // Collect results in an array
      } else {
        $result[] = ['token' => "Δεν υπάρχει ενεργό token", 'expire' => null];
      }
  }

  $stmt->close(); // Close the statement

  // Return the response as JSON
  echo json_encode($result);
 ?>
