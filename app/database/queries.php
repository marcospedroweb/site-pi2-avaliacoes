<?php
// Todos os metodos utilizados para fazer requisições ao banco de dados
$query = [];

// Todos os metodos utilizados para fazer requisições ao banco de dados
//Query Builder
require __DIR__ . './query-builder/read.php';
require __DIR__ . './query-builder/limit.php';
require __DIR__ . './query-builder/join.php';
require __DIR__ . './query-builder/order.php';
require __DIR__ . './query-builder/paginate.php';
require __DIR__ . './query-builder/where.php';
require __DIR__ . './query-builder/search.php';
require __DIR__ . './query-builder/execute.php';

//No Query Builder
require __DIR__ . './no-query-builder/create.php';
require __DIR__ . './no-query-builder/update.php';
require __DIR__ . './no-query-builder/delete.php';