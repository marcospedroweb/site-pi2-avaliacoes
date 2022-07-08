<?php

require_once(__DIR__ . '/configBanco.php'); // (__DIR__) Faz magia encontrado exatamente onde está aquele arquivo

$bd_dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
$bd_user = DB_USER;
$bd_pass = DB_PASS;

$bd = new PDO($bd_dsn, $bd_user, $bd_pass);//Conecta ao banco SQL

//sql microsoft
// $serverName = "GOMYBR\SQLEXPRESS"; //serverName\instanceName
// $connectionInfo = array( "Database"=>"avalifind");
// $conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( !($conn) ) {
//   echo "Connection could not be established.<br>";
//   die( print_r( sqlsrv_errors(), true));
// }
