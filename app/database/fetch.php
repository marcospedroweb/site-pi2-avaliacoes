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