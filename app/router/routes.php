<?php
return [
  '/' => 'Home@index',
  '/user/[0-9]+' => 'user@Index',
  '/user/[0-9]+/name/[a-z]+' => "user@Show",
  '/register' => 'user@Register',
  '/login' => 'user@Login',
];
