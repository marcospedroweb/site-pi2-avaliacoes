<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once('./telas/frag-user-nao-logado.php'); //Verifica se o usuario JÁ ESTA logado, se estiver, retorna para pagina principal

include ('./banco/conectarBanco.php'); // Conectando ao banco
include ('./classes/usuario-class.php'); // Incluindo classes
include ('./classes/categoria-class.php'); // Incluindo classes
$objUsuario = new Usuario($conn); // instancia o obj Usuario
$objCategoria = new Categoria($conn); // instancia o obj Categoria

$erroTexto = '';
$sucessoTexto = "";

//Titulos do datalist
$registrosDatalist = $objCategoria->mostrarCategorias(array('','','',''));//Retorna todos os registros de titulo

//Retorna informações sobre a conta do usuario
$regitroUsuario = $objUsuario->mostrarConta($_SESSION['id']);
if(!($regitroUsuario['id'])){
  //Se não retornar id, não achou o usuario
  $_GET['erro'] = true;
  $erroTexto = $regitroUsuario[1];
}

if(isset($_POST['atualizar-perfil'])){
  $success = $objUsuario->editarConta($_POST['atualizar-perfil'], $_POST);
  if($success[0]){
    $_GET['sucesso'] = true;
    $sucessoTexto = $success[1];
    $regitroUsuario = $objUsuario->mostrarConta($_SESSION['id']);
  } else{
    $_GET['erro'] = true;
    $erroTexto = $success[1];
  }
}

include('./telas/frag-html.php'); //Abertura html e head com boostrap
include("./telas/frag-variaveisPHP-no-js.php"); //SCRIPT passando algumas variaveis de $_SESSION para o JS
include('./telas/style-editar-conta.php'); //css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-editar-conta.php'); // tela da pagina inicial
include('./telas/frag-footer.php'); // footer


