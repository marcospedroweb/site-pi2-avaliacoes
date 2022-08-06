<?php
// Responsavel por fazer a atualização de algum dado da tabela

function update(string $table, array $fields, array $where)
{
  $connect = connect();
  //Verifica se os arrays são associativo
  if (!isAssociativeArray($fields) || !isAssociativeArray($where))
    //Se NÃO for, retorna um erro
    throw new Exception('O array deve ser associativo');

  // Criando o sql dinamico
  $sql = "UPDATE $table 
          SET ";
  foreach (array_keys($fields) as $field)
    $sql .= "$field = :$field,"; // Adiciona todos os campos passados no array $fields

  $sql = trim($sql, ', '); // Remove a virgula do final
  $whereFields = array_keys($where); //Retornando o nome dos campos

  $sql .= " WHERE $whereFields[0] = :$whereFields[0] ";

  $data = array_merge($fields, $where); // Juntando os arrays com os valores de campos e wheres necessarios

  $prepare = $connect->prepare($sql);
  $prepare->execute($data);
  return $prepare->rowCount(); //Retorna a quantidade de linhas afetadas
}