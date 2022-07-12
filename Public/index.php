<?php

require_once '../vendor/autoload.php';
require_once './bootstrap.php';

try {
  //Inicia o sistema de rotas
  router();
} catch (Exception $e) {
  //Se ocorrer algum erro nas rotas, avisa com um erro
  var_dump($e->getMessage());
}

// echo "teste";

// class Main
// {

//   public function __construct()
//   {
//   }
// }
// new Main;
