<?php
  include '../classes/users.classes.php';

  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

  $patrons = (new UserHandler)->getAllUser(false);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>Manage patrons - WebLibrary Admin Backend Prototype</title>
</head>
<body>
  <h1>Manage patrons</h1>
  <ul>
    <?php foreach($patrons as $patron): ?>
      <li>
        <a href="account.php?type=patron&id=<?= $patron['id'] ?>">
          <strong><?= $patron['name'] ?></strong>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  <a href="add.php?type=patron">Add patron</a>
  <a href="index.php">Go back</a>
</body>
</html>