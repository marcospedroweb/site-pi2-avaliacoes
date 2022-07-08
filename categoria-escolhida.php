<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

include ('./banco/conectarBanco.php'); // Conectando ao banco
include ('./classes/usuario-class.php'); // Incluindo classes
include ('./classes/categoria-class.php'); // Incluindo classes
$objCategoria = new Categoria($conn); // instancia o obj Categoria
$objUsuario = new Usuario($conn); // instancia o obj Usuario

//Variaveis utilizadas
$categoria = $_GET['categoria'] ?? '';
$tituloNome = $_GET['nome'] ?? '';
$usuario = $_SESSION['id'] ?? '';
$pagina = $_GET['pagina'] ?? '';
$erroTexto = '';
$sucessoTexto = '';

//Titulos do datalist
$registrosDatalist = $objCategoria->mostrarCategorias(array(''));//Retorna todos os registros de titulo

//Retorna o titulo escolhido,Verifica se o nome e categoria do $_GET existem no banco, se não, retorna para as categorias
$registrosTituloEscolhido = $objCategoria->verificarExistenciaTitulo(array($categoria, $tituloNome));
foreach($registrosTituloEscolhido as $id => $tituloRegistro){
  if(!($tituloRegistro['id'])){
    header('Location: ./categorias.php?nao-encontrado=true');
    exit();
  } else{
    $_GET['temporadaUnica'] = $tituloRegistro['temporadaUnica'];

  }
}


//Novo comentario do usuario
if(isset($_POST['avaliacao-usuario'])){
  $success = $objUsuario->avaliar($_POST, $usuario, $tituloNome);
  if($success[0]){
    $_GET['comentarioPostado'] = true;
    $_GET['sucesso'] = true;
    $sucessoTexto = $success[1];
    //Atualiza a media do titulo
    $objCategoria->atualizarAvaliacaoTitulo(array('',$tituloNome));
    $registrosTituloEscolhido = $objCategoria->verificarExistenciaTitulo(array($categoria, $tituloNome));
  }else{
    $_GET['comentarioPostado'] = false;
    $_GET['erro'] = true;
    $erroTexto = $success[1];
  }
}

//Apagar comentario existente
if(isset($_POST['btn-apagar-comentario'])){
  if((isset($_SESSION['id']) && (intval($_POST['input-id-usuario']) === $usuario)) || $usuario === 3){
    $success = $objUsuario->apagarComentario($_POST['btn-apagar-comentario'], $_POST['input-id-usuario'], $_POST['input-id-titulo']);
    if($success[0]){
      $_GET['sucesso'] = true;
      $sucessoTexto = $success[1];
      //Atualiza a media do titulo
      $objCategoria->atualizarAvaliacaoTitulo(array('',$tituloNome));
      $registrosTituloEscolhido = $objCategoria->verificarExistenciaTitulo(array($categoria, $tituloNome));
    }else{
      $_GET['erro'] = true;
      $erroTexto = $success[1];
    }
  }else{
    header('Location: ./login.php');
  }
}

//editar comentario existente
if(isset($_POST['editar-avaliacao'])){
  if(isset($_SESSION['id']) && intval($_POST['editar-id-usuario']) === $usuario){
    $success = $objUsuario->editarComentario($_POST);
    if($success[0]){
      $_GET['sucesso'] = true;
      $sucessoTexto = $success[1];
      //Atualiza a media do titulo
      $objCategoria->atualizarAvaliacaoTitulo(array('',$tituloNome));
      $registrosTituloEscolhido = $objCategoria->verificarExistenciaTitulo(array($categoria, $tituloNome));
    }else{
      $_GET['erro'] = true;
      $erroTexto = $success[1];
    }
  } else{
    header('Location: ./login.php');
  }
}

//Verificando se a paginação é valida, e atribuindo pagina anterior e proxima
if($pagina === 0 || $pagina === 1 || $pagina < 0 || $pagina === '' || !(is_numeric($pagina))){
  $pagina = 1;
  $paginaAnterior = 1; 
}else
  $paginaAnterior = $pagina - 1;
$paginaProximo = ($pagina + 1);

//Verificando quantidade comentarios o titulo tem
$qtdComentarios = $objUsuario->contarComentariosRegistrados(array($tituloRegistro['id']));
if($qtdComentarios[0]){
  $qtdDePaginas = $qtdComentarios[1] / 8;
  if(is_int($qtdDePaginas))
    $qtdDePaginas = $qtdDePaginas;
  else
    $qtdDePaginas = intval(++$qtdDePaginas);
  //Verifica se a quantidade de pagina de $_GET é valid
  if($pagina > $qtdDePaginas)
  $pagina = 1;
}

//Retorna todos os comentarios do titulo em especifico
$comentarios = $objUsuario->mostrarComentarios($tituloRegistro['id'], $pagina);

//Atualiza a media do titulo
$objCategoria->atualizarAvaliacaoTitulo(array('',$tituloNome));

//Formata os link de paginação dos comentarios
if($tituloNome && $categoria)
  $urlAtual = "./categoria-escolhida.php?nome={$tituloNome}&categoria={$categoria}&";

//Seção outros titulos daquela categoria
$titulosDaCategoria = $objCategoria->mostrarTitulosDaCategoria(array($categoria, $tituloNome, 'destaques'));

//Verificando se usuario já comentou
if($comentarios)
  foreach($comentarios as $id => $registroComentario)
    if($registroComentario['usuario'] === $usuario)
      $_GET['usuarioJaComentou'] = true;

//html e etc
include("./telas/frag-html.php"); //Abertura html e head com boostrap
include("./telas/frag-variaveisPHP-no-js.php"); //SCRIPT passando algumas variaveis de $_SESSION para o JS
include("./telas/style-categoria-escolhida.php"); //css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include("./telas/tela-categoria-escolhida.php"); // tela da pagina da categoria escolhida
include("./telas/frag-footer.php"); //footer padrão







