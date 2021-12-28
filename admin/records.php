<?php
  include '../classes/records.classes.php';

  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

  $records = (new RecordHandler)->getAllRecord();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>Mange records - WebLibrary Admin Backend Prototype</title>
</head>
<body>
  <h1>Mange records</h1>
  <ol reversed start=<?= $records[0]['id'] ?>>
    <?php foreach($records as $record): ?>
      <li>
        <a href="item.php?type=record&id=<?= $record['id'] ?>">
          <?= $record['name'] . ' ' . $record['status'] . ' ' . $record['title'] ?> 
        </a>
      </li>
    <?php endforeach; ?>
  </ol>
  <a href="index.php">Go back</a>
</body>
</html>