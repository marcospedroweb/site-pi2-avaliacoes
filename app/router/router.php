<?php

function exactMatchUriInArrayRoutes($uri, $routes)
{
  //Procura no array de rotas aquele uri fixas
  //Se achar, retorna a uri exata no array
  return (array_key_exists($uri, $routes)) ? [$uri => $routes[$uri]] : []; //Se não, retorna um array vazio
}

function regularExpressionMatchArrayRoutes($uri, $routes)
{
  //Procura no array de rotas as uri dinamicas
  return array_filter(
    $routes,
    function ($value) use ($uri) {
      $regex = str_replace('/', '\/', ltrim($value, '/'));
      return preg_match("/^$regex$/", ltrim($uri, '/')); //Verificando se o regex é compativel com a uri
    },
    ARRAY_FILTER_USE_KEY
  );
}

function params($uri, $matchedUri)
{
  if (!empty($matchedUri)) {
    //Se a uri com regex NÃO estiver vazio, eu pego os parametros da mesma
    $matchedToGetParams = array_keys($matchedUri)[0]; //Seleciona o indice do array
    return array_diff(
      $uri,
      explode('/', ltrim($matchedToGetParams, '/')),
    );
  }

  return [];
}

function paramsFormat($uri, $params)
{
  //Retorna um array com index de valor igual ao atributo e seu valor
  // Ex: ['nomeUsuario' => "Nome do usuario"]
  $paramsData = [];
  foreach ($params as $index => $param)
    //Retorna um array com index de acordo com seu valor
    $paramsData[$uri[$index === 0 ? $index : $index - 1]] = $param;

  return $paramsData;
}

function router()
{
  //Retorna o uri
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  //Array com todas as rotas
  $routes = require_once 'routes.php';
  $requestMethod = $_SERVER['REQUEST_METHOD']; // Retorna o tipo de requisição

  //Retorna o uri correto
  $matchedUri = exactMatchUriInArrayRoutes($uri, $routes[$requestMethod]);

  $params = [];
  if (empty($matchedUri)) {
    //Se não encontrar a rota, vai procurar pelo regex no uri
    $matchedUri = regularExpressionMatchArrayRoutes($uri, $routes[$requestMethod]);
    $uri = explode('/', ltrim($uri, '/'));
    //Caso seja uma uri dinamica e eu queira os parametros nela, utilizo o função params
    //Retorna os parametros da uri Regex, com os index de acordo com o explode
    $params = params($uri, $matchedUri);
    //Retorna um array com index de valor igual ao atributo e seu valor
    $params = paramsFormat($uri, $params);
  }

  if ($_ENV['MAINTENANCE'] === 'true') {
    dd('Em manutenção');
    $matchedUri = ['maintenance' => 'Maintenance@index'];
  }

  if (!empty($matchedUri)) {
    //Se encontrar a rota compativel, inicia o metodo para retornar a pagina
    return controller($matchedUri, $params);
  }

  throw new Exception('PAGE 404, pagina não encontrada'); //Se ocorrer algo de errado, joga um erro na tela
}