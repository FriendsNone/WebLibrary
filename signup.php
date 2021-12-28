<?php 
  include './classes/users.classes.php';

  session_start();
  if(isset($_SESSION['userId'])) header('Location: index.php?e=3');

  if(isset($_POST['submit'])) {
    $result = (new User($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], false))->userSignup($_POST['repeat_password'], false);

    if($result == 0) header('Location: index.php');
    else if($result == 1) $error = 'Username/Email address taken. Please use a different one.';
    else if($result == 2) $error = 'Password doesn\'t match. Please try again.';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Signup - WebLibrary Backend Prototype</title>
</head>
<body>
  <h1>Signup</h1>
  <?php if(isset($error)): ?>
    <strong><?= $error ?></strong>
    <br><br>
  <?php endif; ?>
  <form action="signup.php" method="post">
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
    <button type="submit" name="submit">Signup</button>
  </form>
  <br>
  <a href="login.php">Login</a>
  <br>
  <a href="index.php">Go back</a>
</body>
</html>