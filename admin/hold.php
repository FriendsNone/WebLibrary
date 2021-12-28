<?php
include '../classes/records.classes.php';

session_start();
if(!isset($_SESSION['staffId'])) header('Location: login.php?e=3');

if(isset($_GET['type'])) {
  if($_GET['type'] == 'borrow') {
    $result = (new Record($_GET['record'], null, null))->markBorrowed(true);

    if($result == 0) header('Location: item.php?type=record&id=' . $_GET['record'] . '&e=0');
    else if($result == -1) header('Location: index.php?e=-1');
  } else if($_GET['type'] == 'return') {
    $result = (new Record($_GET['record'], null, null))->markReturned(true);

    if($result == 0) header('Location: item.php?type=record&id=' . $_GET['record'] . '&e=0');
    else if($result == -1) header('Location: index.php?e=-1');  
  } else if($_GET['type'] == 'cancel') {
    $result = (new Record($_GET['record'], null, null))->markCanceled(true);

    if($result == 0) header('Location: item.php?type=record&id=' . $_GET['record'] . '&e=0');
    else if($result == -1) header('Location: index.php?e=-1');
  } else {
    header('Location: index.php?e=-1');
  }
} else {
  header('Location: index.php?e=-1');
}