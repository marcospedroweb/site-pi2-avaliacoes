<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();

include('./telas/frag-html.php'); //Abertura html e head com boostrap
include('./telas/style-home.php'); //css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-inicio.php'); // tela da pagina inicial
include('./telas/frag-footer.php'); // footer