<?php

function controller($matchedUri, $params)
{
  //Essa função é responsavel por o sistema funcionar, recebendo pela rota qual controller devera ser usado e qual metodo

  [$controller, $method] = explode('@', array_values($matchedUri)[0]); //Retorna qual "metodo" devera ser instanciado pelo controller
  // [$controller, $method], atribui os valores retornados as variaveis respectivamente, nesse caso 2 variaveis, 2 retornos
  $controllerWithNameSpace = CONTROLLER_PATH . $controller;

  //Verificando se a classe NÃO existe
  if (!class_exists($controllerWithNameSpace))
    //Se NÃO existir, joga um erro na tela
    throw new Exception("Controller {$controller} não existe");

  $controllerInstance = new $controllerWithNameSpace;

  //Verificando se o metodo NÃO existe
  if (!method_exists($controllerInstance, $method))
    //Se o metodo NÃO existir, joga um erro na tela
    throw new Exception("Esse metodo {$method} não existe no controller {$controller}");

  $controller = $controllerInstance->$method($params);

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
    //Se o metodo de requisição for POST, finaliza o programa para evitar que no public/index.php execute o restante
    die();

  return $controller; //Retornando um array para o router e depois index.php
}