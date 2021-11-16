<?php
if(isset($_SESSION['id'])){
  // <img src='{$_SESSION['avatar']}' class='img-fluid position-absolute top-50 start-50 translate-middle' style='max-width: 80%;'>
  echo "<div class='dropdown'>
          <a class='btn btn-secondary dropdown-toggle d-flex justify-content-center align-items-center' href='#' role='button' id='dropdownMenuLink' data-bs-toggle='dropdown' aria-expanded='false' style='padding: .5rem 1rem !important'>
              <span class='d-block fs-6 text-white me-3'>{$_SESSION['nome']}</span>
              <div class='d-block bg-light me-3' style='width:4rem;height:4rem; border-radius: 50%;background: url(./imgs-usuario/user.png) center / cover no-repeat #ccc;'></div>
          </a>
          <ul class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
          ";
          if($_SESSION['id'] == 3){
            echo "<li><a class='dropdown-item' href='./cadastrar-titulo.php'>Cadastrar titulo</a></li>";
            echo "<li><a class='dropdown-item text-danger' href='./serv-sair.php'>Sair da sessão</a></li>";
          }else{
            echo "<li><a class='dropdown-item text-danger' href='./serv-sair.php'>Sair da sessão</a></li>";
          }
          echo "</ul>";
} else{
  echo "<div class='login text-center text-lg-right'>
          <a href='./login.php' class='btn btn-entrar text-decoration-none'>Entrar</a>
          <a href='./criar-conta.php' class='btn btn-primary text-decoration-none btn-criar'>Criar
              conta</a>
       </div>";
}