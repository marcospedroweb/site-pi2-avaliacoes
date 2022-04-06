<main>
  <div class="container-xxl">
    <?php
      include('./telas/frag-alerts.php');
    ?>
    <div class="row justify-content-center align-items-center">
      <form action="" method="POST" class="col-lg-6 row text-white" id="background-editar-perfil" enctype="multipart/form-data">
        <h2 class="col-12 fs-2 text-center text-white mb-4">Editando Perfil</h2>
        <div class="col-6 text-center d-flex justify-content-center align-items-center position-relative" id="div-novo-avatar">
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
          <div id="nova-img-div" class="align-self-start" style="background: url(./imgs-usuario/<?php echo $regitroUsuario['avatar']?>) <?php echo $usuarioPosX ?> <?php echo $usuarioPosY ?> / <?php echo $zoomAvatar ?> no-repeat #eee;">
          </div>
          <i class="fas fa-search-plus position-absolute btn-zoom" id="mais-zoom"></i>
          <i class="fas fa-search-minus position-absolute btn-zoom" id="menos-zoom"></i>
          <input type="hidden" name="novo-zoom" value="<?php echo $regitroUsuario['zoom']?>" id="input-zoom">
          <input type="range" class="form-range" name="avatar-posX" value="<?php echo $regitroUsuario['posX']?>" id="avatar-posX">
          <input type="range" class="form-range" name="avatar-posY" value="<?php echo $regitroUsuario['posY']?>" id="avatar-posY">
          <input type="file" class="d-none" name="novo-avatar" id="novo-avatar" value="<?php echo $regitroUsuario['avatar']?>" accept="image/png, image/gif, image/jpeg, image/jpg">
        </div>
        <div class="col-6">
          <div class="mb-3 text-start">
            <label for="novo-nome" class="form-label">Nome de usuario</label>
            <input type="text" class="form-control" name="novo-nome" id="novo-nome" aria-describedby="emailHelp" value="<?php echo $regitroUsuario['nome']?>" maxlength="24" required>
          </div>
          <div class="mb-3 text-start">
            <label for="novo-email" class="form-label">Email</label>
            <input type="text" class="form-control" name="novo-email" id="novo-email" aria-describedby="emailHelp" value="<?php echo $regitroUsuario['email']?>" required>
          </div>
          <div class="mb-3 text-start">
            <label for="confirmando-senha" class="form-label">Digite a senha atual</label>
            <input type="password" class="form-control" name="confirmando-senha" id="confirmando-senha" required>
          </div>
        </div>
        <div class="col-12 text-center mt-5 mb-2">
          <button type="submit" class="btn btn-primary" name="atualizar-perfil" value="<?php echo $regitroUsuario['id']?>" id="btn-atualizar-perfil">Atualizar Perfil</button>
        </div>
      </form>
    </div>
  </div>

</main>