<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once('./telas/frag-user-logado.php');

$nome = $_POST['nome'] ?? '';
if(!($nome)){
  $random = rand(1, 99999999);
  $nome = "Usuario{$random}";
}
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if($email){
    //Verificação se está vazio/undefined aquela variavel, se estiver vazio, finaliza o programa
    require_once('./banco/conectarBanco.php'); //Requere apenas 1 vez aquele arquivo, se não conseguir pegar o arquivo, dá um erro fatal no programa

    //Preparando o insert para evitar SQL Injection
    $insert = $bd->prepare('INSERT INTO usuario (nome, email, senha, avatar) VALUES (:nome, :email, :senha, :avatar)');

    $valores[':nome'] = $nome;
    $valores[':email'] = $email;
    $valores[':senha'] = password_hash($senha, PASSWORD_DEFAULT);
    $valores[':avatar'] =  "./imgs-usuario/user.png";

    //Executando o insert
    $success = $insert->execute($valores);

    if($success){
      //Retornado id o usuario
      $consulta = $bd->prepare('SELECT id FROM usuario WHERE email = :email');
      $consulta->execute([':email' => $email]);
      $registro = $consulta->fetch(PDO::FETCH_ASSOC);

      $_SESSION['nome'] = $nome;
      $_SESSION['id'] = $registro['id'];
      $_SESSION['avatar'] = $valores[':avatar'];

      header('Location: ./index.php');
    }else{
      session_destroy();//Se o usuario errar, a variavel sessão é destruida
      header('Location: ./criar-conta.php?erro=true');
    }
} else{
  session_destroy();//Se o usuario errar, a variavel sessão é destruida
  header('Location: ./index.php');
}
