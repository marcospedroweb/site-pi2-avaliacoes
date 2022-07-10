<?php
require_once __DIR__ . '/Model.class.php';

class Titulo extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->tabela = 'titulo';
  }


  public function criar(array $dados): array
  {
    // Registrar um novo titulo no banco
    //Variaveis utilizadas
    $titulo = $dados['titulo'] ?? '';
    $categoria = $dados['categoria'] ?? '';
    $sinopse = $dados['sinopse'] ?? '';
    $posX = "{$dados['posX']}%" ?? '';
    $posY = "{$dados['posY']}%" ?? '';
    $temporadas = $dados['temporadas'] ?? '';
    $episodios = $dados['episodios'] ?? '';
    $duracao = $dados['duracao'] ?? '';
    $temporadaUnica = $dados['temporadaUnica'] ?? '';

    //Verificando se há titulo, se houver impede o insert
    if (!($titulo))
      return array(false, 'É necessario cadastrar o nome do titulo!'); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se aquele titulo já está registrado no banco
    $sql = "SELECT id, nome FROM titulo WHERE nome = :nome";
    //Passando os valores para executar o sql
    $registrosUsuario = array($titulo);
    $select = $this->prepare($sql);
    $select->execute([':nome' => $titulo]);
    $tituloRepetido = $select->fetchAll();
    if ($tituloRepetido[0]['id'])
      //Se retornar o id, aquele titulo já foi postado
      return array(false, "($tituloRepetido[0]['nome']) já cadastrado no banco."); //Se NÃO der certo, retorna false e não executa o que está abaixo  

    //Variaveis utilizadas
    $nomeTemporarioArquivo = $_FILES['capa-titulo']['tmp_name'];
    $pastaDeArquivos = '.\imgs-usuario/';

    //Verificando se o arquivo é uma imagem e se a extensão é valida
    $tipo = mime_content_type($nomeTemporarioArquivo);
    switch ($tipo) {
      case 'image/png':
        $ext = '.png';
        break;
      case 'image/jpeg':
        $ext = '.jpeg';
        break;
      case 'image/jpg':
        $ext = '.jpg';
        break;
      case 'image/gif':
        $ext = '.gif';
        break;
    }
    //Se a extensão não for valida, impede o insert
    if (!($ext))
      //Se não for valida, retorna para a pagina de criar titulo
      return array(false, "A imagem inserida é inválida.");

    //Se a extensão for valida, armazena tal imagem com nome aleatorio na pasta
    $random = rand(1, 99999999);
    $capa = $random . $ext;
    move_uploaded_file($nomeTemporarioArquivo, $pastaDeArquivos . $capa);

    //Preparando o insert
    $sql = "INSERT INTO titulo
              (nome, sinopse, capa, posX, posY, avaliacaoGeral, categoria, temporadas, episodios, duracao, temporadaUnica) 
            VALUES 
              (:nome, :sinopse, :capa, :posX, :posY, :avaliacaoGeral, :categoria, :temporadas, :episodios, :duracao, :temporadaUnica)";


    $avaliacaoGeral = 0;
    //Passando os valores para executar o sql
    $registrosUsuario = array(
      ':nome' => $titulo,
      ':sinopse' => $sinopse,
      ':capa' => $capa,
      ':posX' => $posX,
      ':posY' => $posY,
      ':avaliacaoGeral' => $avaliacaoGeral,
      ':categoria' => $categoria,
      ':temporadas' => $temporadas,
      ':episodios' => $episodios,
      ':duracao' => $duracao,
      ':temporadaUnica' => $temporadaUnica
    );
    $insert = $this->prepare($sql);
    $resultado = $insert->execute($registrosUsuario);
    //Verificando se o insert deu certo
    if (!($resultado))
      return array(false, "Houve um erro ao cadastrar o titulo, tente novamente.");

    $insertCompleto[0] = true;
    $insertCompleto['nome'] = $titulo;
    //Mudando o id de categoria para o nome dela
    $categorias = $this->mostrarTiposDeTitulos();
    foreach ($categorias as $item => $registroCategoria)
      if ($registroCategoria['id'] === intval($categoria))
        $insertCompleto['categoria'] = $registroCategoria['tipo'];

    return $insertCompleto; //Retornando array com valores, para redirecionar para a pagina daquele titulo inserido
  }

  public function atualizar(array $dados): array
  {
    // Editar algum dado de um titulo existente

    $idTitulo = $dados['id'] ?? '';
    if (!($dados['id']))
      return array(false, 'Id titulo inválido.');

    //Verificando se esse titulo existe no banco
    $sql = "SELECT id
            FROM titulo
            WHERE id = :id";
    $select = $this->prepare($sql);
    $select->execute([':id' => $idTitulo]);
    $titulo = $select->fetchAll();
    if (!($titulo[0]['id']))
      return array(false, 'Não existe o titulo inserido.');

    //Variaveis utilizadas
    $nomeTitulo = $dados['titulo'] ?? '';
    $categoriaTitulo = $dados['categoria'] ?? '';
    $sinopse = $dados['sinopse'] ?? '';
    $capaAtualTitulo = $dados['capa-atual'] ?? '';
    $posXTitulo = "{$dados['posX']}%" ?? '';
    $posYTitulo = "{$dados['posY']}%" ?? '';
    $temporadaUnica = $dados['temporadaUnica'] ?? '';
    $temporadasTitulo = $dados['temporadas'] ?? '';
    $episodiosTitulo = $dados['episodios'] ?? '';
    $duracaoTitulo = $dados['duracao'] ?? '';

    //Variaveis utilizadas
    $nomeArquivo = $_FILES['capa-titulo']['name'] ?? '';
    if (!($nomeArquivo === $capaAtualTitulo || $nomeArquivo === '')) {
      $nomeTemporarioArquivo = $_FILES['capa-titulo']['tmp_name'];
      $pastaDeArquivos = '.\imgs-usuario/';

      //Verificando se o arquivo é uma imagem e se a extensão é valida
      $tipo = mime_content_type($nomeTemporarioArquivo);
      switch ($tipo) {
        case 'image/png':
          $ext = '.png';
          break;
        case 'image/jpeg':
          $ext = '.jpeg';
          break;
        case 'image/jpg':
          $ext = '.jpg';
          break;
        case 'image/gif':
          $ext = '.gif';
          break;
      }
      //Se a extensão não for valida, impede o insert
      if (!($ext))
        //Se não for valida, retorna para a pagina de criar titulo
        return array(false, "A imagem inserida é inválida.");

      //Se a extensão for valida, armazena tal imagem com nome aleatorio na pasta
      $random = rand(1, 99999999);
      $capa = $random . $ext;
      move_uploaded_file($nomeTemporarioArquivo, $pastaDeArquivos . $capa);
      $capaAtualTitulo = $capa;
    }

    $sql = "UPDATE titulo
            SET nome = :nome,
              sinopse = :sinopse,
              capa = :capa,
              posX = :posX,
              posY = :posY,
              categoria = :categoria,
              temporadas = :temporadas,
              episodios = :episodios,
              duracao = :duracao,
              temporadaUnica = :temporadaUnica
            WHERE id = :id";
    $registrosTitulo = array(
      ':nome' => $nomeTitulo,
      ':sinopse' => $sinopse,
      ':capa' => $capaAtualTitulo,
      ':posX' => $posXTitulo,
      ':posY' => $posYTitulo,
      ':categoria' => $categoriaTitulo,
      ':temporadas' => $temporadasTitulo,
      ':episodios' => $episodiosTitulo,
      ':duracao' => $duracaoTitulo,
      ':temporadaUnica' => $temporadaUnica,
      ':id' => $idTitulo
    );
    $update = $this->prepare($sql);
    $resultado = $update->execute($registrosTitulo);
    //Verificando se o update deu certo
    if (!($resultado))
      return array(false, 'Houve um erro ao atualizar o titulo, tente novamente.');

    //Recuperando alguns registros do titulo
    $sql = "SELECT nome, tipo
            FROM titulo t
            INNER JOIN categoria c
              ON t.categoria = c.id
            WHERE t.id = :id";
    $select = $this->prepare($sql);
    $select->execute([':id' => $idTitulo]);
    $titulos = $select->fetchAll();

    $updateRealizado = array(
      0 => true,
      'nome' => $titulos[0]['nome'],
      'categoria' => $titulos[0]['tipo']
    );

    return $updateRealizado ?? '';
  }

  public function apagar(array $dados): array
  {
    // Apagar um titulo existente no banco
    $idTitulo = $dados['id'] ?? '';
    if (!($idTitulo))
      return array(false, 'Houve um erro, Titulo não encontrado.');

    //Verificando se esse titulo existe no banco
    $sql = "SELECT id, nome
            FROM titulo
            WHERE id = :id";
    $select = $this->prepare($sql);
    $select->execute([':id' => $idTitulo]);
    $titulo = $select->fetchAll();
    if (!($titulo[0]['id']))
      return array(false, 'Não existe o titulo inserido.');

    //Verificando se há comentarios nesse titulo
    $sql = "SELECT id
            FROM opniao
            WHERE titulo_id = :titulo_id";
    $select = $this->prepare($sql);
    $resultado = $select->execute([':titulo_id' => $idTitulo]);
    if ($resultado) {
      //Apagando todos os comentarios daquele titulo
      $sql = "DELETE FROM opniao
              WHERE titulo_id = :titulo_id";
      $delete = $this->prepare($sql);
      $resultado = $delete->execute([':titulo_id' => $idTitulo]);
      if (!($resultado))
        return array(false, 'Houve um erro ao apagar os comentarios do titulo.');
    }

    //Deletando o titulo
    $sql = "DELETE FROM titulo
            WHERE id = :id";
    $delete = $this->prepare($sql);
    $resultado = $delete->execute([':id' => $idTitulo]);
    if (!($resultado))
      return array(false, 'Houve um erro, titulo NÃO apagado.');

    return array(true, 'Titulo apagado com sucesso!');
  }

  public function listar(array $dados): array
  {
    //Retorna os titulos e/ou nome daquela categoria ou de todas
    $categoria = $dados[0] ?? '';
    $titulo = $dados[1] ?? '';
    $orderBy = $dados[2] ?? '';
    $paginaAtual = $dados[3] ?? '';
    $parametroAval = "";
    $proximasLinhas = 16;

    //Verificando se a variavel de paginação é valida
    if ($paginaAtual === '' || !(is_numeric($paginaAtual)) || $paginaAtual === 0 || $paginaAtual === 1 || $paginaAtual < 0)
      $paginaAtual = 0; //Se não for, adiciona a pagina padrão
    else if ($paginaAtual !== 0 && $paginaAtual !== 1)
      $paginaAtual = ($paginaAtual - 1) * 16;

    //Verificando se é necessario ordenar o resultado
    switch ($orderBy) {
      case 'Nome (A-Z)':
        //Ordena pelo nome de A-Z
        $orderBy = "t.nome asc";
        break;
      case 'Sem avaliação':
        //Ordena pelos sem avaliação
        $orderBy = "avaliacaoGeral asc";
        break;
      case 'destaques':
        //Ordena pelos top 8 mais bem avaliados
        $orderBy = "avaliacaoGeral desc";
        $proximasLinhas = 8;
        break;
      default:
        //orderna pela avaliacão daquele titulo
        $orderBy = "avaliacaoGeral desc";
    }

    //Sql para o select
    $sql = "SELECT
              t.id, t.nome, sinopse, capa, posX, posY, avaliacaoGeral, c.tipo, temporadas, episodios, duracao,temporadaUnica 
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE c.tipo like '%{$categoria}%' and t.nome like '%{$titulo}%' {$parametroAval}
            ORDER BY {$orderBy}
            OFFSET {$paginaAtual} ROWS
            FETCH NEXT {$proximasLinhas} ROWS ONLY";

    $select = $this->prepare($sql);
    $resultado = $select->execute();
    if ($resultado)
      $titulos = $select->fetchAll();

    return $titulos ?? ''; //retorna o(s) titulo(s)
  }

  function contarTitulosRegistrados($dados)
  {
    //Retorna a quantidade de titulos registrados, em tal categoria ou em todas
    $categoria = $dados[0] ?? '';
    $categoria = $categoria === 'Ver todas' ? '' : $categoria;
    $titulo = $dados[1] ?? '';
    //sql para o select
    $sql = "SELECT
              count(*) as 'qtd'
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE c.tipo like '%{$categoria}%' and t.nome like '%{$titulo}%'";
    $select = $this->prepare($sql);
    $resultado = $select->execute();
    if ($resultado)
      $qtdTitulos = $select->fetchAll();

    return $qtdTitulos[0]['qtd'] ?? ''; //Retorna o numero de titulos
  }

  function mostrarTitulosDaCategoria($dados)
  {
    //Retorna todos os titulos de tal categoria com exceção daquele titulo especificado
    //variaveis utilizadas
    $categoria = $dados[0] ?? '';
    $titulo = $dados[1] ?? '';

    //sql para o select
    $sql = "SELECT TOP 8
              t.id, t.nome, sinopse, capa, posX, posY, avaliacaoGeral, c.tipo, temporadas, episodios, duracao, temporadaUnica 
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE c.tipo = :tipo and t.nome <> :nome
            ORDER BY avaliacaoGeral desc";

    $select = $this->prepare($sql);
    $resultado = $select->execute([
      ':tipo' => $categoria,
      ':nome' => $titulo
    ]);

    //Se houver registros retornados, separa por id
    if ($resultado)
      $titulos = $select->fetchAll();

    return $titulos ?? ''; //retorna o(s) titulo(s) seperado(s) por id
  }

  function verificarExistenciaTitulo($dados)
  {
    //Verifica se existe aquele titulo especificado, se existir retorna os registros
    $categoria = $dados[0] ?? '';
    $titulo = $dados[1] ?? '';

    //Verifica se a categoria do GET existe em alguma categoria do banco
    if (!($categoria === 'Filmes' || $categoria === 'Animes' || $categoria === 'Series')) {
      //Se não houver essa categoria, retorna para a pagina categorias com GET de erro
      header('Location: ./categorias.php?nao-encontrado=true');
      exit();
    }

    //Verifica se há titulo passado
    if (!($titulo)) {
      //Se não houver titulo, retorna para a pagina categorias com GET de erro
      header('Location: ./categorias.php?nao-encontrado=true');
      exit();
    }

    //Sql para o select
    $sql = "SELECT 
              t.id, t.nome, sinopse, capa, posX, posY, avaliacaoGeral, c.tipo, temporadas, episodios, duracao, temporadaUnica
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE t.nome = :nome and c.tipo = :tipo";
    $select = $this->prepare($sql);
    $resultado = $select->execute([
      ':nome' => $titulo,
      ':tipo' => $categoria
    ]);

    if ($resultado)
      $titulos = $select->fetchAll();

    //Se o select NÃO retornar algo que foi requisitado, retorna para a pagina categorias com GET de erro
    if ($titulos)
      foreach ($titulos as $item => $titulo) {
        if (!(isset($titulo['id']))) {
          header('Location: ./categorias.php?nao-encontrado=true');
          exit();
        }
      }
    else
      $titulos = '';

    return $titulos ?? ''; //retorna o(s) titulo(s) seperado(s) por id
  }

  function mostrarTiposDeTitulos()
  {
    //Retorna todos tipos de titulos registrados

    //Sql para o select
    $sql = "SELECT id, tipo
            FROM categoria";
    $select = $this->prepare($sql);
    if ($select->execute())
      $categorias = $select->fetchAll();

    return $categorias ?? ''; //Retorna os tipos de titulos
  }

  function mostrarTituloEspecifico($idTitulo)
  {
    //Retorna um titulo especifico para ser editado ou apagado
    $idTitulo = $dados['id'] ?? '';
    //Verifica se há id do titulo passado
    if (!($idTitulo))
      return false;

    //Sql para o select
    $sql = "SELECT 
              t.id, t.nome, sinopse, capa, posX, posY, avaliacaoGeral, c.tipo, temporadas, episodios, duracao, temporadaUnica
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE t.id = :id";
    $registroUsuario = array($idTitulo);
    $select = $this->prepare($sql);
    if ($select->execute([':id' => $idTitulo]))
      $tituloEspecifico = $select->fetchAll()[0];

    return $tituloEspecifico ?? ''; //Retorna o titulo especifico
  }
}
