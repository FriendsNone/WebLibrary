<?php
  session_start();

  if(isset($_GET['e'])) {
    if($_GET['e'] == -1) $error = 'An unknown error has occurred.';
    else if($_GET['e'] == 3) $error = 'You\'re already logged in.';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>WebLibrary Backend Prototype</title>
</head>
<body>
  <h1>WebLibrary Backend Prototype</h1>
  <?php if(isset($error)): ?>
    <strong><?= $error ?></strong>
  <?php endif; if(isset($_SESSION['userId'])): ?>
    <a href="logout.php">Logout</a>
    <br>
    <a href="catalog.php">Catalog</a>
  <?php else: ?>
    <a href="signup.php">Signup</a>
    <br>
    <a href="login.php">Login</a>
  <?php endif; ?>
</body>
</html>