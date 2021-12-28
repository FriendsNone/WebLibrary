<?php
  include './classes/books.classes.php';
  
  session_start();
  if(!isset($_SESSION['userId'])) header('Location: login.php?e=3');

  if(isset($_GET['e'])) {
    if($_GET['e'] == 0) $error = 'Success';
    if($_GET['e'] == 4) $error = 'You already placed a hold on this book.';
    if($_GET['e'] == 5) $error = 'You didn\'t place a hold on this book.';
  }
  
  if(isset($_GET['book'])) $book = (new BookHandler)->getBook($_GET['book']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title><?= !empty($book) ? $book['title'] : 'Not found' ?> - WebLibrary Backend Prototype</title>
</head>
<body>
  <?php if(empty($book)): ?>
    <h1>Book does not exist.</h1>
  <?php else: ?>
    <h1><?= $book['title'] ?></h1>
    <?php if(isset($error)): ?>
      <strong><?= $error ?></strong>
      <br>
    <?php endif; ?>
    <ul>
      <li><?= $book['author'] ?></li>
      <li><?= $book['publisher'] ?></li>
      <li><?= date_format((new DateTime($book['date'])), 'F d, Y') ?></li>
    </ul>
    <a href="hold.php?type=hold&patron=<?= $_SESSION['userId'] ?>&book=<?= $book['id'] ?>">Place hold</a>
    <br>
    <a href="hold.php?type=cancel&patron=<?= $_SESSION['userId'] ?>&book=<?= $book['id'] ?>">Cancel hold</a>
    <br>
  <?php endif; ?>
  <a href="catalog.php">Go back</a>
</body>
</html>