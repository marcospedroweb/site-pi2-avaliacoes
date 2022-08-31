<?php
// Todos os metodos utilizados para fazer requisições ao banco de dados
use Doctrine\Inflector\InflectorFactory;


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

//Query builder
$query = [];

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

function order(string $by, string $order = 'asc')
{
  //Complementa o SQL atual com [ORDER BY]
  global $query;

  //Verifica se há [limit], se houver, devolve um erro que não é possivel usar [limit] com [order by]
  if (isset($query['limit']))
    throw new Exception('Antes de chamar o "order" é necessario chamar o "limit"');

  //Verifica se há [paginate], se houver, devolve um erro que não é possivel usar [paginate] com [order by]
  if (isset($query['paginate']))
    throw new Exception('Não é possivel realizar o "order" depois do "paginate"');

  $query['order'] = true; //Marcador, adicionou [order by]

  $query['sql'] = "{$query['sql']} order by {$by} {$order}";
}

function paginate(string|int $perPage = 10)
{
  //Complementa o SQL atual com [PAGINATE], offset
  global $query;

  //Verifica se há [limit], se houver, devolve um erro que não é possivel usar [limit] com [paginate]
  if (isset($query['limit']))
    throw new Exception('Não é possivel realizar o "paginate" com o "limit"');

  $rowCount = execute(isRowCount: true);
  $page = (int)filter_string_polyfill($_GET['page'] ?? 1);

  $query['currentPage'] = $page; // armazena a pagina atual
  // [ceil] arredonda para cima
  $query['pageCount'] = (int)ceil($rowCount / $perPage); // Calculando a quantidade de paginas
  $offset = ($page - 1) * $perPage; //Calcula quanto será o offset
  //Ex: (10 - 1) * 5
  //Ex: 9 * 5 == 45

  $query['paginate'] = true; //Marcador, adicionou [paginate]
  $query['sql'] = "{$query['sql']} limit {$perPage} offset {$offset}";
}

function render()
{
  //Renderiza o sistema de paginação

  global $query;

  $pageCount = $query['pageCount'];
  $links = '<ul class="pagination">';

  if ($query["currentPage"] != 1) {
    $previousPage = $query["currentPage"] - 1;
    $previousPageStatus = $query["currentPage"] == 1 ? 'disabled' : '';
    $linkPage = http_build_query(array_merge($_GET, ['page' => $previousPage])); // Concatena todas as variaveis do get, com a pagina atual

    $links .= "<li class='page-item {$previousPageStatus}'>
                  <a class='page-link' href='?{$linkPage}'>Anterior</a>
                </li>";
  }

  for ($i = 1; $i <= $pageCount; $i++) {
    $activePage = $i == $query["currentPage"] ? 'active' : '';
    $linkPage = http_build_query(array_merge($_GET, ['page' => $i])); // Concatena todas as variaveis do get, com a pagina atual

    $links .= "<li class='page-item {$activePage}'>
    <a class='page-link' href='?{$linkPage}'>{$i}</a>
    </li>";
  }

  if ($query["currentPage"] + 1 <= $pageCount) {
    $nextPage = $query["currentPage"] + 1;
    $nextPageStatus = $query["currentPage"] + 1 > $pageCount ? 'disabled' : '';
    $linkPage = http_build_query(array_merge($_GET, ['page' => $nextPage])); // Concatena todas as variaveis do get, com a pagina atual

    $links .= "<li class='page-item {$nextPageStatus}'>
                  <a class='page-link' href='?{$linkPage}'>Next</a>
                </li>";
  }


  $links .= '</ul>';

  return $links;
}

function limit(string|int $limit)
{
  //Complementa o SQL atual com [limit]
  global $query;

  //Verifica se há [limit], se houver, devolve um erro que não é possivel usar [limit] com [paginate]
  if (isset($query['paginate']))
    throw new Exception('Não é possivel realizar o "limit" com o "paginate"');

  $query['limit'] = true; //Marcador, adicionou [limit]

  $query['sql'] = "{$query['sql']} limit {$limit}";
}


function where()
{
  //Complementa o SQL atual com [where]
  //EX: where('id', '10')
  //EX: where('id', '<' ,'10')
  global $query;
  $args = func_get_args(); //Pega todos os parametros recebidos
  $numArgs = func_num_args(); //Pega o número de parametros recebidos

  //Verifica se NÃO HÁ [READ/SELECT], se NÃO houver, devolve um erro que não é possivel usar [where] sem [SELECT]
  if (!isset($query['read']))
    throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar 2 where
  if (isset($query['where']))
    throw new Exception('Não é possivel chamar o "where" com o outro tipo de "where"');

  //Verifica se há entre 2-3 parametros, se não houver, devolve um erro
  if ($numArgs < 2 || $numArgs > 3)
    throw new Exception('O "where" deve ter 2 ou 3 parametros');


  $field = $args[0]; // Campo
  $operator = $numArgs === 2 ? '=' : $args[1]; // Operador Padrão ou Operador personalizado ou Valor
  $value = $numArgs === 2 ? $args[1] : $args[2]; // Valor

  $query['where'] = true; //Marcador, adicionou [where]

  $query['execute'] = [...$query['execute'], $field => $value]; // Recebe um array com [campo] e [valor] para ser substituir o placeholder

  $query['sql'] = "{$query['sql']} WHERE {$field} {$operator} :{$field}";
}

