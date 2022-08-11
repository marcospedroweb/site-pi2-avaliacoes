<?php

function connect(): PDO
{
  return new PDO(
    "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']}",
    $_ENV['DATABASE_USER'],
    $_ENV['DATABASE_PASSWORD'],
    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
  );
  // [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
  // Transforma o dado que recebe do banco de dados em obj
  // Ex: usuario['nome'] se torna usuario->nome
}