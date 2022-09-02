<?php

function order(string $by, string $order = 'asc')
{
  //Complementa o SQL atual com [ORDER BY]
  global $query;

  //Verifica se há [limit], se houver, devolve um erro que não é possivel usar [limit] com [order by]
  if (isset($query['limit']))
    throw new Exception('Antes de chamar o "order" é necessario chamar o "limit"');

  //Verifica se há [paginate], se houver, devolve um erro que não é possivel usar [paginate] com [order by]
  if (isset($query['paginate']))
    throw new Exception('Não é possivel realizar o "order" depois do "paginate"');

  $query['order'] = true; //Marcador, adicionou [order by]

  $query['sql'] = "{$query['sql']} order by {$by} {$order}";
}