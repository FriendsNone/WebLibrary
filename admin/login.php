<?php 
  include '../classes/users.classes.php';

  session_start();
  if(isset($_SESSION['staffId'])) header('Location: index.php?e=3');

  if(isset($_GET['e']) && $_GET['e'] == 3) $error = 'You\'re not logged in. Please login.';

  if(isset($_POST['submit'])) {
    $result = (new User(null, $_POST['user'], $_POST['user'], null, true))->userLogin($_POST['password'], true);

    if($result == 0) header('Location: index.php');
    else if($result == 1) $error = 'User not found. Please signup.';
    else if($result == 2) $error = 'Wrong password. Please try again.';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>Login - WebLibrary Admin Backend Prototype</title>
</head>
<body>
  <h1>Login</h1>
  <?php if(isset($error)): ?>
    <strong><?= $error ?></strong>
    <br><br>
  <?php endif; ?>
  <form action="login.php" method="post">
    <label for="user">Username/Email address:</label>
    <input type="text" name="user" required>
    <br><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br><br>
    <button type="submit" name="submit">Login</button>
  </form>
  <br>
  <a href="index.php">Go back</a>
</body>
</html>