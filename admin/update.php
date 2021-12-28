<?php 
  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

  if(isset($_GET['type']) && isset($_GET['id'])) {
    if($_GET['type'] == 'patron') {
      include '../classes/users.classes.php';
      
      $account = (new UserHandler)->getUser($_GET['id'], false);
    } else if($_GET['type'] == 'staff') {
      include '../classes/users.classes.php';

      $account = (new UserHandler)->getUser($_GET['id'], true);
    } else if($_GET['type'] == 'book') {
      include '../classes/books.classes.php';

      $book = (new BookHandler)->getBook($_GET['id']);
    }

    if(isset($_POST['submit'])) {
      if($_GET['type'] == 'patron') {
        $result = (new User($_POST['name'], null, null, null, false))->userUpdate($account['id'], false);
        
        if($result == 0) header('Location: account.php?type=' . $_GET['type'] . '&id=' . $account['id']);
      } else if($_GET['type'] == 'staff') {
        $result = (new User($_POST['name'], null, null, null, true))->userUpdate($account['id'], true);

        if($result == 0) header('Location: account.php?type=' . $_GET['type'] . '&id=' . $account['id']);
      } else if($_GET['type'] == 'book') {
        $result = (new Book($_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['date']))->bookUpdate($book['id']);

        if($result == 0) header('Location: item.php?type=' . $_GET['type'] . '&id=' . $book['id']);
      }
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
  <title>Update <?= $_GET['type'] ?> - WebLibrary Backend Prototype</title>
</head>
<body>
  <h1>Update <?= $_GET['type'] ?></h1>
  <?php if(isset($error)): ?>
    <strong><?= $error ?></strong>
    <br><br>
  <?php endif; ?>
  <?php if($_GET['type'] == 'patron' || $_GET['type'] == 'staff'): ?>
    <form action="update.php?type=<?= $_GET['type'] ?>&id=<?= $_GET['id'] ?>" method="post">
      <label for="name">Name:</label>
      <input type="text" name="name" value="<?= $account['name'] ?>" required>
      <br><br>
      <label for="username">Username:</label>
      <input type="text" value="<?= $account['username'] ?>" disabled>
      <br><br>
      <label for="email">Email address:</label>
      <input type="email" value="<?= $account['email'] ?>" disabled>
      <br><br>
      <button type="submit" name="submit">Update</button>
    </form>
  <?php elseif($_GET['type'] == 'book'): ?>
    <form action="update.php?type=book&id=<?= $_GET['id'] ?>" method="post">
      <label for="title">Title:</label>
      <input type="text" name="title" value="<?= $book['title'] ?>" required>
      <br><br>
      <label for="author">Author:</label>
      <input type="text" name="author" value="<?= $book['author'] ?>" required>
      <br><br>
      <label for="publisher">Publisher:</label>
      <input type="text" name="publisher" value="<?= $book['publisher'] ?>" required>
      <br><br>
      <label for="date">Date:</label>
      <input type="date" name="date" value="<?= $book['date'] ?>" required>
      <br><br>
      <button type="submit" name="submit">Update</button>
    </form>
  <?php endif; ?>
  <br>
  <a href="<?= $_GET['type'] . 's' ?>.php">Go back</a>
</body>
</html>