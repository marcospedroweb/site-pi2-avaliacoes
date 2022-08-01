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
}