<?php
// Todos os metodos utilizados para fazer requisições ao banco de dados
function all($table, $fields = '*')
{
  try {
    $connect = connect();

    $query = $connect->query("SELECT $fields from $table");
    return $query->fetchAll();
  } catch (PDOException $e) {
    //Se der erro na conexão, mostra o erro
    var_dump($e->getMessage());
  }
}

function findBy($table, $field, $value, $fields = '*')
{
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