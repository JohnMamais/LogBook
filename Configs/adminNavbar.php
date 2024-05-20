<link rel="stylesheet" href="<?php echo __ROOT__ . '/Styles/navbar.css'; ?>">

<nav class="top-menu">
  <div>
    <ul>
      <li><a href="<?php echo __ROOT__ . '/admin/index.php'; ?>">Μαθήματα/Εξάμηνα</a></li>
      <li><a href="<?php echo __ROOT__ . '/common/newUser.php'; ?>">Εισαγωγή Καινούργιου Χρήστη</a></li>
      <li><a href="<?php echo __ROOT__ . '/admin/tokens.php'; ?>">Tokens Εγγραφών</a></li>
    </ul>
  </div>
  <div>
    <li><a href="<?php echo __ROOT__ . '/common/userProfile.php'; ?>" >Χρήστης: <?php echo $_SESSION['user'];?> </a></li>
    <a class="logout" href="<?php echo __ROOT__ . '/logout.php'; ?>">Log Out</a>
  </div>
</nav>
