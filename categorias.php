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

//Estabelecendo valores as variaveis
$usuario = $_SESSION['id'] ?? '';
$categoria = $_GET['categoria'] ?? '';
if(strpos($categoria, '+'))
  $categoria = str_replace($categoria, '+', ' ');
$titulo = $_GET['nome'] ?? '';
$titulos = '';
$categoriaEscolhida = '';
$pagina = $_GET['pagina'] ?? '';
$ordenarPor = $_GET['ordenar'] ?? 'nome';
$modoAdmin = $_SESSION['modo-admin'] ?? '';
$erroTexto = "";
$sucessoTexto = "";

$pagina = intval($pagina);

//Formatando o texto de ordenado por:
if($ordenarPor === '')
  $ordenarPor = 'Nome (A-Z)';
else if ($ordenarPor === 'relevancia')
  $ordenarPor = 'Relevância';
else if ($ordenarPor === 'nome')
  $ordenarPor = 'Nome (A-Z)';
else if ($ordenarPor === 'sem-avaliacao')
  $ordenarPor = 'Sem avaliação';

//Verificando se a paginação é valida, e atribuindo pagina anterior e proxima
if($pagina === 0 || $pagina === 1 || $pagina < 0 || $pagina === '' || !(is_numeric($pagina))){
  $pagina = 1;
  $paginaAnterior = 1; 
}else
  $paginaAnterior = $pagina - 1;
$paginaProximo = ($pagina + 1);

if(isset($_POST['apagar-titulo'])){
  $success = $objCategoria->apagarTitulo($_POST['apagar-titulo']);
  if($success[0]){
    $_GET['sucesso'] = true;
    $sucessoTexto = $success[1];
  } else{
    $_GET['erro'] = true;
    $erroTexto = $success[1];
  }
}

//Titulos do datalist
$registrosDatalist = $objCategoria->mostrarCategorias(array('','','',''));//Retorna todos os registros de titulo

//Verificando a quantidade de paginas necessarias
$qtdTitulos = $objCategoria->contarTitulosRegistrados(array($categoria, $titulo,'',''));
$qtdDePaginas = $qtdTitulos['qtd'] / 16;
if(is_int($qtdDePaginas))
  $qtdDePaginas = $qtdDePaginas;
else
  $qtdDePaginas = intval(++$qtdDePaginas);

//Verifica se a quantidade de pagina de $_GET é valid
if($pagina > $qtdDePaginas)
  $pagina = 1;

//Atualizando o link de paginação
$buscaRealizada = $_GET['buscarCategoria'] ?? '';
$buscaRealizada = $_GET['procurar-categoria'] ?? $buscaRealizada;
if($buscaRealizada){
  $qtdDePaginas = 1;
  $buscaRealizada = str_replace("'", "", $buscaRealizada);
  $urlAtual = "./categorias.php?procurar-categoria={$buscaRealizada}&";
}else if ($categoria && $ordenarPor)
  $urlAtual = "./categorias.php?categoria={$categoria}&ordenar={$ordenarPor}&";
else if ($categoria)
  $urlAtual = "./categorias.php?categoria={$categoria}&";
else if ($ordenarPor)
  $urlAtual = "./categorias.php?ordenar={$ordenarPor}&";
else
  $urlAtual = "./categorias.php?";

//Verifica se houve pesquisa do usuario
if(isset($_GET['procurar-categoria']) || isset($_GET['buscarCategoria'])){
  $categoriaEscolhida = $_GET['procurar-categoria'] ?? $_GET['buscarCategoria'];
  $categoriaEscolhida = str_replace("'", "",$categoriaEscolhida);
  $titulos = $objCategoria->mostrarCategorias(array('', $categoriaEscolhida, '', ''));
  $_GET['nomePesquisado'] = $categoriaEscolhida;
  if(!($titulos)){
    $_GET['erro'] = true;
    $erroTexto = "Não houve resultados para \"{$categoriaEscolhida}\".";
  }
}
if(!($titulos)){
  //Titulos da seção categorias
  if($categoria !== 'Filmes' && $categoria !== 'Animes' && $categoria !== 'Series'){
    $categoria = '';
    $titulos = $objCategoria->mostrarCategorias(array($categoria, $titulo, $ordenarPor, $pagina));//Retorna todos os titulos da categoria especifica
  } else {
    $titulos = $objCategoria->mostrarCategorias(array($categoria, $titulo, $ordenarPor, $pagina));//Retorna todos os titulos de todas categorias
  }
  $_GET['nomePesquisado'] = '';
}

$categoria = $categoria === '' ? 'Ver todas' : $categoria;

// Html e etc
include('./telas/frag-html.php'); //Abertura html e head com boostrap
include("./telas/frag-variaveisPHP-no-js.php"); //SCRIPT passando algumas variaveis de $_SESSION para o JS
include('./telas/style-categorias.php'); // css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-categorias.php'); //tela da pagina categorias
include('./telas/frag-footer.php'); // footer