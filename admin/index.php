<?php
  session_start();

  if (isset($_GET['e'])) {
    if ($_GET['e'] == -1) $error = 'An unknown error has occurred.';
    else if ($_GET['e'] == 3) $error = 'You\'re already logged in.';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>WebLibrary Admin Backend Prototype</title>
</head>
<body>
  <h1>WebLibrary Admin Backend Prototype</h1>
  <?php if (isset($error)) : ?>
    <strong><?= $error ?></strong>
  <?php endif; if (isset($_SESSION['staffId'])) : ?>
    <a href="logout.php">Logout</a>
    <br>
    <a href="books.php">Manage books</a>
    <br>
    <a href="records.php">Manage records</a>
    <br>
    <a href="patrons.php">Manage patrons</a>
    <br>
    <a href="staffs.php">Manage staffs</a>
  <?php else : ?>
    <a href="login.php">Login</a>
  <?php endif; ?>
</body>
</html>