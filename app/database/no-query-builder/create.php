<?php

function create(string $table, array $data): bool
{
  // Reponsável por dar INSERT de acordo com o table e dados recebidos
  // Isso é possivel pois na entrada de dados o "name" deve ser o mesmo das colunas da tabelas
  try {
    //Verifica se o array é associativo
    if (!isAssociativeArray($data))
      //Se NÃO for, retorna um erro
      throw new Exception('O array deve ser associativo');

    $connect = connect();

    $sql = "INSERT INTO $table(";
    $sql .= implode(',', array_keys($data)) . ") values(";
    $sql .= ':' . implode(',:', array_keys($data)) . ")";

    $prepare = $connect->prepare($sql);
    return $prepare->execute($data);
  } catch (PDOException $e) {
    var_dump($e->getMessage());
  }
}