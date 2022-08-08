<?php

function validate(array $validations, bool $perisistInputs = false, bool $checkCsrf = false)
{
  $result = [];
  $param = '';
  //Responsável por validar os dados do array
  foreach ($validations as $field => $validate)
    $result[$field] = (!str_contains($validate, '|'))
      ? singleValidation($validate, $field, $param)
      : multipleValidations($validate, $field, $param);


  //Verifica o csrf
  if ($checkCsrf)
    try {
      checkCsrf();
    } catch (Exception $e) {
      dd($e->getMessage);
    }

  //Se possuir dados enviados no formulario, armazena-os temporariamente
  if ($perisistInputs)
    setOld();

  //Procura no array se há algum resultado que deu false, retornando "erro"
  if (in_array(false, $result))
    return false;

  //Se não houve erros apaga da sessão os dados armazenados
  destroyOld();

  return $result;
}

function singleValidation(string $validate, string $field, string $param)
{
  //Verifica se há "|" na validação, se NÃO houver, há apenas 1 validate
  if (str_contains($validate, ':'))
    [$validate, $param] = explode(':', $validate);

  return $validate($field, $param); // Chamando a função required e armazena o resultado
}

function multipleValidations(string $validate, string $field, string $param)
{
  //Verifica se há "|" na validação, se houver, há mais de 1 validate
  $result = [];
  $explodePipeValidate = explode('|', $validate);
  foreach ($explodePipeValidate as $validate) {
    //Verificando se há parametro
    if (str_contains($validate, ':'))
      //Se houver, separa o valor e paramtro
      [$validate, $param] = explode(':', $validate);

    $result[$field] = $validate($field, $param); //Executa a função de acordo com o nome

    // Verificando se aquele campo JÁ foi validade, se já foi validado, para o foreach e já retorna algum erro
    if (isset($result[$field]) && $result[$field] === false)
      break;
  }

  return $result[$field];
}