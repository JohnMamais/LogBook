<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Result</title>
</head>
<body>
    <h1>Query Result</h1>
    <?php

    include_once '../../Configs/Conn.php';

    // Get the SQL query from the form submission
    $query = $_POST['query'];

    // Execute the SQL query
    $result = $conn->query($query);

    // If query was successful, display results
    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr>";
            // Print column names
            $finfo = $result->fetch_fields();
            foreach ($finfo as $val) {
                echo "<th>".$val->name."</th>";
            }
            echo "</tr>";
            // Print data rows
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $val) {
                    echo "<td>".$val."</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    // Close connection
    $conn->close();
    ?>
</body>
</html>
