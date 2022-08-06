<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $this->e($title) ?></title>

</head>

<body>
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
    <?= $this->section('content') ?>
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