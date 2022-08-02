<?php

function user()
{
  //Se o usuario estiver logado, retorna o que está armazenado na sessão
  if (logged())
    return $_SESSION[LOGGED][0];
}

function logged()
{
  //Verifica se o usuario está logado ou não
  return isset($_SESSION[LOGGED]);
}