<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once("./telas/frag-verificar-admin.php");//Verifica se é a conta com privilegios de admin, se não, retorna para o index
include ('./banco/conectarBanco.php'); // Conectando ao banco
include ('./classes/categoria-class.php'); // Incluindo classes

$objCategoria = new Categoria($conn); // instancia o obj Categoria

$criarTitulo = true;
$imgPreviewPadrao = '62771513.jpeg';
$modoAdmin = $_SESSION['modo-admin'] ?? '';
$erroTexto = "";

//Titulos do datalist
$registrosDatalist = $objCategoria->mostrarCategorias(array(''));//Retorna todos os registros de titulo
$categorias = $objCategoria->mostrarTiposDeTitulos(array(''));

//Adicionando um novo titulo
if(isset($_POST['cadastrar-titulo'])){
  //Se existir essa variavel, manda para o classes fazer o insert
  $success = $objCategoria->criarTitulo($_POST);
  if($success[0] === true){
    header("Location: ./categoria-escolhida.php?nome={$success['nome']}&categoria={$success['categoria']}");
  }else{
    $erroTexto = $success[1];
    $_GET['erro'] = true;
  }
}

//Buscando um titulo existente para ser editado
if(isset($_POST['editar-titulo'])){
  $editarTituloId = $_POST['editar-titulo'];
  $tituloEspecifico = $objCategoria->mostrarTituloEspecifico($_POST['editar-titulo']);
  if($tituloEspecifico){
    $editarTitulo = true;
    $criarTitulo = false;  
  }
}

//Editando um titulo existente
if(isset($_POST['btn-editar-titulo'])){
  $success = $objCategoria->editarTitulo($_POST['btn-editar-titulo'], $_POST);
  if($success[0])
    header("Location: ./categoria-escolhida.php?nome={$success['nome']}&categoria={$success['categoria']}");
  else{
    $_GET['erro'] = true;
    $erroTexto = $success[1];
  }
}

//Html e etc
include('./telas/frag-html.php'); //Abertura html e head com boostrap
include("./telas/frag-variaveisPHP-no-js.php"); //SCRIPT passando algumas variaveis de $_SESSION para o JS
include('./telas/style-manipular-titulos.php'); //arquivo css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-manipular-titulos.php'); //tela da pagina cadastrar titulo
include('./telas/frag-footer.php') ;//footer padrão

