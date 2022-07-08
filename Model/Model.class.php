<?php
include_once __DIR__ . '../config/configBanco.php';

abstract class Model extends PDO
{
  //Extendendo a classe PDO do php

  protected string $tabela;

  public function __construct()
  {

    if (!defined('DSN') || !defined('DB_USER') || !defined('DB_PASS')) {
      die('Não há arquivo de configuração do BD');
    }

    parent::__construct(DSN, DB_USER, DB_PASS); //Instanciando o banco com o PDO
  }

  abstract function criar(array $dados): array;

  abstract function atualizar(array $dados): array;

  abstract function listar(array $dados): array;

  abstract function apagar(array $dados): array;
}
