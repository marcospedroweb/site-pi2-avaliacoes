<form action="" method="POST" class="text-center" enctype="multipart/form-data" required id="form-cadastrar-titulo">
  <div class="row flex-column flex-lg-row justify-content-center align-items-center align-items-lg-start mb-3 text-start">
    <div class="col-12 col-lg-5 mb-3 row">
      <div class="col-12 mb-3">
        <label for="titulo" class="form-label">Nome do titulo</label>
        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Toy Story 2" required>
      </div>
      <div class="col-12 mb-3 align-self-start">
        <label for="categoria" class="form-label">Categoria</label>
        <select class='form-select' name='categoria' id='categoria' aria-label='Default select example' required>
          <option value="" selected disabled>Escolha a categoria</option>
          <?php 
          // loop para imprimir cada option 
          foreach($categorias as $id => $registroCategoria){
          ?>
            <option value='<?php echo $registroCategoria['id']?>'><?php echo $registroCategoria['tipo']?></option>
          <?php 
          }
          ?>
        </select>
      </div>
      <div class="col-12 mb-3">
        <label for="sinopse">Sinopse</label>
        <textarea class="form-control" name="sinopse" placeholder="É um filme que se passa..." id="sinopse" style="height: 100px"></textarea>
      </div>
    </div>
    <div class="col-12 col-lg-5 mb-3 row">
      <div class="col-12">
        <div class="mb-3">
          <label class="form-label" for="capa-titulo">Capa do titulo</label>
          <input type="file" class="form-control mb-3" id="capa-titulo" name="capa-titulo" required>
          <div id="box-posX" class="mb-3">
            <label for="posX" class="form-label">Posição X</label>
            <input type="range" class="form-range posX" min="0" max="100" step="1" name="posX" id="posX" required>
          </div>
          <div id="box-posY">
            <label for="posY" class="form-label">Posição Y</label>
            <input type="range" class="form-range posY" min="0" max="100" step="1" name="posY" id="posY" required>
          </div>
        </div>
      </div>
    </div>  
    <div class="col-12 row flex-column flex-lg-row justify-content-center aling-items-start">
      <div class="col-12 col-lg-5 row">
        <div class="col-12 mb-3">
          <label for="temporada-unica" class="form-label">Separar por temporadas?</label>
          <select class='form-select' name='temporadaUnica' id='temporadaUnica' aria-label='Default select example' required>
            <option value="" selected disabled>Escolha a forma</option>
            <option value="true">Sim</option>
            <option value="false">Não</option>
          </select>
        </div>
        <div class="col-12 mb-3 d-none" id="qtd-temporadas">
          <label for="temporadas" class="form-label">Quantidade de Temporadas</label>
          <input type="number" class="form-control" name="temporadas" id="temporadas" placeholder="5">
        </div>
      </div>
      <div class="col-12 col-lg-5 row">
        <div class="col-12 mb-3 d-none" id="box-episodios">
          <label for="episodios" class="form-label">Quantidade de Episódios</label>
          <input type="number" class="form-control" name="episodios" id="episodios" placeholder="900">
        </div>
        <div class="col-12 mb-3 d-none" id="box-duracao">
          <label for="duracao" class="form-label">Duração em minutos</label>
          <input type="number" class="form-control" name="duracao" id="duracao" placeholder="200">
        </div>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-primary" name="cadastrar-titulo">Cadastrar</button>
</form>