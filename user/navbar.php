<?php
define('__ROOT__', 'http://localhost/LogBook'); // Assuming 'LogBook' is your project directory under 'htdocs'
?>

<nav class="top-menu">
  <div>
    <ul>
      <li><a href="<?php echo __ROOT__ . '/user/index.php'; ?>">Εισαγωγή Εγγραφών</a></li>
    </ul>
  </div>
  <div >
    <ul>
      <li>Χρήστης: <?php echo $_SESSION['user'];?></li>
      <li><a id="logout" href="<?php echo __ROOT__ . '/logout.php'; ?>">Log Out</a></li>
    </ul>
  </div>
</nav>
