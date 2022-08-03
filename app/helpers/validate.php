<?php

function validate(array $validations)
{
  $result = [];
  $param = '';
  //Responsável por validar os dados do array
  foreach ($validations as $field => $validate) {
    $result[$field] = (!str_contains($validate, '|'))
      ? singleValidation($validate, $field, $param)
      : multipleValidations($validate, $field, $param);
  }

  echo '<pre>';
  var_dump($result);
  die();

  //Procura no array se há algum resultado que deu false, retornando "erro"
  if (in_array(false, $result))
    return false;

  return $result;
}

function singleValidation($validate, $field, $param)
{
  if (str_contains($validate, ':'))
    [$validate, $param] = explode(':', $validate);

  //Verifica se há "|" na validação, se NÃO houver, há apenas 1 validate
  return $validate($field, $param); // Chamando a função required e armazena o resultado
}

function multipleValidations($validate, $field, $param)
{
  $result = [];
  //Verifica se há "|" na validação, se houver, há mais de 1 validate
  $explodePipeValidate = explode('|', $validate);
  foreach ($explodePipeValidate as $validate) {
    //Verificando se há parametro
    if (str_contains($validate, ':'))
      //Se houver, separa o valor e paramtro
      [$validate, $param] = explode(':', $validate);
    $result[$field] = $validate($field, $param); //Executa a função de acordo com o nome
  }

  return $result[$field];
}

function required($field)
{
  //Verificando se o input do POST está vazio
  if ($_POST[$field] === '') {
    //Se estiver, retona um erro
    setFlash($field, 'O campo é obrigatorio');
    return false;
  }

  return filter_string_polyfill($_POST[$field]); //Retorna aquele dado filtrado
}

function email($field)
{
  //Verificando se o email é valido
  $emailIsValid = filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL);
  if (!$emailIsValid) {
    setFlash($field, "O campo tem que ser um email válido");
    return false;
  }

  return filter_string_polyfill($emailIsValid);
}

function unique($field, $param)
{
  $data = filter_string_polyfill($_POST[$field]);
  $user = findBy($param, $field, $data);

  if ($user) {
    setFlash($field, "O valor preenchido já está cadastrado.");
    return false;
  }

  return $data;
}

function maxlen($field, $param)
{
  $data = filter_string_polyfill($_POST[$field]);

  if (strlen($data) > $param) {
    setFlash($field, "Esse campo deve ter no máximo $param caracteres");
    return false;
  }

  return $data;
}

function filter_string_polyfill(string $field): string
{
  $str = preg_replace('/\x00|<[^>]*>?/', '', $field);
  return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
}