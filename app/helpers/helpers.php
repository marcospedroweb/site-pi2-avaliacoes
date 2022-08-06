<?php
// Aqui é onde estão funções genericas que pode sem ser usadas em qualquer lugar

function isAssociativeArray(array $arr): bool
{
  // Verifica se o array do parametro é associativo, ou seja, se os indices são de numericos ou os indices possuem "palavras"
  return array_keys($arr) !== range(0, count($arr) - 1);
}

function filter_string_polyfill(string $field): string
{
  //Filtra o dado
  $str = preg_replace('/\x00|<[^>]*>?/', '', $field);
  return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
}

if (!function_exists('dd')) {
  function dd(): void
  {
    //Reponsavel por mostrar algo com var_dump e finalizar o app com die();
    echo '<pre>';
    foreach (func_get_args() as $value)
      var_dump($value);

    echo '</pre>';
    die();
  }
}