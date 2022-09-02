<?php

function execute(bool $isFetchAll = true, bool $isRowCount = false)
{
  //Executa o SELECT
  global $query;

  // dd($query);

  try {
    $connect = connect(); //Conecta ao banco
    //Verifica se há [SQL], se NÃO houver, devolve um erro que não é possivel usar executar o SQL inexistente
    if (!isset($query['sql']))
      throw new Exception('Para realizar o execute, DEVE haver o sql');

    $prepare = $connect->prepare($query['sql']); //prepara o SQL
    $prepare->execute($query['execute'] ?? []); //Executa o array de EXECUTE nomeado
    /*Ex: $prepare->execute([
            'campo1' => 'valor1',
            'campo2' => 'valor2'
          ]);
    */

    if ($isRowCount) {
      //Devolve o SELECT com rowCount
      $query['count'] = $prepare->rowCount();
      return $query['count'];
    } else if ($isFetchAll) {
      //Devolve o SELECT com fetchAll
      return (object)[
        'count' => $query['count'] ?? $prepare->rowCount(),
        'rows' => $prepare->fetchAll()
      ];
    } else
      //Devolve o SELECT com fetch
      return $prepare->fetch();
  } catch (Exception $e) {
    //Devolve um erro formatado
    $error = [
      'FILE' => $e->getFile(),
      'LINE' => $e->getLine(),
      'MESSAGE' => $e->getMessage(),
      'SQL' => $query['sql']
    ];
    //Dump amigavel
    fd($error);
  }
}