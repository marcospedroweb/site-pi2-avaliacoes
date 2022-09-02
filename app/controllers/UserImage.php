<?php

namespace app\controllers;

class UserImage
{
  public function store()
  {
    //Armazena a imagem do usuario
    $name = $_FILES['file']['name'];
    $extension = getExtension($name);
    isImage($extension);
  }
}