<?php
return [
  '/' => 'Home@index',
  '/user' => 'user@index',
  '/user/[0-9]+' => 'user@show',
  '/user/[0-9]+/name/[a-z]+' => "user@create",
  '/register' => 'user@register',
  '/login' => 'user@login',
];