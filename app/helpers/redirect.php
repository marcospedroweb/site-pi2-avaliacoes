<?php

function redirect($to)
{
  return header('Location: ' . $to);
}

function setMessageErrorLoginAndRedirect($index, $message, $redirectTo = '/')
{
  setFlash($index, $message);
  return redirect($redirectTo);
}