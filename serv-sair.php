<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();

if(isset($_SESSION['id'])){
  //Se houver id armazenado em session, o usuario está logado e sai da sessão
  session_destroy();
  header('Location: ./index.php');
}else{
  //Se não, apenas volta para a pagina inicial
  header('Location: ./index.php');
}






