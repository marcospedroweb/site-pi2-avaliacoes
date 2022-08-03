<?php

namespace app\controllers;

class Home
{
  public function index($params)
  {
    $users = all('users');
    return [
      'view' => 'home' . VIEW_EXT,
      'data' => ['title' => 'Home', 'users' => $users]
    ];
  }
}