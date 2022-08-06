<?php

namespace app\controllers;

class Login
{
  public function index($params)
  {
    return [
      'view' => 'login',
      'data' => ['title' => 'Login']
    ];
  }

  public function store()
  {
    //Retorna o valor dos campos do login
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_string_polyfill($_POST['password']);

    if (empty($email) || empty($password))
      //Se o email ou senha estiver vazio, retorna um erro
      return setMessageErrorLoginAndRedirect('message', 'Email e/ou senha inválido(s)', '/login');

    $user = findBy('users', 'email', $email); // Retorna ou não o usuario no banco com tal email
    if (!$user)
      //Se não encontrar, volta para pagina de login
      return setMessageErrorLoginAndRedirect('message', 'Email e/ou senha inválido(s)', '/login');

    if (!password_verify($password, $user[0]->password))
      //Verificando se a senha passada é compativel com a cadastrada
      return setMessageErrorLoginAndRedirect('message', 'Email e/ou senha inválido(s)', '/login');

    //Se senha e email estão compativeis, adiciona a conta a sessão e retorna o usuario para pagina principal
    $_SESSION[LOGGED] = $user;
    return redirect('/');
  }

  public function destroy()
  {
    unset($_SESSION[LOGGED]);
    redirect('/');
  }
}