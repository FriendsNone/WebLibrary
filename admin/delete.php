<?php
  session_start();
  if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

  if(isset($_GET['type']) && isset($_GET['id'])) {
    if($_GET['type'] == 'patron') {
      include '../classes/users.classes.php';
      
      $account = (new UserHandler)->getUser($_GET['id'], false);

      $result = (new User(null, $account['username'], $account['email'], null, false))->userDelete($account['id'], true);

      if($result == 0) header('Location: patrons.php');
      elseif($result == -1)  header('Location: index.php?e=-1');
    } else if($_GET['type'] == 'staff') {
      include '../classes/users.classes.php';

      $account = (new UserHandler)->getUser($_GET['id'], true);

      if($_SESSION['staffId'] === $account['id']) {
        header('Location: account.php?type='. $_GET['type'] .'&id=' . $account['id'] . '&e=1');
      } else {
        $result = (new User(null, $account['username'], $account['email'], null, true))->userDelete($account['id'], true);

        if($result == 0) header('Location: staffs.php');
        elseif($result == -1)  header('Location: index.php?e=-1');
      }
    } else if($_GET['type'] == 'book') {
      include '../classes/books.classes.php';
      
      $book = (new BookHandler)->getBook($_GET['id']);

      $result = (new Book($book['title'], null, null, null))->bookDelete($book['id'], true);

      if($result == 0) header('Location: books.php');
      elseif($result == -1)  header('Location: index.php?e=-1');
    }
  } else {
    header('Location: index.php?e=-1');
  }
