<?php

function validate(array $validations, bool $perisistInputs = false, bool $checkCsrf = false)
{
  //Responsável por validar os dados do array
  $result = [];
  $param = '';

  //Verifica se aquele campo há UMA validação ou VARIAS 
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
  // Com o 3° parametro "true", ele verifica APENAS resultados com valor "false"
  // Resultados que são considerados FALSE, Ex: 0, null, '', com o true, permite esses passarem pela verificiação
  if (in_array(false, $result, true))
    return false;

  //Se não houve erros apaga da sessão os dados armazenados
  destroyOld();

  //Se não houve erros retorna os campos validados
  return $result;
}

function singleValidation(string $validate, string $field, string $param)
{
  //Verifica se há "|" na validação, se NÃO houver, há apenas 1 validate

  //Verifica se há o separador ':', retornando a 1° variavel a função que será executada
  //retornando a 2° variavel os parametros requisitados
  if (str_contains($validate, ':'))
    [$validate, $param] = explode(':', $validate);

  return $validate($field, $param); // Chamando a função nomeada e seus parametros
}

function multipleValidations(string $validate, string $field, string $param)
{
  //Verifica se há "|" na validação, se houver, há mais de 1 validate
  $result = [];
  $explodePipeValidate = explode('|', $validate); //Separa os validates

  foreach ($explodePipeValidate as $validate) {
    //Em cada validade, verifica se há o separador ':'
    //Verificando se há parametro
    if (str_contains($validate, ':'))
      //retornando a 1° variavel a função que será executada
      //retornando a 2° variavel os parametros requisitados
      [$validate, $param] = explode(':', $validate);

    $result[$field] = $validate($field, $param); //Executa a função de acordo com o nome

    // Verificando se aquele campo JÁ foi validade, se já foi validado, PARA o foreach e já retorna algum erro
    if ($result[$field] === false || $result[$field] === null)
      break;
  }

  //Retorna o campo com seu resultado
  return $result[$field];
}