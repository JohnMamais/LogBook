<link rel="stylesheet" href="<?php echo __ROOT__ . '/Styles/navbar.css'; ?>">

<nav class="top-menu">
  <div>
    <ul>
      <li>Καθηγητές </li>
      <li><a href="<?php echo __ROOT__ . '/user/index.php'; ?>">Εισαγωγή Εγγραφών</a></li>
      <li><a href="<?php echo __ROOT__ . '/user/pastEntries.php'; ?>">Προηγούμενες Εγγραφές</a></li>
      <li>Διαχειριστές </li>
      <li><a href="<?php echo __ROOT__ . '/admin/index.php'; ?>">Μαθήματα/Εξάμηνα</a></li>
      <li><a href="<?php echo __ROOT__ . '/common/newUser.php'; ?>">Εισαγωγή Καινούργιου Χρήστη</a></li>
      <li><a href="<?php echo __ROOT__ . '/admin/tokens.php'; ?>">Tokens Εγγραφών</a></li>
      <li><a href="<?php echo __ROOT__ . '/admin/viewPastEntries.php'; ?>">Προηγούμενες Εγγραφές</a></li>
      <li>Super Admin</li>
      <li><a href="<?php echo __ROOT__ . '/superadmin/SQL/index.php'; ?>">SQL</a></li>
      <li><a href="<?php echo __ROOT__ . '/superadmin/testData/index.php'; ?>">Δημιουργία Δοκιμαστικών Δεδομένων</a></li>
      <li><a href="<?php echo __ROOT__ . '/superadmin/HashSpeedTest.php'; ?>">Hash Cost</a></li>
    </ul>
  </div>
  <div>
    <ul>
      <li><a id="userProfile" href="<?php echo __ROOT__ . '/common/userProfile.php'; ?>" >Χρήστης: <?php echo $_SESSION['user'];?> </a></li>
      <li><a id="logout" href="<?php echo __ROOT__ . '/logout.php'; ?>">Log Out</a></li>
    </ul>
  </div>
</nav>
