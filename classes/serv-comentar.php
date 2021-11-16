<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once('./telas/frag-user-nao-logado.php');

$usuario = $_SESSION['id'];

if($usuario){
  //Se tiver um id armazenado, começa a verificação e insert do comentario
  require_once('./banco/conectarBanco.php'); //Requere apenas 1 vez aquele arquivo, se não conseguir pegar o arquivo, dá um erro fatal no programa

  //Recuperando o registro com email do usuario
  $consulta = $bd->prepare("SELECT t.id, c.tipo
                            FROM titulo t INNER JOIN categoria c
                            WHERE nome = :nome");//Prepara o acesso ao banco, ou seja, prepara aquilo que foi determinado e retorna o nome e email se o email passado pelo usuario for igual

  $consulta->execute([':nome' => $_SESSION['titulo']]);
  $registro = $consulta->fetch(PDO::FETCH_ASSOC);

  $titulo = $_SESSION['titulo'] ?? '';
  $comentario = $_POST['comentar-textarea'] ?? '';
  $avaliacao = $_POST['avaliacao-usuario'] ?? '';
  $dataComentario = (new DateTime())->getTimestamp();

  $insert = $bd->prepare("INSERT INTO opniao (titulo, usuario, avaliacao, comentario, dataPublicado) 
                          VALUES (:titulo, :usuario, :avaliacao, :comentario, :dataPublicado)");

  $registros[':titulo'] = $registro['id'];
  $registros[':usuario'] = $usuario;
  $registros[':avaliacao'] = $avaliacao;
  $registros[':comentario'] = $comentario;
  $registros[':dataPublicado'] = $dataComentario;
  
  $success = $insert->execute($registros);
  if($success){
    //Se der certo o insert, atualiza a nota daquele titulo
    $select = "SELECT ROUND(AVG(avaliacao), 1) FROM opniao";
    $registro = ($bd->query($select))->fetch(PDO::FETCH_ASSOC);

    $update = $bd->prepare("UPDATE titulo 
                            SET avaliacaoGeral = :avaliacaoGeral
                            WHERE id = '{$registros[':titulo']}'");
    $update->execute([':avaliacaoGeral' => $registro['ROUND(AVG(avaliacao), 1)']]);

    header("Location: ./categoria-escolhida.php?nome={$titulo}&categoria={$registro['tipo']}");
  } else{
    header('Location: ./categorias.php');
  }
}


