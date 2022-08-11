<?php

namespace app\controllers;

class Home
{
  public function index($params)
  {
    read('users');
    $users = execute();

    return [
      'view' => 'home',
      'data' => ['title' => 'Home', 'users' => $users]
    ];
  }
}