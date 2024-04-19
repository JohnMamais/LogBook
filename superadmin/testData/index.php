<!DOCTYPE HTML>
<head>

</head>
<html>
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
    header("Location: ../logout.php");
    exit();
}
 ?>
  <form name="createUsers" method="post" action="createUsers.php" id="userForm">
    Δημιουργία χρηστών:
    <input type="number" name="count"/>
    <button type="submit">Go</button>
    <p id="user"></p>
    <br>
  </form>
  <form name="setYears" method="post" action="initPeriods.php" id="yearForm">
    Δημιουργία δεδομένων απο χρονιά:
    <input type="number" name="min"/>
     έως χρονιά:
    <input type="number" name="max"/>
    <button type="submit">Go</button> <br>
    <p id="periods"></p>
    <br>
  </form>
  <form name="populateClasses" method="post" action="generateClasses.php" id="classesForm">
      Populate Classes:
      <button type="submit">Go</button>
      <p id="classes"></p>
      <br>
  </form>
  <form name="populateSubjects" method="post" action="generateSubjects.php" id="subjectsForm">
      Enable all subjects for period(s):
      <button type="submit">Go</button>
      <p id="subjects"></p>
      <br>
  </form>
  <form name="populateEntries" method="post" action="generateEntries.php" id="entriesForm">
      [WIP]Populate Entries:
      <button type="submit">Go</button> <br>
  </form>

</html>
<script>
document.getElementById("users").innerHTML="Done";

document.getElementById("userForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", this.action, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("user").innerHTML = "Done";
            document.getElementById("user").innerHTML = xhr.responseText;

        }
    };
    xhr.send(formData);
});

document.getElementById("yearForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", this.action, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("response").innerHTML = xhr.responseText;


        }
    };
    xhr.send(formData);
});

document.getElementById("classesForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", this.action, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("response").innerHTML = xhr.responseText;
        }
    };
    xhr.send(formData);
});

document.getElementById("subjectsForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", this.action, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("response").innerHTML = xhr.responseText;
        }
    };
    xhr.send(formData);
});

document.getElementById("entriesForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", this.action, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("response").innerHTML = xhr.responseText;
        }
    };
    xhr.send(formData);
});
</script>
