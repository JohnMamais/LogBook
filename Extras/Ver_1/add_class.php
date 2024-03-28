<?php

$servername = "localhost";
$username = "root";
$password = "3419exli_neal";
$dbname = "log_book";
$GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);

// Creating connection
if(isset($_POST["fun2call"]) && !empty($_POST['fun2call'])) {
  $fun2call = $_POST['fun2call'];
  $semester = $_POST['semester'];
  $specialty = $_POST['specialty'];

  loadSubjects($semester, $specialty);
} else {
  echo json_encode(array('success' => 0));
}

function loadSubjects($semester, $specialty){

  $sql = "SELECT subject.name, subject.subjectID FROM subject, specialty WHERE subject.specialtyID = specialty.specialtyID and subject.specialtyID = '$specialty' and subject.semesters = '$semester'";
  $result = $GLOBALS['conn']->query($sql);

  while($row = mysqli_fetch_assoc($result)){
    echo "<label class='subject' for='" .$row["subjectID"]. "'>" . $row["name"] . "</label>";
    echo "<input type='checkbox' id='subject' class='subject' name='". $row["subjectID"]."'/>";
  }
};

?>
