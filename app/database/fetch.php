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

function where(string $field, string $operator, string $value)
{
  global $query;

  if (!isset($query['read']))
    throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

  if (func_num_args() !== 3)
    throw new Exception('O "where" deve ter 3 parametros');

  $query['where'] = true;
  $query['execute'] = [...$query['execute'], $field => $value];
  $query['sql'] = "{$query['sql']} where {$field} {$operator} :{$field}";
}

function orWhere()
{
  global $query;

  if (!isset($query['where']))
    throw new Exception('Antes de chamar o "or where" é necessario chamar o "where"');
}

function execute()
{
  global $query;

  $connect = connect();
  $prepare = $connect->prepare($query['sql']);
  $prepare->execute($query['execute'] ?? []);

  return $prepare->fetchAll();
}

function search()
{
}

function paginate()
{
}

function order()
{
}