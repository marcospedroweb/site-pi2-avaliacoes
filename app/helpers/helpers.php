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

function isFetch()
{
  // Verifica se a requisição é um fetch js ou não
  return isset($_SERVER["HTTP_SEC_FETCH_MODE"]) && $_SERVER["HTTP_SEC_FETCH_MODE"] === 'cors';
}

function fd($data)
{
  //Dump amigavel

  //Quando o sistema está em produção, mostra um erro "amigavel" ao usuario
  if ($_ENV['PRODUCTION'] === 'true')
    dd('Houve algum erro');
  //Quando o sistema NÃO está em produção, mostra um dump comum
  dd($data);
}