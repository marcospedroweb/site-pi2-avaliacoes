<?php

function redirect(string $to)
{
  return header('Location: ' . $to);
}

function setMessageErrorLoginAndRedirect(string $index, string $message, string $redirectTo = '/')
{
  setFlash($index, $message);
  return redirect($redirectTo);
}