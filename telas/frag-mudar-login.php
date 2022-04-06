<?php
if(isset($_SESSION['id'])){
  //Verificando se usuario está logado
?>
  <!-- Html para usuario logado -->
  <div class='dropdown'>
    <a class='btn btn-secondary dropdown-toggle d-flex justify-content-center align-items-center' href='#' role='button' id='dropdownMenuLink' data-bs-toggle='dropdown' aria-expanded='false' style='padding: .5rem 1rem !important'>
      <span class='d-block fs-6 text-white me-3' id="usuario-nome"><?php echo $_SESSION['nome'] ?></span>
      <?php 
        if($_SESSION['posX'] === 'center' && $_SESSION['posX'] === 'center'){
          $usuarioPosX = $_SESSION['posX'];
          $usuarioPosY = $_SESSION['posY'];
        } else{
          $usuarioPosX = "{$_SESSION['posX']}%";
          $usuarioPosY = "{$_SESSION['posY']}%";
        }
        if($_SESSION['zoom'] === 'cover')
          $zoomAvatar = $_SESSION['zoom'];
        else
          $zoomAvatar = "{$_SESSION['zoom']}%";
      ?>
      <div class='d-block bg-light me-3' style='width:4rem;height:4rem; border-radius: 50%;background: url(./imgs-usuario/<?php echo $_SESSION['avatar'] ?>) <?php echo $usuarioPosX ?> <?php echo $usuarioPosY ?> / <?php echo $zoomAvatar ?> no-repeat #ccc;' id="usuario-avatar"></div>
    </a>
    <ul class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
      <?php 
        if($_SESSION['id'] == 3){
          //Verificando se é admin
      ?>
          <li class="form-check form-switch">
            <a href="./serv-modo-admin.php" class="text-decoration-none d-flex justify-content-center align-items-start" style="color:#383838;padding: 0.25rem 1rem;">
              <input class="form-check-input me-2" type="checkbox" role="switch" id="input-modo-admin" style="cursor:pointer;">
              Modo Admin
            </a>
          </li>
          <li><a class='dropdown-item' href='./manipular-titulos.php'>Manipular titulos</a></li>
          <li><a class='dropdown-item' href='./editar-conta.php'>Editar perfil</a></li>
          <li><a class='dropdown-item text-danger' href='./serv-sair.php'>Sair da sessão</a></li>
      <?php 
        } else {
      ?>
      <li><a class='dropdown-item' href='./editar-conta.php'>Editar perfil</a></li>
      <li><a class='dropdown-item text-danger' href='./serv-sair.php'>Sair da sessão</a></li>
      <?php 
        }
      ?>
    </ul>
<?php 
} else {
?>
  <!-- Html para usuario não logado -->
  <div class='login text-center text-lg-right'>
    <a href='./login.php' class='btn btn-entrar text-decoration-none'>Entrar</a>
    <a href='./criar-conta.php' class='btn btn-primary text-decoration-none btn-criar'>Criar
      conta</a>
  </div>
<?php
}
?>