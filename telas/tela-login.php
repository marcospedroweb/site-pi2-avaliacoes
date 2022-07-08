<body>
  <header class="bg-primary">
    <div class="container-xxl">
      <nav class="navbar navbar-expand-lg navbar-light py-2 py-lg-0 flex-column flex-lg-row justify-content-start">
        <div class="d-flex justify-content-between align-items-center">
          <a href="./index.php" class="navbar-brand m-0 p-0"><img src="./imgs/logo-branca.png" alt="">
            <h1 class="sr-only sr-only-focusable">Avalifind</h1>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-categorias"
            aria-controls="navbar-categorias" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbar-categorias">
          <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center ms-lg-2">
            <div class="dropdown ms-lg-3 py-1 py-lg-0 drop-icon">
              <button class="btn dropdown-toggle p-0 border-0" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                Categorias
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <span class="dropdown-item fs-3 fw-bold" id="dropdown-titulo">Categorias</span>
                <li><a class="dropdown-item" href="./categorias.php?categoria=Filmes">Filmes</a></li>
                <li><a class="dropdown-item" href="./categorias.php?categoria=Animes">Animes</a></li>
                <li><a class="dropdown-item" href="./categorias.php?categoria=Series">Series</a></li>
                <li><a class="dropdown-item" href="./categorias.php">Ver todas</a></li>
              </ul>
            </div>
          </div>
          <form action="./categorias.php" method="GET" class="py-3 px-0" id="form-procurar">
            <div class="position-relative">
                <i class="fas fa-search fs-3" id="fake-icon-procurar"></i>
                <button class="btn btn-icon-procurar p-0 border-0"><i class="fas fa-search fs-3 icon-procurar"></i></button>
                <input type="text" class="form-control d-block" list="opcoes-datalist" name="procurar-categoria" id="procurar-categoria" aria-describedby="emailHelp" autocomplete="off">
                <?php 
                    include('./telas/frag-datalist.php');
                ?>
            </div>
          </form>
          <?php 
          if(!(empty($nomeTituloEscolhido) && empty($categoriaEscolhido))){
          ?>
            <div class="login text-center text-lg-right">
              <a href="./criar-conta.php?nome=<?php echo $nomeTituloEscolhido ?>&categoria=<?php echo $categoriaEscolhido ?>" class="btn btn-primary text-decoration-none btn-criar">Criar
                conta</a>
            </div>
          <?php 
          }else{
          ?>
            <div class="login text-center text-lg-right">
              <a href="./criar-conta.php" class="btn btn-primary text-decoration-none btn-criar">Criar
                conta</a>
            </div>
          <?php 
          }
          ?>
        </div>
      </nav>
    </div>
  </header>
  <main>
    <div class="container-xxl">
      <div class="container-form row flex-column justify-content-center align-items-center">
        <?php
          include('./telas/frag-alerts.php');
        ?>
        <form action="./login.php" method="POST" class="col-11 col-lg-4 text-center" id="form-conta">
          <h2 class="fs-2 text-white">Entre na sua conta</h2>
          <input type="hidden" class="form-control d-none" name="titulo-escolhido" id="titulo-escolhido" value="<?php echo $nomeTituloEscolhido?>">
          <input type="hidden" class="form-control d-none" name="categoria-escolhida" id="categoria-escolhida" value="<?php echo $categoriaEscolhido?>">
          <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="coloque seu email" required>
            <label for="email">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" name="senha" id="senha" placeholder="coloque seu senha" required>
            <label for="senha">Senha</label>
          </div>
          <button type="submit" class="btn btn-primary btn-criar" id="form-entrar">Entrar</button>
        </form>
        <div id="ou-linha">
          <span class="ou-texto d-block text-center fs-3 text-uppercase">ou</span>
        </div>
        <div class="trocar-secao text-center">
          <h2 class="fs-2 fw-bold d-block mb-3">Não tem uma conta?</h2>
          <?php 
          if(!(empty($nomeTituloEscolhido) && empty($categoriaEscolhido))){
          ?>
            <div class="login text-center text-lg-right">
              <a href="./criar-conta.php?nome=<?php echo $nomeTituloEscolhido ?>&categoria=<?php echo $categoriaEscolhido ?>" class="btn btn-primary text-decoration-none btn-criar">Criar
                conta</a>
            </div>
          <?php 
          }else{
          ?>
            <div class="login text-center text-lg-right">
              <a href="./criar-conta.php" class="btn btn-primary text-decoration-none btn-criar">Criar
                conta</a>
            </div>
          <?php 
          }
          ?>
        </div>
      </div>
    </div>
  </main>