function orWhere()
{
  //Complementa o SQL atual com [or where] ou [and where]
  //EX:
  global $query;
  $args = func_get_args(); //Pega todos os parametros recebidos
  $numArgs = func_num_args(); //Pega o número de parametros recebidos

  //Verifica se NÃO HÁ [READ/SELECT], se NÃO houver, devolve um erro que não é possivel usar [where] sem [SELECT]
  if (!isset($query['read']))
    throw new Exception('Antes de chamar o "where" é necessario chamar o "read"');

  //Verifica se NÃO HÁ [WHERE], se NÃO houver, devolve um erro que não é possivel usar [or/and where] sem [WHERE] inicial
  if (!isset($query['where']))
    throw new Exception('Antes de chamar o "or where" é necessario chamar o "where"');

  //Verifica se há entre 2-4 parametros, se não houver, devolve um erro
  if ($numArgs < 2 || $numArgs > 4)
    throw new Exception('O "where" deve ter 2 ou 4 parametros');

  // Tipos de operadores aceitados
  $operators = ['=', '<', '>', '!=', '<=', '>='];
  $field = $args[0]; //Campo
  //Verifica se o operador passado existe no array, se existir, adiciona esse operador, se não, adiciona o operador padrão
  $operator = in_array($args[1], $operators) ? $args[1] : '=';

  //Se há 3 argumentos, adiciona o valor Ex: where('id', '10')
  //Se não há 3 argumentos,  adiciona o valor Ex: where('id', '<', '10')
  $value = $numArgs === 3 ? $args[2] : $args[1];

  if ($numArgs === 3)
    //Se há 3 argumentos, Ex: where('id', '10', 'and')
    $typeWhere = $args[2] === 'and' ? $args[2] : 'or';
  else
    //Se não há 3 argumentos, ou seja, há 4 Ex: where('id', '<', '10', 'and')
    $typeWhere = isset($args[3]) && $args[3] === 'and' ? $args[3] : 'or';

  $query['where'] = true; //Marcador, adicionou [where]
  $query['execute'] = [...$query['execute'], $field => $value]; // Recebe um array com [campo] e [valor] para ser substituir o placeholder
  $query['sql'] = "{$query['sql']} {$typeWhere} {$field} {$operator} :{$field}";
}

function whereIn(string $field, array $data)
{
  global $query;
  //Complemento where in no SQL

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar [where in] com [WHERE]
  if (isset($query['where']))
    throw new Exception('Não é possivel chamar o "where in" com o "where"');

  $query['where'] = true; //Marcador, adicionou [where]
  $query['sql'] = "{$query['sql']} WHERE {$field} IN (" . '\'' . implode('\', \'', $data) . "')";
}

function fieldFK(string $table, string $field)
{
  $inflector = InflectorFactory::create()->build();
  $tableToSingular = $inflector->singularize($table); //Colocando o nome da tabela no singular

  return $tableToSingular . ucfirst($field); //Concatena o nome da tabela com o nome do campo
  //Ex: 'user' . ucfirst('id') -> 'userId'
}

function tableJoin(string $table, string $fieldFk, string $typeJoin = 'INNER')
{
  //Complementa o inner join ao sql
  global $query;

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar [inner join] com [WHERE]
  if (isset($query['where']))
    throw new Exception('Não é possivel adicionar o "inner join" com o "where"');

  $fkToJoin = fieldFK($query['table'], $fieldFk);
  $query['sql'] = "{$query['sql']} {$typeJoin} JOIN {$table} ON {$table}.{$fkToJoin} = {$query['table']}.{$fieldFk}";
}

function tableJoinWithFK(string $table, string $fieldFk, string $typeJoin = 'INNER')
{
  //Complementa o join variado ao sql

  global $query;
  //Complementa o inner join ao sql

  //Verifica se HÁ [WHERE], se houver, devolve um erro que não é possivel usar [inner join] com [WHERE]
  if (isset($query['where']))
    throw new Exception('Não é possivel adicionar o "inner join" com o "where"');

  $fkToJoin = fieldFK($table, $fieldFk);
  $query['sql'] = "{$query['sql']} {$typeJoin} JOIN {$table} ON {$table}.{$fieldFk} = {$query['table']}.{$fkToJoin}";
}

function search(array $search)
{
  //Complementa o SQL atual com [where like]
  global $query;

  //Verifica se há [WHERE], se houver, devolve um erro que não é possivel usar [where] novamente
  if (isset($query['where']))
    throw new Exception('Não pode chamar o where na busca');

  //Verifica se há o parametro é um array associativo
  if (!isAssociativeArray(arr: $search))
    throw new Exception('Para buscar, o array deve ser associativo');

  $sql = "{$query['sql']} WHERE ";

  $execute = [];
  //Adiciona a quantidade de [where like] passadas pelo parametro
  foreach ($search as $field => $searched) {
    $sql .= "{$field} like :{$field} or ";
    $execute[$field] = "%{$searched}%";
  }

  $sql = rtrim($sql, ' or '); //Remove o 'or' que sobra SQL

  $query['sql'] = $sql; //Adiciona a variavel global [$query] o novo SQL
  $query['execute'] = $execute; //Adiciona a variavel global [$query] o novo EXECUTE
}

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

    if ($isRowCount)
      //Devolve o SELECT com rowCount
      return $prepare->rowCount();
    else if ($isFetchAll)
      //Devolve o SELECT com fetchAll
      return $prepare->fetchAll();
    else
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