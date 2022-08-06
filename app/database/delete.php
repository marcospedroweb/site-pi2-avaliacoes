<?php
// Responsável por realizar o delete de algo no banco

function delete(string $table, array $where)
{
  $connect = connect();
  //Verifica se o array é associativo
  if (!isAssociativeArray($where))
    //Se NÃO for, retorna um erro
    throw new Exception('O array deve ser associativo');


  $whereField = array_keys($where); //Pegando o nome da coluna

  $sql = "DELETE FROM {$table}
          WHERE {$whereField[0]} = :{$whereField[0]}";

  $prepare = $connect->prepare($sql);
  $prepare->execute($where); //Array já com coluna e valor
  return $prepare->rowCount(); //Retorna a quantidade de linha afetadas
}