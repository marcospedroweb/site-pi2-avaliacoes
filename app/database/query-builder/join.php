<?php

use Doctrine\Inflector\InflectorFactory;

function fieldFK(string $table, string $field)
{
  $inflector = InflectorFactory::create()->build();
  $tableToSingular = $inflector->singularize($table); //Colocando o nome da tabela no singular

  return $tableToSingular . ucfirst($field); //Concatena o nome da tabela com o nome do campo
  //Ex: 'user' . ucfirst('id') -> 'userId'
}

function tableJoin(string $table, string $fieldFk, string $typeJoin = 'INNER')
{
  //Complementa o inner join ao sql
  global $query;

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar [inner join] com [WHERE]
  if (isset($query['where']))
    throw new Exception('Não é possivel adicionar o "inner join" com o "where"');

  $fkToJoin = fieldFK($query['table'], $fieldFk);
  $query['sql'] = "{$query['sql']} {$typeJoin} JOIN {$table} ON {$table}.{$fkToJoin} = {$query['table']}.{$fieldFk}";
}

function tableJoinWithFK(string $table, string $fieldFk, string $typeJoin = 'INNER')
{
  //Complementa o join variado ao sql

  global $query;
  //Complementa o inner join ao sql

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar [inner join] com [WHERE]
  if (isset($query['where']))
    throw new Exception('Não é possivel adicionar o "inner join" com o "where"');

  $fkToJoin = fieldFK($table, $fieldFk);
  $query['sql'] = "{$query['sql']} {$typeJoin} JOIN {$table} ON {$table}.{$fieldFk} = {$query['table']}.{$fkToJoin}";
}