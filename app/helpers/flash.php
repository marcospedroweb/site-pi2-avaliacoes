<?php

function setFlash($index, $message)
{
  //Adiciona a messagem a sessão
  if (!isset($_SESSION['flash'][$index]))
    $_SESSION['flash'][$index] = $message;
}

function getFlash($index, $style = 'color:red')
{
  //Mostra a messagem na sessão
  if (isset($_SESSION['flash'][$index])) {
    $flash = $_SESSION['flash'][$index];
    unset($_SESSION['flash'][$index]);
    return "<span style='$style'>$flash</span>";
  }
}