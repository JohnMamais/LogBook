<!DOCTYPE HTML>
<html>
  <form name="createUsers" method="post" action="createUsers.php" id="userForm">
    Δημιουργία χρηστών:
    <input type="number" name="count"/>
    <button type="submit">Go</button> <br>
  </form>
  <form name="setYears" method="post" action="initPeriods.php" id="yearForm">
    Δημιουργία δεδομένων απο χρονιά:
    <input type="number" name="min"/>
     έως χρονιά:
    <input type="number" name="max"/>
    <button type="submit">Go</button> <br>
  </form>
  <form name="populateClasses" method="post" action="generateClasses.php" id="classesForm">
      Populate Classes:
      <button type="submit">Go</button> <br>
  </form>
  <form name="populateSubjects" method="post" action="generateSubjects.php" id="subjectsForm">
      Enable all subjects for period(s):
      <button type="submit">Go</button> <br>
  </form>
  <form name="populateEntries" method="post" action="generateEntries.php" id="entriesForm">
      Populate Entries:
      <button type="submit">Go</button> <br>
  </form>

</html>

<script>
document.getElementById("userForm").addEventListener("submit", function(event) {
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
