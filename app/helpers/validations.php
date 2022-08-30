<?php
// Aqui é onde possui todas as funções que realizam alguma tipo de validação de dados

function required(string $field)
{
  //Verificando se o input do POST está vazio
  if ($_POST[$field] === '') {
    //Se estiver, retona um erro
    setFlash($field, 'O campo é obrigatorio');
    return false;
  }

  return filter_string_polyfill($_POST[$field]); //Retorna aquele dado filtrado
}

function email(string $field)
{
  //Verificando se o email é valido
  $emailIsValid = filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL);
  if (!$emailIsValid) {
    //Se não for, retona um erro
    setFlash($field, "O campo tem que ser um email válido");
    return false;
  }

  return filter_string_polyfill($emailIsValid); //Retorna aquele dado filtrado
}

function unique(string $field, string $param)
{
  //Verifica se aquele dado já está cadastrado na tabela
  $data = filter_string_polyfill($_POST[$field]);
  $user = findBy($param, $field, $data);

  if ($user) {
    //Se não haver, envia a mensagem
    setFlash($field, "O valor preenchido já está cadastrado.");
    return false;
  }

  return $data; // retorna um dado, igual o positivo
}

function maxlen(string $field, string $param)
{
  //Verifica se aquele dado passou da quantidade de caracteres maxima
  $data = filter_string_polyfill($_POST[$field]);

  if (strlen($data) > $param) {
    //Se passar do valor do parametro, retorna um erro
    setFlash($field, "Este campo deve ter no máximo $param caracteres");
    return false;
  }

  return $data; // retorna um dado, igual o positivo
}

function minlen(string $field, string $param)
{
  //Verifica se a quantidade minima de caracteres foi atingida
  $data = filter_string_polyfill($_POST[$field]);

  if (strlen($data) < $param) {
    //Se for abaixo da quantidade minima, retorna um erro
    setFlash($field, "Este campo deve ter no mínimo $param caracteres");
    return false;
  }

  return $data; // retorna um dado, igual o positivo
}