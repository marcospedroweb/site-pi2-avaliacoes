<main class="my-6 d-flex justify-content-center align-items-center">
  <div class="container-xxl">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <?php 
          $categoria = $_GET['categoria'] ?? '';
          if($categoria !== 'Filmes' && $categoria !== 'Animes' && $categoria !== 'Series'){
            echo "<li class='breadcrumb-item' aria-current='page'>
                    <a href='./categorias.php' class='link-primary'>Categorias</a>
                  </li>";
          }else{
            echo "<li class='breadcrumb-item'>
                    <a href='./categorias.php' class='link-secondary'>Categorias</a>
                  </li>";
            echo "<li class='breadcrumb-item' aria-current='page'>
                    <a href='./categorias.php?categoria={$categoria}' class='link-primary'>{$categoria}</a>
                  </li>";
          }
        ?>
      </ol>
    </nav>
    <div class="row justify-content-center align-items-start">
      <div class="col-2 sticky-top" id="offcanvas-mobile" style="z-index: 1000;">
        <aside class="d-flex justify-content-center align-items-center">
          <button class="btn btn-primary d-block px-3 py-2" id="offcanvas-hamburguer" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="fas fa-bars"></i>
          </button>
          <div class="offcanvas offcanvas-start " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
              <h2 class="offcanvas-title fs-3 fw-bold" id="offcanvasExampleLabel">Categorias</h2>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <nav>
                <ul class="list-unstyled ul-categorias">
                  <li>
                    <a href="?categoria=Filmes" class="nav-categoria text-decoration-none categorias-link fs-4">Filmes</a>
                  </li>
                  <li>
                    <a href="?categoria=Animes" class="nav-categoria text-decoration-none categorias-link fs-4">Animes</a>
                  </li>
                  <li>
                    <a href="?categoria=Series" class="nav-categoria text-decoration-none categorias-link fs-4">Series</a>
                  </li>
                  <li>
                    <a href="./categorias.php" class="nav-categoria text-decoration-none categorias-link fs-4">Ver todas</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </aside>
      </div>
      <div class="col-2 sticky-top" id="offcanvas-desktop">
        <aside>
          <h2 class="fs-3 fw-bold">Categorias</h2>
          <nav class="py-3">
            <ul class="list-unstyled ul-categorias">
              <li>
                <a href="?categoria=Filmes" class="nav-categoria text-decoration-none categorias-link fs-4 d-flex align-items-center">Filmes</a>
              </li>
              <li>
                <a href="?categoria=Animes" class="nav-categoria text-decoration-none categorias-link fs-4 d-flex align-items-center">Animes</a>
              </li>
              <li>
                <a href="?categoria=Series" class="nav-categoria text-decoration-none categorias-link fs-4 d-flex align-items-center">Series</a>
              </li>
              <li>
                <a href="./categorias.php" class="nav-categoria text-decoration-none categorias-link fs-4">Ver todas</a>
              </li>
            </ul>
          </nav>
        </aside>
      </div>
      <div class="col-10">
        <div class="row">
          <form action="./serv-buscar-categoria.php" method="POST" class="col-12 form-categoria sticky-top">
            <!-- Buscar categoria input -->
            <div class="inside-form-categoria">
              <input type="text" class="form-control input-buscar-categoria" list="datalist-categorias" id="buscarCategoria" name="buscarCategoria" placeholder="Toy story" autocomplete="off">
              <div id="limitar-datalist">
                <datalist id="datalist-categorias">
                  <?php 
                      $sql = "SELECT t.id, t.nome, sinopse, capa, avaliacaoGeral, c.tipo 
                      FROM titulo as t INNER JOIN categoria as c
                      ON t.categoria = c.id";
                      
                      foreach($bd->query($sql) as $registro){
                          echo "<option value='{$registro['nome']}' label='Em {$registro['tipo']}'>";
                      }
                  ?>
                </datalist>
              </div>
              <button class="btn btn-procurar-categoria p-0 border-0"><i class="fas fa-search fs-3 icon-procurar-categoria"></i></button>
            </div>
          </form>
          <section class="col-12">
            <div class="row destaques justify-content-center">
              <?php 
                require_once('./banco/conectarBanco.php');
                $categoria = $_GET['categoria'] ?? '';
                $titulo = $_GET['nome'] ?? '';

                if($categoria !== 'Filmes' && $categoria !== 'Animes' && $categoria !== 'Series'){
                  $categoria = '';
                  if($titulo){
                    $sql = "SELECT t.id, nome, capa, avaliacaoGeral, c.tipo 
                            FROM titulo as t INNER JOIN categoria as c
                            ON t.categoria = c.id
                            WHERE nome like '%{$titulo}%'";
                  }else
                    $sql = "SELECT t.id, nome, capa, avaliacaoGeral, c.tipo 
                            FROM titulo as t INNER JOIN categoria as c
                            ON t.categoria = c.id";
                } else{
                  $sql = "SELECT t.id, nome, capa, avaliacaoGeral, c.tipo 
                          FROM titulo as t INNER JOIN categoria as c
                          ON t.categoria = c.id
                          WHERE c.tipo = '{$categoria}'";
                }
                foreach($bd->query($sql) as $registro){
                  $categoria = $registro['tipo'];
                  echo "<div class='destaque-card col-12 col-lg my-2 text-center'>
                          <a href='./categoria-escolhida.php?nome={$registro['nome']}&categoria={$categoria}' class='d-block destaque-container' style='background: url(./imgs-usuario/{$registro['capa']}) center top / cover no-repeat #ccc;'>
                              <span class='card-nome'>{$registro['nome']}</span>
                              <i class='fas fa-search-plus'></i>
                          </a>
                          <i class='fas fa-search-plus'></i>
                          <div class='card-estrelas py-2 d-flex justify-content-center align-items-start'>
                              <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                              <span><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                              <span class='ps-2'><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                              <span class='pe-2'><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                              <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                              <span class='pe-2'><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                              <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                              <span class='pe-2'><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                              <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                              <span><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                              <span class='card-avaliacao ms-2'>{$registro['avaliacaoGeral']}</span>
                          </div>
                        </div>";
                }
              ?>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</main>