<?php

namespace app\controllers;

class User
{
  public function show($params)
  {
    //Mostra os dados usuario de acordo com o id do usuario
    if (!isset($params['user']))
      return redirect('/');

    $user = findBy('users', 'id', $params['user']);

    echo "<pre>";
    var_dump($user);
    die();
  }

  public function create()
  {
    return [
      'view' => 'create' . VIEW_EXT,
      'data' => ['title' => 'Create',]
    ];
  }

  public function store()
  {
    //Validando os dados dos inputs
    $validate = validate([
      'name' => 'required|maxlen:20',
      'email' => 'required|email|unique:users',
      'password' => 'required|maxlen:18',
    ]);

    // Se não passar na validação, retorna o usuario para a pagina de cadastro
    if (!$validate)
      return redirect('/user/create');
  }
}