<?php
include './classes/records.classes.php';

session_start();
if(!isset($_SESSION['userId'])) header('Location: login.php?e=3');

if(isset($_GET['type'])) {
  if($_GET['type'] == 'hold') {
    $result = (new Record(null, $_GET['patron'], $_GET['book']))->placeHold(false);

    if($result == 0) header('Location: item.php?book=' . $_GET['book'] . '&e=0');
    else if($result == 4) header('Location: item.php?book=' . $_GET['book'] . '&e=4');
  } else if($_GET['type'] == 'cancel') {
    $result;
    $result = (new Record(null, $_GET['patron'], $_GET['book']))->markCanceled(false);

    if($result == 0) header('Location: item.php?book=' . $_GET['book'] . '&e=0');
    else if($result == 5) header('Location: item.php?book=' . $_GET['book'] . '&e=5');
  } else {
    header('Location: index.php?e=-1');
  }
} else {
  header('Location: index.php?e=-1');
}