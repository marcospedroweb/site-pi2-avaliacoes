<main>
  <div class="container-xxl">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb m-0 py-4 fs-5">
        <li class='breadcrumb-item'>
          <a href='./categorias.php' class='link-secondary'>Categorias</a>
        </li>
        <?php 
          echo "<li class='breadcrumb-item'>
                <a href='./categorias.php?categoria={$categoria}' class='link-secondary'>{$categoria}</a>
              </li>";
          echo "<li class='breadcrumb-item' aria-current='page'>
                <a href='./categoria-escolhida.php?nome={$_GET['nome']}&categoria={$categoria}' class='link-primary'>{$_GET['nome']}</a>
              </li>";
        ?>
      </ol>
    </nav>
  </div>
  <article class="bg-light mb-6">
    <div class="container-xxl">
      <div class="row">
          <?php 
            echo "<div class='col-3 img-titulo'>
                    <img src='./imgs-usuario/{$registroTitulo['capa']}' class='img-fluid'>
                  </div>
                  <div class='col-9 informacoes-titulo text-start'>";
            echo "  <h2 class='fs-2' style='font-weight: 600;'>{$registroTitulo['nome']}</h2>";
            echo "  <p id='categoria-titulo'>{$categoria}</p>";
            echo "  <p class='mt-4 mb-6'>{$registroTitulo['sinopse']}</p>";
            echo "  <div class='d-flex justify-content-between align-items-center mt-6'>
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
                      <span class='card-avaliacao ps-3' id='titulo-escolhido-avaliacao'>{$registroTitulo['avaliacaoGeral']}</span>
                    </div>
                    <div class='d-block'>
                      <a href='#' class='btn btn-primary' id='avaliar-categoria'>Avaliar</a>
                    </div>
                  </div>";
          ?>
        </div>
      </div>
    </div>
  </article>
  <section class="bg-light">
    <div class="container-xxl">
      <div class="row">
        <section class="col-12 col-lg-6" id="comentarios">
          <h3 class="fs-3 text-center mb-3 pb-3" style="font-weight: 600;">Comentarios</h3>
          <div class="alert alert-danger text-center d-none" id="alert-cancelar" role="alert">
            <span>Você perderá seu comentario, deseja confirmar?</span>
            <div class="d-block mt-3 d-flex justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary" style="padding: 6px 16px;" id="btn-voltar-alert">Não</button>
              <button type="button" class="btn btn-primary text-danger fs-6 ms-3" id="btn-cancelar-alert">Sim</button>
            </div>
          </div>
          <div class="alert alert-danger text-center d-none" id="alert-deixe-nota" role="alert">
            <?php 
              $_SESSION['titulo'] = $_GET['nome'];
              echo "<span>É necessario deixar sua nota para {$_GET['nome']}!</span>";
              echo "<a href='./login.php?categoria-escolhida-nome={$_GET['nome']}&categoria-escolhida-categoria={$_GET['categoria']}' class='btn btn-primary ms-3 d-none' style='padding: 6px 16px;'>Se logar</a>";
            ?>
          </div>
          <form class="comentar d-none row justify-content-center align-items-center" method="POST" action="./serv-comentar.php">
            <div class="col-2 background-avatar align-self-start me-3" style="width: 72px;height: 72px; background: url(./imgs-usuario/user.png) center / cover no-repeat #ccc;border-radius: 50%">
            </div>
            <div class="col-10">
              <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" name="comentar-textarea" id="comentar-textarea" style="height: 100px"></textarea>
                <label for="comentar-textarea">Deixe sua opinião sobre Toy Story</label>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="comentar-estrelas d-flex justify-content-between align-items-center px-3">
                  <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                  <span><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                  <span class="ps-2"><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                  <span class="pe-2"><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                  <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                  <span class="pe-2"><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                  <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                  <span class="pe-2"><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                  <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                  <span><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                  <span class='avaliacao-usuario ms-3'>N/A</span>
                  <input type="text" name="avaliacao-usuario" class="d-none"  value="N/A" id="avaliacao-usuario-input">
                </div>
                <div class="comentar-buttons d-flex justify-content-end">
                  <button type="button" class="btn btn-primary text-danger fs-6 me-3" id="btn-cancelar">Cancelar</button>
                  <button type="submit" class="btn btn-primary" style="padding: 6px 16px;" id="comentar">Comentar</button>
                </div>
              </div>
            </div>
          </form>
          <div class="ja-assistiu border-bottom border-3 pb-3 d-flex justify-content-center align-items-center">
            <h4 class="fs-4 me-3">Já assistiu Toy Story?</h4>
            <div class='d-block'>
              <button type="button" class='btn btn-primary' style="padding: 12px 32px;">Avaliar</button>
            </div>
          </div>
          <section class="comentarios-dos-usuarios mt-5">
            <?php 
              $sql = "SELECT o.id, t.nome, u.nome, u.avatar, avaliacao, comentario, dataPublicado FROM `opniao` o
                      INNER JOIN titulo t ON t.id = o.titulo
                      INNER JOIN usuario u ON u.id = o.usuario
                      INNER JOIN categoria c ON c.id = t.categoria
                      WHERE t.id = {$registroTitulo['id']}";

              foreach($bd->query($sql) as $registro){
                // var_dump($registro);
                echo "<div class='comentario-usuario row justify-content-center align-items-center my-4 py-2'>
                        <div class='col-1 background-avatar align-self-start' style='width: 64px;height: 64px; background: url({$registro['avatar']}) center / cover no-repeat #ccc;border-radius: 50%'>
                        </div>
                        <div class='col-11 row justify-content-between align-items-center'>
                          <div class='col-12 row justify-content-between align-items-center'>
                            <div class='col-8 d-flex justify-content-start align-items-center'>
                              <h4 class='fs-4 m-0'>{$registro['nome']}</h4>
                              <span class='data-comentario fs-5 ms-2' style='color: #606060;'>{$registro['dataPublicado']}</span>
                            </div>
                            <div class='col-4 p-0 card-estrelas comentario-usuario-estrelas px-2 d-flex justify-content-center'>
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
                              <span class='d-block card-avaliacao comentario-avaliacao-usuario ms-3 fs-4'>{$registro['avaliacao']}</span>
                            </div>
                          </div>
                          <p class='col-12 d-block comentario-paragrafo pt-1'>{$registro['comentario']}</p>
                        </div>
                      </div>";
              }
            ?>
          </section>
        </section>
        <section class="col-12 col-lg-6">
          <?php
            echo "<h3 class='fs-3 text-center' style='font-weight: 600;'>Outros títulos em {$categoria}</h3>";
          ?> 
          <div class="row destaques justify-content-center align-items-start">
            <?php 
              $sql = "SELECT t.id, t.nome, capa, avaliacaoGeral, c.tipo 
                      FROM titulo as t INNER JOIN categoria as c
                      ON t.categoria = c.id
                      WHERE c.tipo = '{$categoria}' and t.nome <> '{$_GET['nome']}'";
              foreach($bd->query($sql) as $registro){
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
  </section>
</main>