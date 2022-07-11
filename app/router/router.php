<?php

function routes()
{
  return require_once 'routes.php';
}

function exactMatchUriInArrayRoutes($uri, $routes)
{
  //Procura no array de rotas aquele uri fixas
  if (array_key_exists($uri, $routes)) {
    //Se achar, retorna a uri exata
    return [$uri => $routes[$uri]];
  }
  return [];
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
    $matchedToGetParams = array_keys($matchedUri)[0];
    return array_diff(
      explode('/', ltrim($uri, '/')),
      explode('/', ltrim($matchedToGetParams, '/')),
    );
  }

  return [];
}

function formatParams($uri, $params)
{
  //Retorna um array com index de valor igual ao atributo e seu valor
  // Ex: ['nomeUsuario' => "Nome do usuario"]
  $uri = explode('/', ltrim($uri, '/'));
  $paramsData = [];
  foreach ($params as $index => $param)
    //Retorna um array com index de acordo com seu valor
    $paramsData[$uri[$index - 1]] = $param;
}

function router()
{
  //Retorna o uri
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  //Array com todas as rotas
  $routes = routes();
  //Retorna o uri correto
  $matchedUri = exactMatchUriInArrayRoutes($uri, $routes);

  if (empty($matchedUri)) {
    //Se não encontrar, vai procurar pelo regex no uri
    $matchedUri = regularExpressionMatchArrayRoutes($uri, $routes);
    //Caso seja uma uri dinamica e eu queira os parametros nela, utilizo o função params
    //Retorna os parametros da uri Regex, com os index de acordo com o explode
    $params = params($uri, $matchedUri);
    //Retorna um array com index de valor igual ao atributo e seu valor
    $params = formatParams($uri, $params);
  }
  die();
}
