<?php
return [
  '/' => 'home@index',
  '/user/[0-9]+' => 'user@index',
  '/user/[0-9]+/name/[a-z]+' => "user@show",
  '/register' => 'user@register',
  '/login' => 'user@login',
];
