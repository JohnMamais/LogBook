<link rel="stylesheet" href="<?php echo __ROOT__ . '/Styles/usernavbar.css'; ?>">

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
