<?php

session_start();
require_once("./telas/frag-verificar-admin.php");

$titulo = $_POST['titulo'] ?? '';

if($titulo){
  //Se receber o nome, começa a verificação da imagem
  require_once('./banco/conectarBanco.php');

  //Verificando se o arquivo é uma imagem
  $tipo = mime_content_type($_FILES['capa-titulo']['tmp_name']);
  switch ($tipo){
      case 'image/png':
          $ext = '.png';
          break;
      case 'image/jpeg':
          $ext = '.jpeg';
          break;
      case 'image/jpg':
          $ext = '.jpg';
          break;
      case 'image/gif':
          $ext = '.gif';
          break;
  }
  if($ext){
    //Se a extensão for valida, armazena tal imagem com nome aleatorio na pasta
    $random = rand(1, 99999999);
    $capa = $random . $ext;
    move_uploaded_file($_FILES['capa-titulo']['tmp_name'], __DIR__ . '/imgs-usuario/' . $random . $ext);
  }else{
    //Se a extensão NÃO for valida, deixa vazio
    $capa = '';
  }

  //Preparando o insert
  $categoria = $_POST['categoria'] ?? '';
  $sinopse = $_POST['sinopse'] ?? '';
  
  $insert = $bd->prepare('INSERT INTO titulo(nome, sinopse, capa, avaliacaoGeral, categoria) 
                            VALUES (:nome, :sinopse, :capa, :avaliacaoGeral, :categoria)');

  $registros[':nome'] = $titulo;
  $registros[':sinopse'] = $sinopse;
  $registros[':capa'] = $capa;
  $registros[':avaliacaoGeral'] = 0;
  $registros[':categoria'] = $categoria;

  //Insert Executado
  $success = $insert->execute($registros);

  if($success)
    header('Location: ./index.php');
  else
    header('Location: ./cadastrar-titulo.php');
  
}else{
  //Se não houver titulo, dá um erro
  header('Location: ./cadastrar-titulo.php');
}

