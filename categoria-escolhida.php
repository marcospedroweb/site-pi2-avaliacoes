<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once("./telas/frag-verificar-titulo.php");//Se o select NÃO retornar os dados necessarios, retorna para pagina categorias com GET de erro

include("./telas/frag-html.php"); //Abertura html e head com boostrap
include("./telas/frag-SESSION-no-js.php"); //SCRIPT passando algumas variaveis de $_SESSION para o JS
include("./telas/style-categoria-escolhida.php"); //css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include("./telas/tela-categoria-escolhida.php"); // tela da pagina da categoria escolhida
include("./telas/frag-footer.php"); //footer padrão







