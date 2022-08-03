<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>

</head>

<body>
  <!-- <header class="bg-primary">
    <div class="container-xxl">
      <nav class="navbar navbar-expand-lg navbar-light py-2 py-lg-0 flex-column flex-lg-row justify-content-start align-items-center">
        <div id="div-logo-mobile">
          <div class="d-flex justify-content-between align-items-center">
            <a href="./index.php" class="navbar-brand m-0 p-0"><img src="./imgs/logo-branca.png" alt="">
              <h1 class="sr-only sr-only-focusable">Avalifind</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-categorias" aria-controls="navbar-categorias" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
        </div>
        <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbar-categorias">
          <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center ms-lg-2">
            <div class="dropdown py-1 py-lg-0 drop-icon">
              <button class="btn dropdown-toggle p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Categorias
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <span class="dropdown-item fs-3 fw-bold dropdown-titulo">Categorias</span>
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
          include("./telas/frag-mudar-login.php"); //Verifica se usuario está logado
          ?>
        </div>
      </nav>
    </div>
  </header> -->
  <div>
    <ul>
      <li><a href="/">inicio</a></li>
      <li><a href="/login">login</a></li>
      <li><a href="/user/create">cadastro</a></li>
    </ul>
    <h1>
      Bem vindo,
      <?php if (logged()) : ?>
      <?php echo user()->name; ?> | <a href="/logout">Logout</a>
      <?php else : ?>
      visitante
      <?php endif; ?>
    </h1>

  </div>
  <div class="container">
    <?php
    //Recebendo o arquivo que será "imprimido" de acordo com a URI
    require_once VIEWS . $view;
    ?>
  </div>
  <!-- <footer class="bg-primary">
    <div class="container-xxl d-flex flex-column flex-lg-row justify-content-between align-items-center py-3 py-lg-5">
      <div class="footer-drop d-flex align-items-center">
        <a href="./index.php"><img src="./imgs/logo-footer (1).png" class="logo-footer pe-3" alt="logo Avalifind"></a>
        <div class="dropdown">
          <button class="btn dropdown-toggle fs-6 px-3 py-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Categorias
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <span class="dropdown-item dropdown-titulo fs-3 fw-bold">Categorias</span>
            <li><a class="dropdown-item" href="./categorias.php?categoria=Filmes">Filmes</a></li>
            <li><a class="dropdown-item" href="./categorias.php?categoria=Animes">Animes</a></li>
            <li><a class="dropdown-item" href="./categorias.php?categoria=Series">Series</a></li>
            <li><a class="dropdown-item" href="./categorias.php">Ver todas</a></li>
          </ul>
        </div>
      </div>
      <div class="my-4 py-lg-0">
        <h2 class="sr-only">Redes sociais</h2>
        <ul class="sociais list-unstyled d-flex align-items-center m-0">
          <li><a href="#" class="text-white"><i class="fab fa-twitter"></i></a></li>
          <li><a href="#" class="text-white"><i class="fab fa-instagram"></i></a></li>
          <li><a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a></li>
        </ul>
      </div>
    </div>
  </footer> -->
</body>

</html>