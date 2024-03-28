<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Class</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="navbar.css">
</head>
<body>

  <div id="navbar">
    <li>
      <a href="createSubjects/createSubjects.php">Create Subjects</a>
    </li>
    <li>
      <a href="index.php">Create Classes</a>
    </li>
    <li>
      <a href="previewClasses/previewClasses.php">Preview Classes</a>
    </li>
  </div>

  <?php
    $servername = "localhost";
    $username = "root";
    $password = "3419exli_neal";
    $dbname = "log_book";
    $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);
  ?>

  <!-- CREATING CLASSES -->


  <div class="container">
    <form action="add_class.php" method="post">

      <!-- Selecting Semester -->

      <div>
        <label for='semester'>Select Semester</label>
        <select name='semester' id='semester'>
          <?php
            $sql = "SELECT * FROM edperiod";

            $result = $GLOBALS['conn']->query($sql);

            while($row = mysqli_fetch_assoc($result)){
              echo "<option value=" . $row['season'] . ">". $row["season"] . "</option>";
            }
          ?>
        </select>
      </div>

      <!-- Selecting Specialty -->
      <div>
        <label for='specialty'>Select Specialty</label>
        <select name='specialty' id='specialty'>
          <?php
            $sql = "SELECT * from specialty";
            $result = $GLOBALS['conn']->query($sql);

            while($row = mysqli_fetch_assoc($result)){
              echo "<option value=" . $row['specialtyID'] . ">". $row["name"] . "</option>";
            }
          ?>
        </select>
      </div>

      <!-- Selecting how many classes -->
      <div>
        <label for="classes">Number of Classes</label>
        <input type="number" name="classes" id="classes" min="1" max="4">
      </div>


      <hr>

      <div class="subjects">

      </div>

      <hr>

      <div id="cont-buttons">
        <input type="submit" value="Submit"></input>
        <input type="reset"></input>
      </div>

      <!-- Adding Subjects -->

      <script>
        // Call function when specialty is changed
        $(document).ready(function(){
          $('#specialty').change(function (){

            $.ajax({
                  url:"add_class.php",    //the page containing php script
                  data: {fun2call: 'loadSubjects', semester: $('#semester').val(), specialty: $('#specialty').val()},
                  type: "post",    //request type,
                  success:function(fun2call){
                      $('.subjects').html(fun2call);
                  }
              });
          });
        });

        // Call function when semester is changed
        $(document).ready(function(){
          $('#semester').change(function (){

            $.ajax({
                  url:"add_class.php",    //the page containing php script
                  data: {fun2call: 'loadSubjects', semester: $('#semester').val(), specialty: $('#specialty').val()},
                  type: "post",    //request type,
                  success:function(fun2call){
                      $('.subjects').html(fun2call);
                  }
              });
          });
        });
      </script>

      <?php

      ?>

    </form>
  </div>
</body>
</html>
