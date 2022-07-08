<?php
if(isset($_SESSION['id'])){
  //Se não houver id armazenado em session, o usuario não está logado e pede para se logar
  header('Location: ./index.php');
  exit();//Finaliza a execução do programa
}
