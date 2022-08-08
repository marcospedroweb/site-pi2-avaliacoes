<?php
// Adiciona csrf aos formularios do site

function getCsrf()
{
  // Adiciona csrf aos formularios do site
  $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(8));

  return "<input type='hidden' name='csrf' value='" . $_SESSION['csrf'] . "'>";
}

function checkCsrf()
{
  // Verifica se há csrf
  $csrf = filter_string_polyfill($_POST['csrf']);

  //Verifica se existe o input csrf
  if (!$csrf)
    throw new Exception('Token inválido.');

  //Verifica se o csrf está na variavel global session
  if (!isset($_SESSION['csrf']))
    throw new Exception('Token inválido.');

  if ($csrf !== $_SESSION['csrf'])
    throw new Exception('Token inválido.');

  unset($_SESSION['csrf']);
}