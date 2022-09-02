<?php

namespace app\controllers;

class Home
{
  public function index($params)
  {
    read(table: 'users', fields: 'name, email');

    $search = '';
    if (isset($_GET['search'])) {
      $search = filter_string_polyfill(field: $_GET['search']);
      search(search: ['name' => $search]);
    }

    paginate(5);

    $users = execute();
    // dd($users);
    return [
      'view' => 'home',
      'data' => ['title' => 'Home', 'users' => $users, 'search' => $search, 'links' => render()]
    ];
  }
}