<?php

function redirect(string $to)
{
  // Redireciona para a pagina passada
  return header('Location: ' . $to);
}

function setMessageErrorLoginAndRedirect(string $index, string $message, string $redirectTo = '/')
{
  //Mostra um erro de login e devolve o usuario para pagina que estava
  setFlash($index, $message);
  return redirect($redirectTo);
}