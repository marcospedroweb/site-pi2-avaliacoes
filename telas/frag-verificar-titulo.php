<?php

$categoria = $_GET['categoria'] ?? '';
//Verifica se a categoria do GET existe em alguma categoria do banco
if($categoria === 'Filmes' || $categoria === 'Animes' || $categoria === 'Series'){
  require_once("./banco/conectarBanco.php");
  //Prepara o select
  $select = $bd->prepare("SELECT t.id, t.nome, sinopse, capa, avaliacaoGeral, c.tipo 
                          FROM titulo as t INNER JOIN categoria as c
                          ON t.categoria = c.id
                          WHERE t.nome = :nome");

  $select->execute([':nome' => "{$_GET['nome']}"]);
  $registroTitulo = $select->fetch(PDO::FETCH_ASSOC);//Retorna todos os dados requisitados

  //Se o select NÃO retornar algo que foi requisitado, retorna para a pagina categorias com GET de erro
  if(!(isset($registroTitulo['id']))){
    header('Location: ./categorias.php?nao-encontrado=true');
    exit();
  }
  
} else {
  //Se não houver essa categoria, retorna para a pagina categorias com GET de erro
  header('Location: ./categorias.php?nao-encontrado=true');
  exit();
}