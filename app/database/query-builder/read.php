<?php

function read(string $table, string $fields = '*')
{
  //Realiza um SELECT de acordo com a tabela e seus campos
  global $query;

  //Reseta o query builder
  $query = [];

  $query['read'] = true; //Marcador, inicou um SELECT
  $query['table'] = $table; //Armazena o nome da tabela
  $query['execute'] = []; //Array onde será armazenado os valores que substituirá os placeholders

  $query['sql'] = "SELECT {$fields} FROM {$table}"; //Inicia o SQL com os campos e tabela
}

function all(string $table, string $fields = '*'): array
{
  //Realiza um SELECT de acordo com a tabela e as colunas necessarias
  try {
    $connect = connect();

    $query = $connect->query("SELECT $fields from $table");
    //Retorna um array
    return $query->fetchAll();
  } catch (PDOException $e) {
    //Se der erro na conexão, mostra o erro
    var_dump($e->getMessage());
  }
}

function findBy(string $table, string $field, string $value, mixed $fields = '*'): array
{
  //Realiza um select de acordo com a tabela e os campos necessarios
  try {
    $connect = connect();
    $prepare = $connect->prepare("SELECT $fields FROM $table WHERE $field = :field");
    $prepare->execute([
      ':field' => $value
    ]);
    //Retorna um array
    return $prepare->fetchAll();
  } catch (PDOException $e) {
    //Se der erro na conexão, mostra o erro
    var_dump($e->getMessage());
  }
}