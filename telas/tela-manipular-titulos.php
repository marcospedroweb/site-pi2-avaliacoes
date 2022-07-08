<main>
  <div class="container-xxl">
    <?php
      include('./telas/frag-alerts.php');
    ?>
    <?php 
    if($_SESSION['id'] === 3 && $modoAdmin === true){
    ?>
      <div class="container-xxl my-5">
        <h2 class="fs-2 fw-bold text-center">O que gostaria de fazer?</h2>
        <div class="buttons-section pt-3 mb-3 d-flex justify-content-center">
          <a class="btn btn-secondary active" href="./manipular-titulos.php">Criar novo titulo</a>
          <a class="btn btn-secondary" href="./categorias.php">Editar titulo existente</a>
          <a class="btn btn-secondary" href="./categorias.php">Apagar titulo existente</a>
        </div>
      </div>
    <?php 
    }
    ?>
    <section class="bg-light my-5 py-4">
      <h3 class="fs-2 text-center mb-5" id="manipular-titulos-text">Crie o titulo</h3>
      <?php 
      if($criarTitulo)
        include('./telas/frag-criar-titulo.php');
      else if ($editarTitulo || $apagarTitulo)
        include('./telas/frag-editar-apagar-titulo.php');
      ?>
    </section>
    <div class="container-xxl">
      <h2 class="fs-2 fw-bold text-center mb-5">Preview</h2>
      <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb m-0 py-4 fs-5">
          <li class='breadcrumb-item'>
            <a href='./categorias.php' class='link-secondary'>Categorias</a>
          </li>
          <li class='breadcrumb-item'>
            <a class='link-secondary' id="categoria-preview">Filmes</a>
          </li>
          <li class='breadcrumb-item' aria-current='page'>
            <a class='link-primary' id="breadcrumb-nome-preview">Toy Story</a>
          </li>
        </ol>
      </nav>
    </div>
    <article class="bg-light mb-6">
      <div class="container-xxl">
        <div class="row">
          <div class='col-3 img-titulo position-relative'>
            <div class='d-block bg-light me-3' style="max-width:304px;min-heighth:464px">
              <div class="d-block" style="width:304px;height:464px;background: url(./imgs-usuario/<?php echo $imgPreviewPadrao ?>) center center / cover no-repeat #ccc;" id="img-preview"></div>
              <div id="preview-box-posX" class="position-absolute">
                <input type="range" class="form-range posX" min="0" max="100" step="1" name="preview-posX" id="preview-posX">
              </div>
              <div id="preview-box-posY" class="position-absolute">
                <input type="range" class="form-range posY" min="0" max="100" step="1" name="preview-posY" id="preview-posY">
              </div>
            </div>
          </div>
          <div class='col-9 informacoes-titulo text-start'>
            <h3 class='fs-2' style='font-weight: 600;' id="titulo-nome-preview">Toy Story</h3>
            <div id="informacoes-titulo" class="d-flex justify-content-center align-items-center" style="width: fit-content;">
              <p id="titulo-categoria-preview">Filme</p>
              <p id='temporadas-titulo' class="d-none">4</p>
              <p id='episodios-titulo' class="d-none">50</p>
              <p id='duracao-titulo' class="d-none"></p>
            </div>
            <p class='mt-4 mb-6' id="titulo-sinopse-preview">O aniversário do garoto Andy está chegando e seus brinquedos ficam nervosos, temendo que ele ganhe novos brinquedos que possam substituí-los. Liderados pelo caubói Woody, o brinquedo predileto de Andy, eles recebem Buzz Lightyear, o boneco de um patrulheiro espacial, que logo passa a receber mais atenção do garoto. Com ciúmes, Woody tenta ensiná-lo uma lição, mas Buzz cai pela janela. É o início da aventura do caubói, que precisa resgatar Buzz para limpar sua barra com os outros brinquedos.</p>
            <div class='d-flex justify-content-between align-items-center mt-6'>
              <div class='card-estrelas m-0 p-2 d-flex justify-content-center align-items-center' style='border-radius: 8px;max-width: unset;'>
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
                <span class='card-avaliacao ps-3 titulo-avaliacao-preview' id='titulo-escolhido-avaliacao'>5</span>
              </div>
              <div class='d-block'>
                <a href='#' class='btn btn-primary' id='avaliar-categoria'>Avaliar</a>
              </div>
            </div>
          </div>
          <div class='destaque-card col-12 col-lg my-2 text-center'>
            <a href='#' class='d-block destaque-container m-0 mt-5' style='background: url(./imgs-usuario/<?php echo $imgPreviewPadrao ?>) center top / cover no-repeat #ccc;' id="preview-img-card">
                <span class='card-nome'>Toy Story</span>
                <i class='fas fa-search-plus'></i>
            </a>
            <i class='fas fa-search-plus m-0'></i>
            <div class='card-estrelas py-2 d-flex justify-content-center align-items-start m-0'>
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
                <span class='card-avaliacao ms-2'>0</span>
            </div>
          </div>
        </div>
      </div>
    </article>
  </div>
</main>