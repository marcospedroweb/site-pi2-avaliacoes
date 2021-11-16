<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once('./telas/frag-user-logado.php'); //Verifica se o usuario JÁ ESTA logado, se estiver, retorna para pagina principal

include('./telas/frag-html.php'); //Abertura html e head com boostrap
include('./telas/style-criar-conta.php'); //css e js
include('./telas/tela-criar-conta.php'); //tela da pagina criar conta
include('./telas/frag-footer.php'); //footer