<?php

namespace app\controllers;

class Home
{
  public function index($params)
  {
    $search = '';
    if (isset($_GET['search']))
      $search = filter_string_polyfill(field: $_GET['search']);

    read(table: 'users', fields: 'name, email');

    if ($search)
      search(search: ['name' => $search, 'email' => $search]);

    $users = execute();
    // dd($users);
    return [
      'view' => 'home',
      'data' => ['title' => 'Home', 'users' => $users]
    ];
  }
}