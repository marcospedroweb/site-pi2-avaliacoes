<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();//Usado para iniciar uma sessão com o usuario, fazendo existir a varivael $_SESSION

require_once("./telas/frag-verificar-admin.php");//Verifica se é a conta com privilegios de admin, se não, retorna para o index

include('./telas/frag-html.php'); //Abertura html e head com boostrap
include('./telas/style-cadastrar-titulo.php'); //arquivo css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-cadastrar-titulo.php'); //tela da pagina cadastrar titulo
include('./telas/frag-footer.php') ;//footer padrão

