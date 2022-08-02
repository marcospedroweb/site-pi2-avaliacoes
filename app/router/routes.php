<?php
return [
  'POST' => [
    '/login' => 'Login@store'
  ],
  'GET' => [
    '/' => 'Home@index',
    '/user' => 'user@index',
    '/user/[0-9]+' => 'user@show',
    '/user/[0-9]+/name/[a-z]+' => "user@create",
    '/register' => 'user@register',
    '/login' => 'Login@index',
    '/logout' => 'Login@destroy',
  ],

];