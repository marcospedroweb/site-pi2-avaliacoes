<main>
  <div class="container-xxl">
    <section class="bg-light my-6 py-4">
      <h2 class="fs-2 fw-bold text-center">Crie o titulo</h2>
      <form action="./serv-cadastrar-titulo.php" method="POST" required class="d-flex flex-column justify-content-center align-items-center" enctype="multipart/form-data">
        <div class="row justify-content-center align-items-center mb-3">
          <div class="col-12 col-lg-5 mb-3">
            <label for="titulo" class="form-label">Nome do titulo</label>
            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Toy Story 2" required>
          </div>
          <div class="col-12 col-lg-5">
            <div class="mb-3">
              <label class="form-label" for="capa-titulo">Capa do titulo</label>
              <input type="file" class="form-control" id="capa-titulo" name="capa-titulo">
            </div>
          </div>
          <div class="col-12 col-lg-5 mb-3 align-self-start">
            <label for="categoria" class="form-label">Categoria</label>
            <select class='form-select' name='categoria' id='categoria' aria-label='Default select example' required>
              <option selected disabled>Escolha a categoria</option>
              <?php 
                $sql = 'SELECT id, tipo FROM categoria';
                foreach ($bd->query($sql) as $registro){
                  echo "<option value='{$registro['id']}'>{$registro['tipo']}</option>";
                }
              ?>
            </select>
          </div>
          <div class="col-12 col-lg-5 mb-3">
            <label for="sinopse">Sinopse</label>
            <textarea class="form-control" name="sinopse" placeholder="É um filme que se passa..." id="sinopse" style="height: 100px"></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
      </form>
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
            <a class='link-primary' id="nome-preview">Toy Story</a>
          </li>
        </ol>
      </nav>
    </div>
    <article class="bg-light mb-6">
      <div class="container-xxl">
        <div class="row">
          <div class='col-3 img-titulo'>
            <img src='./imgs-usuario/61074426.jpeg' class='img-fluid' id="img-preview">
          </div>
          <div class='col-9 informacoes-titulo text-start'>
            <h3 class='fs-2' style='font-weight: 600;' id="titulo-nome-preview">Toy Story</h3>
            <p id='categoria-titulo' id="titulo-categoria-preview">Filme</p>
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
        </div>
      </div>
    </article>
  </div>
</main>