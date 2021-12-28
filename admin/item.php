<?php
  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');
  
  if(isset($_GET['type']) && isset($_GET['id'])) {
    if($_GET['type'] == 'book') {
      include '../classes/books.classes.php';

      $item = (new BookHandler)->getBook($_GET['id']);
      $title = $item['title'];
    }

    if($_GET['type'] == 'record') {
      include '../classes/records.classes.php';

      $item = (new RecordHandler)->getRecord($_GET['id']);
      $title = 'Record #' . $item['id'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title><?= isset($title) ? $title : "Not found" ?> - WebLibrary Admin Backend Prototype</title>
</head>
<body>
  <?php if(empty($item)): ?>
    <h1>Item does not exist.</h1>
    <a href="index.php">Go back</a>
  <?php else: ?>
    <?php if($_GET['type'] == 'book'): ?>
      <h1><?= $item['title'] ?></h1>
      <ul>
        <li><?= $item['author'] ?></li>
        <li><?= $item['publisher'] ?></li>
        <li><?= date_format((new DateTime($item['date'])), 'F d, Y') ?></li>
      </ul>
      <a href="update.php?type=book&id=<?= $_GET['id'] ?>">Update information</a>
      <br>
      <a href="delete.php?type=book&id=<?= $_GET['id'] ?>">Delete book</a>
      <br>
      <a href="books.php">Go back</a>
    <?php elseif($_GET['type'] == 'record'): ?>
      <h1>Record #<?= $item['id'] ?></h1>
      <ul>
        <li>
          <a href="account.php?type=patron&id=<?= $item['user_id'] ?>"><?= $item['user_name'] ?></a>
        </li>
        <li>
          <a href="item.php?type=book&id=<?= $item['book_id'] ?>"><?= $item['book_title'] ?></a>
        </li>
        <li>Place hold date: <?= $item['hold_date'] ?></li>
        <li>Borrowed date: <?= $item['borrow_date'] ?></li>
        <li>Due date: <?= $item['due_date'] ?></li>
        <li>Returned date: <?= $item['return_date'] ?></li>
        <li>Status: <?= $item['status'] ?></li>
      </ul>
      <?php if($item['status'] == 'hold'): ?>
        <a href="hold.php?type=borrow&record=<?=$item['id'] ?>">Mark as borrowed</a>
        <br>
        <a href="hold.php?type=cancel&record=<?=$item['id'] ?>">Mark as canceled</a>
      <?php elseif($item['status'] == 'borrowed' || $item['status'] == 'overdue'): ?>
        <a href="hold.php?type=return&record=<?=$item['id'] ?>">Mark as returned</a>
      <?php endif; ?>
      <br>
      <a href="records.php">Go back</a>
    <?php endif; ?>
  <?php endif; ?>
</body>
</html>
