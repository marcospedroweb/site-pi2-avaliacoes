<?php

function getExtension(string $name)
{
  //Pega a extensão do arquivo
  return pathinfo($name, PATHINFO_EXTENSION);
}

function isFileToUpload($fieldName)
{
  if (isset($_FILES[$fieldName]) || !isset($_FILES[$fieldName]['name']) || $_FILES[$fieldName]['name'] === '') {
    throw new Exception('O campo não existe');
  }
}

function isImage($extension)
{
  if (!in_array($extension, ['jpeg', 'jpg', 'gif', 'png']))
    throw new Exception('Extensão invalida');
}