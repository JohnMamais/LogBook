<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Subjects</title>
  <link rel="stylesheet" href="../navbar.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  <link rel="stylesheet" href="style.css">
</head>
<body>

  <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "log_book";
    $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);
  ?>

  <div id="navbar">
    <li>
      <a href="createSubjects.php">Create Subjects</a>
    </li>
    <li>
      <a href="../index.php">Create Classes</a>
    </li>
    <li>
      <a href="../previewClasses/previewClasses.php">Preview Classes</a>
    </li>
  </div>

  <div class="container">
    <?php

      $sql = 'SELECT specialty.name spname, specialty.specialtyID as spID from specialty';
      $result = mysqli_query($GLOBALS['conn'], $sql);

      while ($row = mysqli_fetch_array($result)) {

        echo "<div class='specialty' id='" . $row["spname"] . "'>"; //Open specialty-container
        echo "<div class='specialty-title'><p>" . $row["spname"] . "</p></div>"; //Open and close specialty-title

        echo "<div class='subject-container'>"; //Open subject-container
        $sql2 = 'SELECT subject.name as suname, subject.subjectID from subject where subject.specialtyID = '.$row["spID"];
        $result2 = mysqli_query($GLOBALS['conn'], $sql2);

        while ($row2 = mysqli_fetch_array($result2)) {
            echo "<label class='subject' for='" .$row2["subjectID"]. "'>" . $row2["suname"] . "</label>";
            echo "<input type='checkbox' id='subject' class='subject' name='". $row2["subjectID"]."'/>";        
        }

        echo "</div>"; //Close subject container

        // Active Subjects
        $sql3 = 'SELECT su.name, su.subjectID from subject as su, activesubjects as asu where su.specialtyID = '.$row["spID"]. " and " . $row["spID"] . " = asu.specialtyID and asu.subjectID = su.subjectID";
        $result3 = mysqli_query($GLOBALS["conn"], $sql3);
        
        while ($row3 = mysqli_fetch_array($result3)) {
          echo "<label class='subject' for='" .$row3["subjectID"]. "'>" . $row3["name"] . "</label>";
        }
        

        echo "</div>"; //Close specialty
        echo "<br>";
      }

      
    ?>
  </div>
  <!-- 
  <script>
    $(document).ready(function(){
        var sp_list = document.querySelectorAll('.specialty');
        var sp_array = [...sp_list];
        console.log(sp_array)
        sp_array.forEach(specialty => {
          console.log(specialty.innerHTML);
          $.spec = specialty.innerHTML;
          $.sp = specialty;
          
          $.ajax({
                  url:"loadSubjects.php",    //the page containing php script
                  data: {fun2call: 'loadSubjects', specialty: $.spec},
                  type: "post",    //request type,
                  success:function(fun2call){
                      $($.sp).html(fun2call);
                  }
              });
        });
          
    });
  </script>
  -->
</body>
</html>