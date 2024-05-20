<link rel="stylesheet" href="<?php echo __ROOT__ . '/Styles/navbar.css'; ?>">

<nav class="top-menu">
  <div>
    <ul>
      <li><a href="<?php echo __ROOT__ . '/user/index.php'; ?>">Εισαγωγή Εγγραφών</a></li>
      <li><a href="<?php echo __ROOT__ . '/user/pastEntries.php'; ?>">Προηγούμενες Εγγραφές</a></li>
    </ul>
  </div>
  <div >
    <ul>
      <li><a href="<?php echo __ROOT__ . '/common/userProfile.php'; ?>" >Χρήστης: <?php echo $_SESSION['user'];?> </a></li>
      <li><a id="logout" href="<?php echo __ROOT__ . '/logout.php'; ?>">Log Out</a></li>
    </ul>
  </div>
</nav>
