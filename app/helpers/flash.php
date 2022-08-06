<?php

function setFlash(string $index, string $message): void
{
  //Adiciona a messagem a sessão
  if (!isset($_SESSION['flash'][$index]))
    $_SESSION['flash'][$index] = $message;
}

function getFlash(string $index, string $style = 'color:red'): string
{
  //Mostra a messagem na sessão
  if (isset($_SESSION['flash'][$index])) {
    $flash = $_SESSION['flash'][$index];
    unset($_SESSION['flash'][$index]);
    return "<span style='$style'>$flash</span>";
  }
}