<?php
define('__ROOT__', 'http://localhost/LogBook'); // Assuming 'LogBook' is your project directory under 'htdocs'
?>
  <link rel="stylesheet" href="../Styles/navbar.css">
<nav class="top-menu">
  <ul>
    <li><a href="<?php echo __ROOT__ . '/admin/index.php'; ?>">Μαθήματα/Εξάμηνα</a></li>
    <li><a href="<?php echo __ROOT__ . '/admin/newUser.php'; ?>">Εισαγωγή Καινούργιου Χρήστη</a></li>
  </ul>
</nav>
