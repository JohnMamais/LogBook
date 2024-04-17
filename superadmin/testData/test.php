<?php
include_once 'conn.php';

$query = "SELECT COUNT(id) AS count FROM edperiod;"; // Alias the COUNT(id) as 'count'
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    echo $row['count']; // Access the result using the alias
} else {
    echo "Error: " . $conn->error;
}

 ?>
