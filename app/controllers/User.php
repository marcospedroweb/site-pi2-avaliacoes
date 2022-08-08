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
  }

  public function create()
  {
    return [
      'view' => 'create',
      'data' => ['title' => 'Create',]
    ];
  }

  public function store()
  {
    //Validando os dados dos inputs
    $validate = validate([
      'name' => 'required|minlen:2|maxlen:20',
      'email' => 'required|email|unique:users',
      'password' => 'required|minlen:8|maxlen:18',
    ], perisistInputs: true, checkCsrf: true);

    // Se não passar na validação, retorna o usuario para a pagina de cadastro
    if (!$validate)
      return redirect('/user/create');

    $validate['password'] = password_hash($validate['password'], PASSWORD_DEFAULT);

    $created = create('users', $validate);

    if (!$created) {
      setFlash('message', 'Houve um erro ao cadastrar, tente novamente em alguns segundos');
      return redirect('/user/create');
    }

    return redirect('/');
  }
}