<?php
return [
  'POST' => [
    '/login' => 'Login@store',
    '/user/create' => 'User@store',
    '/user/image/update' => 'UserImage@store'
  ],
  'GET' => [
    '/' => 'Home@index',
    '/users' => 'Users@index',
    '/user/[0-9]+' => 'User@show',
    '/user/create' => "User@create",
    '/user/edit/profile' => "User@edit",
    '/login' => 'Login@index',
    '/logout' => 'Login@destroy',
  ],

];