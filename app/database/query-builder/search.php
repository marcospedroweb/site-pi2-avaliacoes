<?php

function search(array $search)
{
  //Complementa o SQL atual com [where like]
  global $query;

  //Verifica se há [WHERE], se houver, devolve um erro que não é possivel usar [where] novamente
  if (isset($query['where']))
    throw new Exception('Não pode chamar o where na busca');

  //Verifica se há o parametro é um array associativo
  if (!isAssociativeArray(arr: $search))
    throw new Exception('Para buscar, o array deve ser associativo');

  $sql = "{$query['sql']} WHERE ";

  $execute = [];
  //Adiciona a quantidade de [where like] passadas pelo parametro
  foreach ($search as $field => $searched) {
    $sql .= "{$field} like :{$field} or ";
    $execute[$field] = "%{$searched}%";
  }

  $sql = rtrim($sql, ' or '); //Remove o 'or' que sobra SQL

  $query['sql'] = $sql; //Adiciona a variavel global [$query] o novo SQL
  $query['execute'] = $execute; //Adiciona a variavel global [$query] o novo EXECUTE
}