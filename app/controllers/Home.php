<?php

namespace app\controllers;

class Home
{
  public function index($params)
  {
    read('users');
    where('id', '>', 5);

    $users = execute();

    return [
      'view' => 'home',
      'data' => ['title' => 'Home', 'users' => $users]
    ];
  }
}