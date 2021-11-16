<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION


$inputNav = $_POST['procurar-categoria'] ?? '';
$inputCategorias = $_POST['buscarCategoria'] ?? '';

if($inputNav || $inputCategorias){
  //Se alguma dessas variaveis ter dados, faz o select buscando tal titulo(s)
  $tituloPesquisado = $inputNav ?? $inputCategorias;
  require_once('./banco/conectarBanco.php');

  $select = $bd->prepare("SELECT nome
                          FROM titulo as t
                          WHERE nome like :nome");

  $select->execute([':nome' => "%{$tituloPesquisado}%"]);
  $success = $select->fetch(PDO::FETCH_ASSOC);
  if($success) // Se o select RETORNAR algum titulo, leva para pagina categorias pelo GET
    header("Location: ./categorias.php?nome={$inputNav}");
  else // Se o select NÃO RETORNAR algum titulo, leva para pagina categorias pelo GET o erro e o titulo
    header("Location: ./categorias.php?nome={$inputNav}&nao-encontrado=true");

} else{
  // Se não houver as variaveis, leva para a pagina de categoria
  header('Location: ./categorias.php');
}