<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();

include ('./banco/conectarBanco.php'); // Conectando ao banco
include ('./classes/usuario-class.php'); // Incluindo classes
include ('./classes/categoria-class.php'); // Incluindo classes

$objCategoria = new Categoria($conn); // instancia o obj Categoria
//Titulos do datalist
$registrosDatalist = $objCategoria->mostrarCategorias(array(''));//Retorna todos os registros de titulo

$usuario = $_SESSION['id'] ?? '';
$modoAdmin = false;
//Titulos da seção categorias
$categoria = $_GET['categoria'] ?? 'Filmes';
if($categoria !== 'Filmes' && $categoria !== 'Animes' && $categoria !== 'Series')
    $categoria = 'Filmes';
$titulos = $objCategoria->mostrarCategorias(array($categoria, '','destaques'));//Retorna todos os titulos daquela categoria especificada

include('./telas/frag-html.php'); //Abertura html e head com boostrap
include("./telas/frag-variaveisPHP-no-js.php"); //SCRIPT passando algumas variaveis de $_SESSION para o JS
include('./telas/style-home.php'); //css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-inicio.php'); // tela da pagina inicial
include('./telas/frag-footer.php'); // footer