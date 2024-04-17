<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω: Διαχείρηση</title>

  <link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">
  <link rel="stylesheet" href="../Styles/loginStyleSheet.css">

</head>
<body>
  <?php
    include_once('../ConnectionConfigs/adminConfig.php');
    include_once('navbar.php');
    static $p;//page
   ?>
  <h1>Εμφάνιση Προηγούμενων Εγγραφών</h1>
  <form name="pastEntries" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <input type="number" id="num"/>
    <input type="text" id="result" readonly/>
    <button type="submit" onclick="nextPage()">next</button>
  </form>
</body>
</html>
<script>
let page;
page=0;

function nextPage(){
  let num = document.getElementById("num").value;
  console.log(page+num);
  page++;
}
</script>
