<?php

class Categoria {
  //cria objeto Disciplina
  var $bd;//variavel para receber o banco de dados

  function __construct($bd){
    // Essa função será executada quando instanciar o objeto
    $this->bd = $bd;//recebe o banco de dados php my admin
  }

  function criarTitulo(){
    // Registrar um novo titulo no banco
  }

  function editarTitulo(){
    // Editar algum dado de um titulo existente
  }

  function apagarTitulo(){
    // Apagar um titulo existente no banco
  }

  function mostrarCategorias(){
    // Retornar os titulos existentes
  }
}