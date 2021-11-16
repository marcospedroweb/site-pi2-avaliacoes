
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
          <form action="#" method="get" class="py-3 px-0 align-self-start" id="form-procurar">
            <div class="position-relative">
              <i class="fas fa-search fs-3" id="fake-icon-procurar"></i>
              <button class="btn btn-icon-procurar p-0 border-0"><i
                  class="fas fa-search fs-3 icon-procurar"></i></button>
              <input type="text" class="form-control d-block" name="procurar-categoria" id="procurar-categoria"
                aria-describedby="emailHelp">
            </div>
          </form>
          <div class="login text-center text-lg-right">
            <a href="./login.php" class="btn btn-primary text-decoration-none btn-criar">Entrar</a>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <main>
    <div class="container-xxl">
      <div class="alert alert-warning alert-hidden d-none text-center" role="alert">
        <span>Houve um erro a criar a conta, tente novamente.</span>
      </div>
      <div class="container-form row flex-column justify-content-center align-items-center">
        <form action="./serv-criar-conta.php" method="post" class="col-11 col-lg-4 text-center" id="form-conta">
          <h2 class="fs-2 text-white">Crie sua conta</h2>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="nome" id="nome" placeholder="coloque seu nome" maxlength="24">
            <label for="nome">Nome de usuario</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="coloque seu email" required>
            <label for="email">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" name="senha" id="senha" placeholder="coloque seu senha" required>
            <label for="senha">Senha</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="senha-confirmar" placeholder="confirme sua senha" required>
            <label for="senha-confirmar">Confirme a senha</label>
          </div>
          <button class="btn btn-primary btn-criar" id="form-entrar">Criar conta</button>
        </form>
        <div id="ou-linha">
          <span class="ou-texto d-block text-center fs-3 text-uppercase">ou</span>
        </div>
        <div class="trocar-secao text-center">
          <h2 class="fs-2 fw-bold d-block mb-3">Já tem um conta?</h2>
          <a href="./login.php" class="btn btn-primary text-decoration-none">Entrar na conta</a>
        </div>
      </div>
    </div>
  </main>