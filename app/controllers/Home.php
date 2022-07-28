<?php

namespace app\controllers;

class Home
{
  public function index($params)
  {
    $users = all('usuario');
    return [
      'view' => 'home.php',
      'data' => ['title' => 'Home', 'users' => $users]
    ];
  }
}