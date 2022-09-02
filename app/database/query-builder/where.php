<?php

function where()
{
  //Complementa o SQL atual com [where]
  //EX: where('id', '10')
  //EX: where('id', '<' ,'10')
  global $query;
  $args = func_get_args(); //Pega todos os parametros recebidos
  $numArgs = func_num_args(); //Pega o número de parametros recebidos

  //Verifica se NÃO HÁ [READ/SELECT], se NÃO houver, devolve um erro que não é possivel usar [where] sem [SELECT]
  if (!isset($query['read']))
    throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar 2 where
  if (isset($query['where']))
    throw new Exception('Não é possivel chamar o "where" com o outro tipo de "where"');

  //Verifica se há entre 2-3 parametros, se não houver, devolve um erro
  if ($numArgs < 2 || $numArgs > 3)
    throw new Exception('O "where" deve ter 2 ou 3 parametros');


  $field = $args[0]; // Campo
  $operator = $numArgs === 2 ? '=' : $args[1]; // Operador Padrão ou Operador personalizado ou Valor
  $value = $numArgs === 2 ? $args[1] : $args[2]; // Valor

  $query['where'] = true; //Marcador, adicionou [where]

  $query['execute'] = [...$query['execute'], $field => $value]; // Recebe um array com [campo] e [valor] para ser substituir o placeholder

  $query['sql'] = "{$query['sql']} WHERE {$field} {$operator} :{$field}";
}

function orWhere()
{
  //Complementa o SQL atual com [or where] ou [and where]
  //EX:
  global $query;
  $args = func_get_args(); //Pega todos os parametros recebidos
  $numArgs = func_num_args(); //Pega o número de parametros recebidos

  //Verifica se NÃO HÁ [READ/SELECT], se NÃO houver, devolve um erro que não é possivel usar [where] sem [SELECT]
  if (!isset($query['read']))
    throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

  //Verifica se NÃO HÁ [WHERE], se NÃO houver, devolve um erro que não é possivel usar [or/and where] sem [WHERE] inicial
  if (!isset($query['where']))
    throw new Exception('Antes de chamar o "or where" é necessario chamar o "where"');

  //Verifica se há entre 2-4 parametros, se não houver, devolve um erro
  if ($numArgs < 2 || $numArgs > 4)
    throw new Exception('O "where" deve ter 2 ou 4 parametros');

  // Tipos de operadores aceitados
  $operators = ['=', '<', '>', '!=', '<=', '>='];
  $field = $args[0]; //Campo
  //Verifica se o operador passado existe no array, se existir, adiciona esse operador, se não, adiciona o operador padrão
  $operator = in_array($args[1], $operators) ? $args[1] : '=';

  //Se há 3 argumentos, adiciona o valor Ex: where('id', '10')
  //Se não há 3 argumentos,  adiciona o valor Ex: where('id', '<', '10')
  $value = $numArgs === 3 ? $args[2] : $args[1];

  if ($numArgs === 3)
    //Se há 3 argumentos, Ex: where('id', '10', 'and')
    $typeWhere = $args[2] === 'and' ? $args[2] : 'or';
  else
    //Se não há 3 argumentos, ou seja, há 4 Ex: where('id', '<', '10', 'and')
    $typeWhere = isset($args[3]) && $args[3] === 'and' ? $args[3] : 'or';

  $query['where'] = true; //Marcador, adicionou [where]
  $query['execute'] = [...$query['execute'], $field => $value]; // Recebe um array com [campo] e [valor] para ser substituir o placeholder
  $query['sql'] = "{$query['sql']} {$typeWhere} {$field} {$operator} :{$field}";
}

function whereIn(string $field, array $data)
{
  global $query;
  //Complemento where in no SQL

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar [where in] com [WHERE]
  if (isset($query['where']))
    throw new Exception('Não é possivel chamar o "where in" com o "where"');

  $query['where'] = true; //Marcador, adicionou [where]
  $query['sql'] = "{$query['sql']} WHERE {$field} IN (" . '\'' . implode('\', \'', $data) . "')";
}