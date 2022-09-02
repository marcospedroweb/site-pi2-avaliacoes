<?php

function paginate(string|int $perPage = 10)
{
  //Complementa o SQL atual com [PAGINATE], offset
  global $query;

  //Verifica se há [limit], se houver, devolve um erro que não é possivel usar [limit] com [paginate]
  if (isset($query['limit']))
    throw new Exception('Não é possivel realizar o "paginate" com o "limit"');

  $rowCount = execute(isRowCount: true); // Armazena a quantidade total de registros
  $page = (int)filter_string_polyfill($_GET['page'] ?? 1);

  $query['currentPage'] = $page; // armazena a pagina atual
  // [ceil] arredonda para cima
  $query['totalPages'] = (int)ceil($rowCount / $perPage); // Calculando a quantidade de paginas
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
  $links = '';
  $maxLinks = 5;

  if (isset($query['totalPages'])) {
    //Variaveis iniciais
    $totalPages = $query['totalPages'];
    $currentPage = $query['currentPage'];
    $links = '<ul class="pagination">';

    //Calculando as variaveis para o botão voltar
    //Verifica se a pagina atual é diferente de 1
    if ($currentPage > 1) {
      $previousPage = $currentPage - 1;
      $previousPageStatus = $currentPage == 1 ? 'disabled' : '';
      $linkPage = http_build_query(array_merge($_GET, ['page' => $previousPage])); // Concatena todas as variaveis do get, com a pagina atual
      $firstPage = http_build_query(array_merge($_GET, ['page' => 1]));

      $links .= "<li class='page-item'>
                    <a class='page-link' href='?{$firstPage}'>Primeira</a>
                  </li>";
      $links .= "<li class='page-item {$previousPageStatus}'>
                    <a class='page-link' href='?{$linkPage}'>Anterior</a>
                  </li>";
    }

    //Adicionando a quantidade de links para cada pagina
    //Começa pela pagina inicial menos o maximo de links
    //O for é executado até a soma da pagina atual com a quantidade de links
    //Ex: $i = 8 - 5 == 3; $i <= 8 + 5 == 13, sendo assim, mostra links da pagina 3 até a pagina 13
    for ($i = $currentPage - $maxLinks; $i <= $currentPage + $maxLinks; $i++) {
      if ($i > 0 && $i <= $totalPages) {
        $activePage = $i == $currentPage ? 'active' : '';
        $linkPage = http_build_query(array_merge($_GET, ['page' => $i])); // Concatena todas as variaveis do get, com a pagina atual

        $links .= "<li class='page-item {$activePage}'>
                      <a class='page-link' href='?{$linkPage}'>{$i}</a>
                    </li>";
      }
    }

    //Calculando as variaveis para o botão avançar
    //Verifica se a pagina atual + 1 é menor que a quantidade total de paginas
    if ($currentPage < $totalPages) {
      $nextPage = $currentPage + 1; //Pagina atual + 1
      $nextPageStatus = $currentPage + 1 > $totalPages ? 'disabled' : '';
      $linkPage = http_build_query(array_merge($_GET, ['page' => $nextPage])); // Concatena todas as variaveis do get, com a pagina atual
      $lastPage = http_build_query(array_merge($_GET, ['page' => $totalPages]));

      $links .= "<li class='page-item {$nextPageStatus}'>
                    <a class='page-link' href='?{$linkPage}'>Proximo</a>
                  </li>";
      $links .= "<li class='page-item'>
                    <a class='page-link' href='?{$lastPage}'>Ultima</a>
                  </li>";
    }

    //Fechando o paginate
    $links .= '</ul>';
  }


  return $links;
}