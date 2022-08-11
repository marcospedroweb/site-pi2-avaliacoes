<?php
// Todos os metodos utilizados para fazer requisições ao banco de dados

function all(string $table, string $fields = '*'): array
{
  //Realiza um SELECT de acordo com a tabela e as colunas necessarias
  //Retorna um array
  try {
    $connect = connect();

    $query = $connect->query("SELECT $fields from $table");
    return $query->fetchAll();
  } catch (PDOException $e) {
    //Se der erro na conexão, mostra o erro
    var_dump($e->getMessage());
  }
}

function findBy(string $table, string $field, string $value, mixed $fields = '*'): array
{
  //Realiza um select de acordo com a tabela e os campos necessarios
  //Retorna um array
  try {
    $connect = connect();
    $prepare = $connect->prepare("SELECT $fields FROM $table WHERE $field = :field");
    $prepare->execute([
      ':field' => $value
    ]);
    return $prepare->fetchAll();
  } catch (PDOException $e) {
    //Se der erro na conexão, mostra o erro
    var_dump($e->getMessage());
  }
}

//Query builder
$query = [];

function read(string $table, string $fields = '*')
{
  global $query;

  $query['read'] = true;
  $query['execute'] = [];

  $query['sql'] = "SELECT {$fields} FROM {$table}";
}

function order(string $by, string $order = 'asc')
{
  global $query;

  if (isset($query['limit']))
    throw new Exception('Antes de chamar o "order" é necessario chamar o "limit"');

  if (isset($query['paginate']))
    throw new Exception('Não é possivel realizar o "order" depois do "paginate"');

  $query['order'] = true;

  $query['sql'] = "{$query['sql']} order by {$by} {$order}";
}

function paginate(string|int $perPage = 10)
{
  global $query;

  if (isset($query['limit']))
    throw new Exception('Não é possivel realizar o "paginate" com o "limit"');

  $query['paginate'] = true;
}

function limit(string|int $limit)
{
  global $query;

  if (isset($query['paginate']))
    throw new Exception('Não é possivel realizar o "limit" com o "paginate"');

  $query['limit'] = true;

  $query['sql'] = "{$query['sql']} limit {$limit}";
}


function where()
{
  global $query;
  $args = func_get_args();
  $numArgs = func_num_args();

  if (!isset($query['read']))
    throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

  if ($numArgs < 2 || $numArgs > 3)
    throw new Exception('O "where" deve ter 2 ou 3 parametros');

  $field = $args[0];
  $operator = $numArgs === 2 ? '=' : $args[1];
  $value = $numArgs === 2 ? $args[1] : $args[2];

  $query['where'] = true;
  $query['execute'] = [...$query['execute'], $field => $value];
  $query['sql'] = "{$query['sql']} where {$field} {$operator} :{$field}";
}

// function where(string $field, string $operator, string $value)
// {
//   global $query;

//   if (!isset($query['read']))
//     throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

//   if (func_num_args() !== 3)
//     throw new Exception('O "where" deve ter 3 parametros');

//   $query['where'] = true;
//   $query['execute'] = [...$query['execute'], $field => $value];
//   $query['sql'] = "{$query['sql']} where {$field} {$operator} :{$field}";
// }

function orWhere()
{
  global $query;
  $args = func_get_args();
  $numArgs = func_num_args();

  if (!isset($query['read']))
    throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

  if (!isset($query['where']))
    throw new Exception('Antes de chamar o "or where" é necessario chamar o "where"');

  if ($numArgs < 2 || $numArgs > 4)
    throw new Exception('O "where" deve ter 2 ou 4 parametros');

  $operators = ['=', '<', '>', '!=', '<=', '>='];
  $field = $args[0];
  $operator = in_array($args[1], $operators) ? $args[1] : '=';
  $value = $numArgs === 3 ? $args[1] : $args[2];
  if ($numArgs === 3)
    $typeWhere = $args[2] === 'and' ? $args[2] : 'or';
  else
    $typeWhere = isset($args[3]) && $args[3] === 'and' ? $args[3] : 'or';

  $query['where'] = true;
  $query['execute'] = [...$query['execute'], $field => $value];
  $query['sql'] = "{$query['sql']} {$typeWhere} {$field} {$operator} :{$field}";
}

// function orWhere(string $field, string $operator, string $value, string $typeWhere = 'or')
// {
//   global $query;

//   if (!isset($query['read']))
//     throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

//   if (!isset($query['where']))
//     throw new Exception('Antes de chamar o "or where" é necessario chamar o "where"');

//   if (func_num_args() < 3 || func_num_args() > 4)
//     throw new Exception('O "where" deve ter 3 ou 4 parametros');

//   $query['where'] = true;
//   $query['execute'] = [...$query['execute'], $field => $value];
//   $query['sql'] = "{$query['sql']} {$typeWhere} {$field} {$operator} :{$field}";
// }

function execute()
{
  global $query;

  $connect = connect();
  $prepare = $connect->prepare($query['sql']);
  $prepare->execute($query['execute'] ?? []);

  return $prepare->fetchAll();
}