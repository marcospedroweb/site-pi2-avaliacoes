<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once("./telas/frag-verificar-admin.php");//Verifica se é a conta com privilegios de admin, se não, retorna para o index

if(!(isset($_SESSION['modo-admin'])) || $_SESSION['modo-admin'] === false)
  $_SESSION['modo-admin'] = true;
else
  $_SESSION['modo-admin'] = false;

if($_SESSION['modo-admin'] === false || $_SESSION['modo-admin'] === true){
  header("Location: ./categorias.php");
  exit();
}

