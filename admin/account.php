<?php
  include '../classes/users.classes.php';
  
  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

  if(isset($_GET['type']) && isset($_GET['id'])) {
    if($_GET['type'] == 'patron') {
      $account = (new UserHandler)->getUser($_GET['id'], false);
    }
    
    if($_GET['type'] == 'staff') {
      $account = (new UserHandler)->getUser($_GET['id'], true);
    }
  } else {
    header('Location: index.php?e=-1');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title><?= !empty($account) ? $account['name'] : 'Not found' ?> - WebLibrary Admin Backend Prototype</title>
</head>
<body>
  <?php if(empty($account)): ?>
    <h1>Account does not exist.</h1>
    <a href="index.php">Go back</a>
  <?php else: ?>
    <h1><?= $account['name'] ?></h1>
    <?php if(isset($_GET['e']) && $_GET['e'] == 1): ?>
      <strong>You can't delete your own account.</strong>
    <?php endif; ?>
    <ul>
      <li><?= $account['username'] ?></li>
      <li><?= $account['email'] ?></li>
      <li><?= date_format((new DateTime($account['date'])), 'F d, Y - H:i:s') ?></li>
    </ul>
    <a href="update.php?type=<?= $_GET['type'] ?>&id=<?= $_GET['id'] ?>">Update information</a>
    <br>
    <a href="delete.php?type=<?= $_GET['type'] ?>&id=<?= $_GET['id'] ?>">Delete account</a>
    <br>
    <a href="<?= $_GET['type'] . 's' ?>.php">Go back</a>
  <?php endif; ?>
</body>
</html>