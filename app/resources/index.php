<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo
session_start();

require_once __DIR__ . './Model/Usuario.class.php';
$usuario_class = new Usuario();
require_once __DIR__ . './Model/Titulo.class.php';
$titulo_class = new Titulo();

$registrosDatalist = $titulo_class->listar(array(
  'categoria' => '',
  'titulo_nome' => '',
  'ordernar_por' => 'destaques',
  'pagina_atual' => 0,
));

$usuario = $_SESSION['id'] ?? '';
$modoAdmin = false;

//Titulos da seção categorias
$categoria = $_GET['categoria'] ?? 'Filmes';
if ($categoria !== 'Filmes' && $categoria !== 'Animes' && $categoria !== 'Series')
  $categoria = 'Filmes';
$titulos = $objCategoria->mostrarCategorias(array($categoria, '', 'destaques')); //Retorna todos os titulos daquela categoria especificada

include('./telas/frag-html.php'); //Abertura html e head com boostrap
include("./telas/frag-variaveisPHP-no-js.php"); //SCRIPT passando algumas variaveis de $_SESSION para o JS
include('./telas/style-home.php'); //css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-inicio.php'); // tela da pagina inicial
include('./telas/frag-footer.php'); // footer