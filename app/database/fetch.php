<?php

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