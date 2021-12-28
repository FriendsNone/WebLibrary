<?php
  include './classes/books.classes.php';

  session_start();
  if(!isset($_SESSION['userId'])) header('Location: login.php?e=3');

  if(isset($_GET['submit'])) {
    $books = (new BookHandler)->getAllBook($_GET['title'], $_GET['author']);
  } else {
    $books = (new BookHandler)->getAllBook();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Catalog - WebLibrary Backend Prototype</title>
</head>
<body>
  <h1>Catalog</h1>
  <ul>
    <?php foreach($books as $book): ?>
      <li>
        <a href="item.php?book=<?= $book['id'] ?>">
          <strong><?= $book['title'] ?></strong> by <?= $book['author'] ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  <form action="catalog.php" method="get">
    <label for="title">Title:</label>
    <input type="text" name="title">
    <br><br>
    <label for="author">Author:</label>
    <input type="text" name="author">
    <br><br>
    <button type="submit" name="submit">Search</button>
  </form>
  <br>
  <a href="index.php">Go back</a>
</body>
</html>