<?php

session_start();

if(isset($_SESSION['staffId'])) {
  session_unset();
  session_destroy();
  header('Location: index.php');
} else {
  header('Location: login.php?e=3');
}

