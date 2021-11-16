<?php
// Passando o $_SESSION para o JS
if(isset($_GET['nome'])){
  //Passando variaveis necessarias para mostrar o alert de não logado ou alert de deixe sua nota
  $idUsuario = $_SESSION['id'] ?? '';
  echo "<script defer>
          let SESSION = {};
          SESSION[decodeURIComponent('id')] = decodeURIComponent(parseInt(" . $idUsuario . "));
          SESSION[decodeURIComponent('nomeTitulo')] = decodeURIComponent('" . $_GET['nome'] . "');
        </script>";
}