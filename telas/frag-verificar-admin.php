<?php
if($_SESSION['id'] != 3){
  header('Location: ./index.php');
  exit();
}