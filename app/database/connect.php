<?php

function connect()
{
  return new PDO(
    'mysql:host=localhost;dbname=Avalifind',
    'root',
    '',
    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
  );
  // [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
  // Transforma o dado que recebe do banco de dados em obj
  // Ex: usuario['nome'] se torna usuario->nome
}
