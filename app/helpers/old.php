<?php
// Apos erro em algum campo do formulario, mantem os dados que estao corretos
function setOld()
{
  //Guarda na variavel sessao os dados do formulario enviado, se não houver, adiciona um array vazio
  $_SESSION['old'] = $_POST ?? [];
}

function getOld($index)
{
  //Se os dados enviados estiverem certo, coloca eles nos inputs
  if (isset($_SESSION['old'][$index])) {
    $old = $_SESSION['old'][$index];
    unset($_SESSION['old'][$index]);
    return $old ?? '';
  }
}

function destroyOld()
{
  if (isset($_SESSION['old']))
    unset($_SESSION['old']);
}