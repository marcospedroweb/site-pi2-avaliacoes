<?php

namespace app\controllers;

class Home
{
  public function index($params)
  {
    $users = all('users');
    $updated = update('users', ['name' => 'Fulano'], ['id' => 12]);
    return [
      'view' => 'home',
      'data' => ['title' => 'Home', 'users' => $users]
    ];
  }
}