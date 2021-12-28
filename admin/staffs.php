<?php
  include '../classes/users.classes.php';

  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

  $staffs = (new UserHandler)->getAllUser(true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>Manage staffs - WebLibrary Admin Backend Prototype</title>
</head>
<body>
  <h1>Manage staffs</h1>
  <ul>
    <?php foreach($staffs as $staff): ?>
      <li>
        <a href="account.php?type=staff&id=<?= $staff['id'] ?>">
          <strong><?= $staff['name'] ?></strong>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  <a href="add.php?type=staff">Add staff</a>
  <a href="index.php">Go back</a>
</body>
</html>