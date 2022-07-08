<main class="my-5 d-flex justify-content-center align-items-center">
  <div class="container-xxl">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <?php 
          include('./telas/frag-breadcrumb-item.php');
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
        <div class="row justify-content-center align-items-center">
          <div class="col-12 row justify-content-center align-items-center sticky-top mb-5" id="campo-de-busca">
              <form action="./categorias.php" method="GET" class="col-lg-9 form-categoria">
                <!-- Buscar categoria input -->
                <div class="inside-form-categoria">
                  <input type="text" class="form-control input-buscar-categoria" list="datalist-categorias" id="buscarCategoria" name="buscarCategoria" placeholder="Toy story" autocomplete="off">
                  <div id="limitar-datalist">
                    <datalist id="datalist-categorias">
                      <?php 
                        //Options da datalist
                          include('./telas/frag-datalist.php');
                      ?>
                    </datalist>
                  </div>
                  <button class="btn btn-procurar-categoria p-0 border-0" id="btn-form-categorias"><i class="fas fa-search fs-3 icon-procurar-categoria"></i></button>
                </div>
              </form>
              <form action="" method="GET" id="filtrar" class="col-lg-3 px-1">
                <input type="hidden" name="categoria" value="<?php echo $categoria ?>">
                <div class="text-end">
                  <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle" href="#" role="button" id="dropdown-filtrar" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="fw-normal me-2">Ordenado por:</span><?php echo $ordenarPor ?>
                    </button type="button">
                    <ul class="dropdown-menu" aria-labelledby="dropdown-filtrar">
                      <li>
                        <?php 
                        if($ordenarPor === 'Relevância'){
                        ?>
                        <button type="submit" class="dropdown-item disabled" name="ordenar" value="relevancia">Relevância</button>
                        <?php 
                        }else{
                        ?>
                        <button type="submit" class="dropdown-item" name="ordenar" value="relevancia">Relevância</button>
                        <?php 
                        }
                        ?>
                      </li>
                      <li>
                        <?php 
                        if($ordenarPor === 'Nome (A-Z)'){
                        ?>
                        <button type="submit" class="dropdown-item disabled" name="ordenar" value="nome">Nome (A-Z)</button>
                        <?php 
                        }else{
                        ?>
                        <button type="submit" class="dropdown-item" name="ordenar" value="nome">Nome (A-Z)</button>
                        <?php 
                        }
                        ?>
                      </li>
                      <li>
                        <?php 
                        if($ordenarPor === 'Sem avaliação'){
                        ?>
                        <button type="submit" class="dropdown-item disabled" name="ordenar" value="sem-avaliacao">Sem avaliação</button>
                        <?php 
                        }else{
                        ?>
                        <button type="submit" class="dropdown-item" name="ordenar" value="sem-avaliacao">Sem avaliação</button>
                        <?php 
                        }
                        ?>
                      </li>
                    </ul>
                  </div>
                </div>
              </form>
          </div>
          <section class="col-12">
            <?php
              include('./telas/frag-alerts.php');
            ?>
            <div class="row destaques justify-content-center">
              <?php 
              if($titulos){
                foreach($titulos as $id => $registroTitulo){
              ?>
                  <div class='destaque-card col-12 col-lg my-2 text-center position-relative'>
                    <a href='./categoria-escolhida.php?nome=<?php echo $registroTitulo['nome'] ?>&categoria=<?php echo $registroTitulo['tipo'] ?>' class='d-block destaque-container' style='background: url(./imgs-usuario/<?php echo $registroTitulo['capa'] ?>) <?php echo $registroTitulo['posX'] ?> <?php echo $registroTitulo['posY'] ?> / cover no-repeat #ccc;'>
                        <?php
                        if($usuario === 3 && $modoAdmin === true){
                        ?>
                          <form action="./manipular-titulos.php" method="POST">
                            <button type="submit" class="opcao-admin-editar" name="editar-titulo" value="<?php echo $registroTitulo['id'] ?>"><i class="fas fa-pen"></i></button>
                            <button type="button" class="opcao-admin-apagar" data-bs-toggle="modal" data-bs-target="#modal-apagar-titulo" value="[<?php echo $registroTitulo['id'] ?>, <?php echo $registroTitulo['nome'] ?>]"><i class="fas fa-times"></i></button>
                          </form>
                        <?php
                        }
                        ?>
                        <span class='card-nome'><?php echo $registroTitulo['nome'] ?></span>
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
                        <span class='card-avaliacao ms-2'><?php echo $registroTitulo['avaliacaoGeral'] ?></span>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>
            <!-- MODAL -->
            <div class="modal fade" id="modal-apagar-titulo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-start">
                  <div class="modal-header border-0">
                    <h4 class="modal-title" id="staticBackdropLabel">Apagar <span class="fw-bold span-nome-titulo"><?php echo $registroTitulo['nome'] ?></span>?</h4>
                  </div>
                  <div class="modal-body">
                    <span class="fs-4 fw-bold">Essa ação é irreversível.</span>
                    <ul class="list-unstyled m-0 p-0">
                      <li class="mt-2">Será apagado:
                        <ul>
                          <li>Todos os dados relacionados a <span class="fw-bold span-nome-titulo"><?php echo $registroTitulo['nome'] ?></li>
                          <li>Todos os comentarios de <span class="fw-bold span-nome-titulo"><?php echo $registroTitulo['nome'] ?></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <form action="./categorias.php" class="p-0" method="POST">
                      <button type="button" class="btn fs-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn fs-4 text-danger fw-bold ms-3" value="0" name="apagar-titulo" value="<?php echo $registroTitulo['id'] ?>" id="btn-apagar-titulo">Apagar</button>
                      <input type="text" class="d-none" value="<?php echo $usuario ?>" name="input-id-usuario">
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <nav aria-label="Page navigation example" class="mt-5 mb-3 d-flex justify-content-center align-items-center" id="paginacao-categorias">
              <ul class="pagination">
                <?php 
                if($pagina > 1){
                ?>
                  <li class="page-item">
                    <a class="page-link" href="<?php echo $urlAtual ?>pagina=<?php echo $paginaAnterior?>" aria-label="Previous">
                      <span aria-hidden="true" class="d-flex justify-content-center align-items-center"><i class="fas fa-long-arrow-alt-left me-2"></i>Anterior</span>
                    </a>
                  </li>
                <?php
                } 
                for($i = 1; $i <= $qtdDePaginas;$i++){
                  if(intval($pagina) === $i){
                ?>
                    <li class="page-item active"><a class="page-link" href="<?php echo $urlAtual ?>pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php
                  }else{
                ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $urlAtual ?>pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php
                  }
                }
                if($pagina < $qtdDePaginas){
                ?>
                  <li class="page-item">
                    <a class="page-link" href="<?php echo $urlAtual ?>pagina=<?php echo $paginaProximo?>" aria-label="Next">
                      <span aria-hidden="true" class="d-flex justify-content-center align-items-center">Próximo<i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                    </a>
                  </li>
                <?php
                }
                ?>
              </ul>
            </nav>
          </section>
        </div>
      </div>
    </div>
  </div>
</main>