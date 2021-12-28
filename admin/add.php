<?php 
  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

  if(isset($_GET['type'])) {
    if($_GET['type'] == 'patron' || $_GET['type'] == 'staff') {
      include '../classes/users.classes.php';

      if(isset($_POST['submit'])) {
        if($_GET['type'] == 'patron') {
          $result = (new User($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], false))->userSignup($_POST['repeat_password'], true);
        }
        
        if($_GET['type'] == 'staff') {
          $result = (new User($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], true))->userSignup($_POST['repeat_password'], true);
        }
  
        if($result == 0) header('Location: ' . $_GET['type'] . 's.php');
        else if($result == 1) $error = 'Username/Email address taken. Please use a different one.';
        else if($result == 2) $error = 'Password doesn\'t match. Please try again.';
      }
    } else if($_GET['type'] == 'book') {
      include '../classes/books.classes.php';

      if(isset($_POST['submit'])) {
        // $result = (new User($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], false))->userSignup($_POST['repeat_password'], true);
        $result = (new Book($_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['date']))->bookAdd();

        if($result == 0) header('Location: books.php');
      }
    } else {
      header('Location: index.php?e=-1');
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
  <title>Add <?= $_GET['type'] ?> - WebLibrary Backend Prototype</title>
</head>
<body>
  <h1>Add <?= $_GET['type'] ?></h1>
  <?php if(isset($error)): ?>
    <strong><?= $error ?></strong>
    <br><br>
  <?php endif; ?>
  <?php if($_GET['type'] == 'patron' || $_GET['type'] == 'staff'): ?>
    <form action="add.php?type=<?= $_GET['type'] ?>" method="post">
      <label for="name">Name:</label>
      <input type="text" name="name" required>
      <br><br>
      <label for="username">Username:</label>
      <input type="text" name="username" required>
      <br><br>
      <label for="email">Email address:</label>
      <input type="email" name="email" required>
      <br><br>
      <label for="password">Password:</label>
      <input type="password" name="password" required>
      <br><br>
      <label for="repeat_password">Repeat password:</label>
      <input type="password" name="repeat_password" required>
      <br><br>
      <button type="submit" name="submit">Add <?= $_GET['type'] ?></button>
  </form>
  <?php elseif($_GET['type'] == 'book'): ?>
    <form action="add.php?type=book" method="post">
      <label for="title">Title:</label>
      <input type="text" name="title" required>
      <br><br>
      <label for="author">Author:</label>
      <input type="text" name="author" required>
      <br><br>
      <label for="publisher">Publisher:</label>
      <input type="text" name="publisher" required>
      <br><br>
      <label for="date">Date:</label>
      <input type="date" name="date" required>
      <br><br>
      <button type="submit" name="submit">Add book</button>
    </form>
  <?php endif; ?>
  <br>
  <a href="<?= $_GET['type'] . 's' ?>.php">Go back</a>
</body>
</html>