<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
//usado para depurar codigo

session_start();


include('./telas/frag-html.php'); //Abertura html e head com boostrap
require_once('./telas/style-categorias.php'); // css e js
include('./telas/frag-navbar.php'); //navegação principal do site
include('./telas/tela-categorias.php'); //tela da pagina categorias
include('./telas/frag-footer.php'); // footer