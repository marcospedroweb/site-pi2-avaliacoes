<?php

function limit(string|int $limit)
{
  //Complementa o SQL atual com [limit]
  global $query;

  //Verifica se há [limit], se houver, devolve um erro que não é possivel usar [limit] com [paginate]
  if (isset($query['paginate']))
    throw new Exception('Não é possivel realizar o "limit" com o "paginate"');

  $query['limit'] = true; //Marcador, adicionou [limit]

  $query['sql'] = "{$query['sql']} limit {$limit}";
}