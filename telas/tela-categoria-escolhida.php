<main>
  <?php
    include('./telas/frag-alerts.php');
  ?>
  <div class="container-xxl">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb m-0 py-4 fs-5">
        <?php 
          include('./telas/frag-breadcrumb-item.php');
        ?>
      </ol>
    </nav>
  </div>
  <article class="bg-light mb-6">
    <div class="container-xxl py-4">
      <div class="row">
        <?php 
        if($registrosTituloEscolhido ){
          foreach($registrosTituloEscolhido as $id => $tituloEscolhidoRegistro){
        ?>
          <div class='col-3 img-titulo'>
            <div class="d-block" style="width:304px;height:464px;background: url(./imgs-usuario/<?php echo $tituloEscolhidoRegistro['capa'] ?>) <?php echo $tituloEscolhidoRegistro['posX'] ?> <?php echo $tituloEscolhidoRegistro['posY'] ?> / cover no-repeat #ccc;" id="img-preview"></div>
          </div>
          <div class='col-9 informacoes-titulo text-start'>
            <h2 class='fs-2' style='font-weight: 600;'><?php echo $tituloEscolhidoRegistro['nome'] ?></h2>
            <div id="informacoes-titulo" class="d-flex justify-content-center align-items-center" style="width: fit-content;">
              <p id='categoria-titulo'><?php echo $tituloEscolhidoRegistro['tipo'] ?></p>
              <p id='temporadas-titulo' class="d-none"><?php echo $tituloEscolhidoRegistro['temporadas']?></p>
              <p id='episodios-titulo' class="d-none"><?php echo $tituloEscolhidoRegistro['episodios']?></p>
              <p id='duracao-titulo' class="d-none"><?php echo $tituloEscolhidoRegistro['duracao'] ?></p>
            </div>
            <p class='mt-4 mb-6'><?php echo $tituloEscolhidoRegistro['sinopse'] ?></p>
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
                <span class='card-avaliacao ps-3' id='titulo-escolhido-avaliacao'><?php echo $tituloEscolhidoRegistro['avaliacaoGeral'] ?></span>
              </div>
              <div class='d-block'>
                <a href='#' class='btn btn-primary' id='avaliar-categoria'>Avaliar</a>
              </div>
            </div>
          </div>
        <?php 
          }
        }
        ?>
      </div>
    </div>
  </article>
  <section class="bg-light">
    <div class="container-xxl py-4">
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
            <span>É necessario deixar sua nota para <?php echo $tituloNome ?>!</span>
            <a href='./login.php?categoria-escolhida-nome=<?php echo $tituloNome ?>&categoria-escolhida-categoria=<?php echo $categoria ?>' class='btn btn-primary ms-3 d-none' style='padding: 6px 16px;'>Se logar</a>
          </div>
          <form class="comentar d-none row justify-content-center align-items-center" method="POST" action="">
            <?php 
            if(isset($_SESSION['id'])){
            ?>
              <div class="col-2 background-avatar align-self-start me-3" style="width: 72px;height: 72px; background: url(./imgs-usuario/<?php echo $_SESSION['avatar'] ?>) <?php echo $usuarioPosX ?> <?php echo $usuarioPosY ?> / <?php echo $zoomAvatar ?> no-repeat #ccc;border-radius: 50%">
              </div>
            <?php 
            } else{
            ?>
              <div class="col-2 background-avatar align-self-start me-3" style="width: 72px;height: 72px; background: url(./imgs-usuario/user.png) center / cover no-repeat #ccc;border-radius: 50%">
              </div>
            <?php 
            }
            ?>
            <div class="col-10">
              <div class="form-floating" id="div-comentario">
                <textarea class="form-control" placeholder="Leave a comment here" name="comentar-textarea" id="comentar-textarea" style="height: 100px" maxlength="1200"></textarea>
                <span id="span-comentario">0 / 1200</span>
                <label for="comentar-textarea">Deixe sua opinião sobre <?php echo $tituloNome?></label>
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
                <div class="d-flex justify-content-end" id="comentar-buttons">
                  <button type="button" class="btn-cancelar btn btn-primary text-danger fs-6 me-3">Cancelar</button>
                  <button type="submit" class="btn btn-primary" style="padding: 6px 16px;">Comentar</button>
                </div>
              </div>
            </div>
          </form>
          <div class="ja-assistiu border-bottom border-3 pb-3 d-flex justify-content-center align-items-center">
            <h4 class="fs-4 me-3 fw-normal">Já assistiu <span class="fs-4 fw-bold"><?php echo $tituloNome?>?</span></h4>
            <div class='d-block'>
              <button type="button" class='btn btn-primary' style="padding: 12px 32px;">Avaliar</button>
            </div>
          </div>
          <section class="comentarios-dos-usuarios mt-5">
            <?php
            if($comentarios){
              foreach($comentarios as $id => $registroComentario){
            ?>
                <div class='comentario-usuario row justify-content-center align-items-center my-4 py-2 position-relative'>
                  <?php 
                    if($registroComentario['posX'] === 'center' && $registroComentario['posX'] === 'center'){
                      $usuarioPosXComentario = $registroComentario['posX'];
                      $usuarioPosYComentario = $registroComentario['posY'];
                    } else{
                      $usuarioPosXComentario = "{$registroComentario['posX']}%";
                      $usuarioPosYComentario = "{$registroComentario['posY']}%";
                    }
                    if($registroComentario['zoom'] === 'cover')
                      $zoomAvatarComentario = $registroComentario['zoom'];
                    else
                      $zoomAvatarComentario = "{$registroComentario['zoom']}%";
                  ?>
                  <div class='col-1 background-avatar align-self-start mt-1' style='width: 64px;height: 64px; background: url(./imgs-usuario/<?php echo $registroComentario['avatar'] ?>) <?php echo $usuarioPosXComentario ?> <?php echo $usuarioPosYComentario ?> / <?php echo $zoomAvatarComentario ?> no-repeat #ccc;border-radius: 50%'>
                  </div>
                  <div class='col-11 row justify-content-between align-items-center'>
                    <div class='col-12 row justify-content-start align-items-start'>
                      <div class='col-7 d-flex flex-column justify-content-start align-items-start'>
                        <h4 class='fs-4 m-0'><?php echo $registroComentario['nome']?></h4>
                        <span class='data-comentario fs-5 mt-1 text-start' style='color: #606060;'><?php echo $registroComentario['dataPublicado']?></span>
                      </div>
                      <div class='col p-0 px-2 mt-1 card-estrelas comentario-usuario-estrelas d-flex justify-content-center' style="width: fit-content;">
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
                        <span class='d-block card-avaliacao comentario-avaliacao-usuario ms-2 fs-4'><?php echo $registroComentario['avaliacao']?></span>
                      </div>
                    </div>
                    <p class='col-12 d-block comentario-paragrafo pt-1' style="white-space:pre-wrap;">
                      <?php echo $registroComentario['comentario']; ?>
                    </p>
                    <?php 
                    if((isset($_SESSION['id']) && $usuario === $registroComentario['usuario']) || $usuario === 3){
                    ?>
                      <form class="d-none editar-comentario row justify-content-center align-items-center" method="POST" action="">
                        <div class="alert alert-danger text-center d-none" id="alert-deixe-nota-editar" role="alert">
                          <span>É necessario deixar sua nota para <?php echo $tituloNome ?>!</span>
                          <a href='./login.php?categoria-escolhida-nome=<?php echo $tituloNome ?>&categoria-escolhida-categoria=<?php echo $categoria ?>' class='btn btn-primary ms-3 d-none' style='padding: 6px 16px;'>Se logar</a>
                        </div>
                        <div class="col-12">
                          <div class="form-floating" id="div-comentario-editar">
                            <textarea class="form-control d-block" placeholder="Leave a comment here" name="editar-comentario-textarea" id="editar-comentario-textarea" style="height: 100px" id="textarea-comentario-editar" maxlength="1250"><?php echo $registroComentario['comentario']?></textarea>
                            <span id="span-comentario-editar">0 / 1250</span>
                            <label for="editar-comentario-textarea">Deixe sua opinião</label>
                          </div>
                          <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex justify-content-between align-items-center px-3" id="comentar-estrelas-editar">
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
                              <span class='avaliacao-usuario ms-3' id="avaliacao-usuario"><?php echo $registroComentario['avaliacao']?></span>
                              <input type="text" name="editar-avaliacao" class="d-none"  value="N/A" id="editar-avaliacao-usuario-input">
                              <input type="text" name="editar-id-usuario" id="editar-id-usuario" class="d-none"  value="<?php echo $registroComentario['usuario']?>">
                              <input type="text" name="editar-titulo" class="d-none"  value="<?php echo $tituloNome?>">
                              <input type="text" name="editar-categoria" class="d-none"  value="<?php echo $categoria?>">
                            </div>
                            <div class="editar-buttons d-flex justify-content-end">
                              <button type="button" class="btn btn-primary text-danger fs-6 me-3" id="btn-editar-cancelar">Cancelar</button>
                              <button type="submit" class="btn btn-primary" style="padding: 6px 16px;" name="id-comentario" value="<?php echo $registroComentario['id']?>">Atualizar</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php 
                    }
                    ?>
                  </div>
                  <?php 
                  if(((isset($_SESSION['id']) && $usuario === $registroComentario['usuario'])) || $usuario === 3){
                  ?>
                    <div class="btn-group dropend dropend-hidden position-absolute" id="<?php echo $registroComentario['id']?>">
                      <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fs-3"></i>
                      </button>
                        <div class="dropdown-menu p-0">
                          <ul class="list-unstyled m-0 p-0">
                              <li class="d-flex flex-column justify-content-start align-items-start mx-auto" style="width: 80%">
                                <?php 
                                if(((isset($_SESSION['id']) && $usuario === $registroComentario['usuario']))){
                                ?>
                                  <button type="button" class="btn btn-editar-comentario d-flex flex-row justify-content-start align-items-center"><i class="fas fa-pencil-alt me-3"></i></button>
                                <?php 
                                }
                                ?>
                                <button type="button" class="btn btn-apagar-comentario d-flex flex-row justify-content-start align-items-center" data-bs-toggle="modal" data-bs-target="#modal-apagar"><i class="fas fa-trash-alt me-3"></i></button>
                              </li>
                          </ul>
                        </div>
                    </div>
                  <?php 
                    }
                  ?>
                </div>
            <?php
              }
            }
            ?>
            <div class="modal fade" id="modal-apagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header border-0">
                      <h4 class="modal-title" id="staticBackdropLabel">Apagar comentario?</h4>
                    </div>
                    <div class="modal-body">
                      <span class="fs-4">Apagar comentario permanentemente? Essa ação é irreversível.</span>
                    </div>
                    <div class="modal-footer">
                      <form action="./categoria-escolhida.php?nome=<?php echo $tituloNome ?>&categoria=<?php echo $categoria ?>" class="p-0" method="POST">
                        <button type="button" class="btn fs-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn fs-4 text-danger fw-bold ms-3" value="0" name="btn-apagar-comentario" id="btn-apagar-comentario">Apagar</button>
                        <input type="text" class="d-none" value="<?php echo $usuario ?>" name="input-id-usuario">
                        <input type="text" class="d-none" value="<?php echo $tituloEscolhidoRegistro['id'] ?>" name="input-id-titulo">
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
        </section>
        <section class="col-12 col-lg-6">
          <h3 class='fs-3 text-center' style='font-weight: 600;'>Outros títulos em <?php echo $categoria?></h3>
          <div class="row destaques justify-content-center align-items-start">
            <?php 
            if($titulosDaCategoria){
              foreach($titulosDaCategoria as $id => $registroTitulosCategoria){
            ?>
              <div class='destaque-card col-12 col-lg my-2 text-center'>
                <a href='./categoria-escolhida.php?nome=<?php echo $registroTitulosCategoria['nome']?>&categoria=<?php echo $categoria?>' class='d-block destaque-container' style='background: url(./imgs-usuario/<?php echo $registroTitulosCategoria['capa']?>) center top / cover no-repeat #ccc;'>
                    <span class='card-nome'><?php echo $registroTitulosCategoria['nome']?></span>
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
                    <span class='card-avaliacao ms-2'><?php echo $registroTitulosCategoria['avaliacaoGeral']?></span>
                </div>
              </div>
            <?php
              }
            }
            ?>
          </div>
        </section>
      </div>
    </div>
  </section>
</main>