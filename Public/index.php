<?php

require_once '../vendor/autoload.php';
require_once './bootstrap.php';

try {
  //Inicia o sistema de rotas
  $data = router();

  //Verificando se exite $data['data']
  if (!isset($data['data']))
    //Se não exisitir, avisa com um erro
    throw new Exception('O ínidica data está faltando');

  //Verificando se exite o titulo em $data['data']
  if (!isset($data['data']['title']))
    //Se não exisitir, avisa com um erro
    throw new Exception('O ínidica title está faltando');

  // [extract()] Recebe um array e transforma aquele indice em uma variavel
  extract($data['data']);

  // Verificando se existe o indicie "view" no array
  if (!isset($data['view']))
    throw new Exception('O índice view não foi encontrado.');

  // Verificando se exite um arquivo com o nome daquele view
  if (!file_exists(VIEWS . $data['view']))
    throw new Exception("A view {$data['view']} não foi encontrado.");

  $view = $data['view'];

  require_once VIEWS . 'master.php';
} catch (Exception $e) {
  //Se ocorrer algum erro nas rotas, avisa com um erro
  var_dump($e->getMessage());
}