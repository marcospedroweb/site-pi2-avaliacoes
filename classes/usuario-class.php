<?php

class Usuario {
  //cria objeto Disciplina
  var $bd;//variavel para receber o banco de dados

  function __construct($bd){
    // Essa função será executada quando instanciar o objeto
    $this->bd = $bd;//recebe o banco de dados php my admin
  }

  function criarContar(){
    // Criar conta para usuario
  }

  function login(){
    // Entrar em um conta existente do usuario
  }

  function sairDaSessao(){
    // Sair da conta atualmente conectada
  }

  function editarConta(){
    // Edita dados da conta do usuario
  }

  function avaliar(){
    // Registrar o comentario e/ou nota para o titulo
  }

  function pesquisar(){
    // Buscar titulo(s) que o usuario queira
  }

}