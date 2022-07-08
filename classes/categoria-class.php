<?php

class Categoria {
  //cria objeto Disciplina
  var $conn;//variavel para receber o banco de dados
  var $colunasCompletas;

  function __construct($conn){
    // Essa função será executada quando instanciar o objeto
    $this->conn = $conn;//recebe o banco de dados php my admin
  }

  function criarTitulo($post){
    // Registrar um novo titulo no banco
    //Variaveis utilizadas
    $titulo = $post['titulo'] ?? '';
    $categoria = $post['categoria'] ?? '';
    $sinopse = $post['sinopse'] ?? '';
    $posX = "{$post['posX']}%" ?? '';
    $posY = "{$post['posY']}%" ?? '';
    $temporadas = $post['temporadas'] ?? '';
    $episodios = $post['episodios'] ?? '';
    $duracao = $post['duracao'] ?? '';
    $temporadaUnica = $post['temporadaUnica'] ?? '';

    //Verificando se há titulo, se houver impede o insert
    if(!($titulo))
      return array(false, 'É necessario cadastrar o nome do titulo!');//Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se aquele titulo já está registrado no banco
    $sql = "SELECT id, nome FROM titulo WHERE nome = ?";
    //Passando os valores para executar o sql
    $registrosUsuario = array($titulo);
    $tituloRepetido = sqlsrv_query($this->conn, $sql, $registrosUsuario);
    if($tituloRepetido){
      $linhaRepetida = sqlsrv_fetch_array( $tituloRepetido, SQLSRV_FETCH_ASSOC);
      //Se retornar o id, aquele titulo já foi postado
     if($linhaRepetida['id'])
      return array(false, "{$linhaRepetida['nome']} já cadastrado no banco.");//Se NÃO der certo, retorna false e não executa o que está abaixo  
    }
    
    //Variaveis utilizadas
    $nomeArquivo = $_FILES['capa-titulo']['name'];
    $nomeTemporarioArquivo = $_FILES['capa-titulo']['tmp_name'];
    $pastaDeArquivos = '.\imgs-usuario/';

    //Verificando se o arquivo é uma imagem e se a extensão é valida
    $tipo = mime_content_type($nomeTemporarioArquivo);
    switch ($tipo){
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
    if(!($ext))
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
              (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    
    $avaliacaoGeral = 0;
    //Passando os valores para executar o sql
    $registrosUsuario = array(
      $titulo,
      $sinopse,
      $capa, 
      $posX,
      $posY,
      $avaliacaoGeral,
      $categoria,
      $temporadas,
      $episodios,
      $duracao,
      $temporadaUnica
    );
    $insert = sqlsrv_query($this->conn, $sql, $registrosUsuario);
    //Verificando se o insert deu certo
    if(!($insert))
      return array(false, "Houve um erro ao cadastrar o titulo, tente novamente.");

    $insertCompleto[0] = true;
    $insertCompleto['nome'] = $titulo;
    //Mudando o id de categoria para o nome dela
    $registrosTipos = $this->mostrarTiposDeTitulos();
    foreach($registrosTipos as $id => $tipoTitulo)
      if($tipoTitulo['id'] === intval($categoria))
        $insertCompleto['categoria'] = $tipoTitulo['tipo'];
        
    return $insertCompleto;//Retornando array com valores, para redirecionar para a pagina daquele titulo inserido
  }

  function editarTitulo($idTitulo, $dadosPost){
    // Editar algum dado de um titulo existente

    
    $idTitulo = $idTitulo ?? '';
    if(!($idTitulo))
      return array(false, 'Id titulo inválido.');

    //Verificando se esse titulo existe no banco
    $sql = "SELECT id
            FROM titulo
            WHERE id = ?";
    $select = sqlsrv_query($this->conn, $sql, array($idTitulo));
    $registroTitulo = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC);
    if(!($registroTitulo['id']))
      return array(false, 'Não existe o titulo inserido.');

    //Variaveis utilizadas
    $nomeTitulo = $dadosPost['titulo'] ?? '';
    $categoriaTitulo = $dadosPost['categoria'] ?? '';
    $sinopse = $dadosPost['sinopse'] ?? '';
    $capaAtualTitulo = $dadosPost['capa-atual'] ?? '';
    $posXTitulo = "{$dadosPost['posX']}%" ?? '';
    $posYTitulo = "{$dadosPost['posY']}%" ?? '';
    $temporadaUnica = $dadosPost['temporadaUnica'] ?? '';
    $temporadasTitulo = $dadosPost['temporadas'] ?? '';
    $episodiosTitulo = $dadosPost['episodios'] ?? '';
    $duracaoTitulo = $dadosPost['duracao'] ?? '';

    //Variaveis utilizadas
    $nomeArquivo = $_FILES['capa-titulo']['name'] ?? '';
    if(!($nomeArquivo === $capaAtualTitulo || $nomeArquivo === '')){
      $nomeTemporarioArquivo = $_FILES['capa-titulo']['tmp_name'];
      $pastaDeArquivos = '.\imgs-usuario/';

      //Verificando se o arquivo é uma imagem e se a extensão é valida
      $tipo = mime_content_type($nomeTemporarioArquivo);
      switch ($tipo){
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
      if(!($ext))
        //Se não for valida, retorna para a pagina de criar titulo
        return array(false, "A imagem inserida é inválida.");

      //Se a extensão for valida, armazena tal imagem com nome aleatorio na pasta
      $random = rand(1, 99999999);
      $capa = $random . $ext;
      move_uploaded_file($nomeTemporarioArquivo, $pastaDeArquivos . $capa);
      $capaAtualTitulo = $capa;
    }

    $sql = "UPDATE titulo
            SET nome = ?,
              sinopse = ?,
              capa = ?,
              posX = ?,
              posY = ?,
              categoria = ?,
              temporadas = ?,
              episodios = ?,
              duracao = ?,
              temporadaUnica = ?
            WHERE id = ?";
    $registrosTitulo = array(
      $nomeTitulo, 
      $sinopse, 
      $capaAtualTitulo, 
      $posXTitulo, 
      $posYTitulo, 
      $categoriaTitulo, 
      $temporadasTitulo, 
      $episodiosTitulo, 
      $duracaoTitulo, 
      $temporadaUnica, 
      $idTitulo
    );
    $update = sqlsrv_query($this->conn, $sql, $registrosTitulo);
    //Verificando se o update deu certo
    if(!($update))
      return array(false, 'Houve um erro ao atualizar o titulo, tente novamente.');
    
    //Recuperando alguns registros do titulo
    $sql = "SELECT nome, tipo
            FROM titulo t
            INNER JOIN categoria c
              ON t.categoria = c.id
            WHERE t.id = ?";
    $select = sqlsrv_query($this->conn, $sql, array($idTitulo));
    $registroTitulo = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC);
    
    $updateRealizado[0] = true;
    $updateRealizado['nome'] = $registroTitulo['nome'];
    $updateRealizado['categoria'] = $registroTitulo['tipo'];

    return $updateRealizado ?? '';
  }

  function apagarTitulo($idTitulo){
    // Apagar um titulo existente no banco
    $idTitulo = $idTitulo ?? '';
    if(!($idTitulo))
      return array(false, 'Houve um erro, Titulo não encontrado.');

    //Verificando se esse titulo existe no banco
    $sql = "SELECT id, nome
            FROM titulo
            WHERE id = ?";
    $select = sqlsrv_query($this->conn, $sql, array($idTitulo));
    $registroTitulo = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC);
    if(!($registroTitulo['id']))
      return array(false, 'Não existe o titulo inserido.');

    //Verificando se há comentarios nesse titulo
    $sql = "SELECT id
            FROM opniao
            WHERE titulo = ?";
    $select = sqlsrv_query($this->conn, $sql, array($idTitulo));
    if($select){
      //Apagando todos os comentarios daquele titulo
      $sql = "DELETE FROM opniao
              WHERE titulo = ?";
      $delete = sqlsrv_query($this->conn, $sql, array($idTitulo));
      if(!($delete))
        return array(false, 'Houve um erro ao apagar os comentarios do titulo.');
    }
    

    //Deletando o titulo
    $sql = "DELETE FROM titulo
            WHERE id = ?";
    $delete = sqlsrv_query($this->conn, $sql, array($idTitulo));
    if(!($delete))
      return array(false, 'Houve um erro, titulo NÃO apagado.');
    
    return array(true, 'Titulo apagado com sucesso!');
  }

  function contarTitulosRegistrados($arrayValores){
    //Retorna a quantidade de titulos registrados, em tal categoria ou em todas
    $categoria = $arrayValores[0] ?? '';
    $categoria = $categoria === 'Ver todas' ? '' : $categoria;
    $titulo = $arrayValores[1] ?? '';
    $orderBy = $arrayValores[2] ?? '';
    $paginaAtual = $arrayValores[3] ?? '';
    //sql para o select
    $sql = "SELECT
              count(*) as 'qtd'
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE c.tipo like '%{$categoria}%' and t.nome like '%{$titulo}%'";
    $select = sqlsrv_query($this->conn, $sql);

    while($registro = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC))
      //Com a instancia do banco, desse mesmo objeto, faz um query, executando o select acima
      // Seria igual a $this->conn->query($sql) as $registro === $bd->query(sql) as $registro 
      $qtdTitulos = $registro;
      //Criar um array que recebe todo os registros daquele id especifico

    return $qtdTitulos ?? '';//Retorna o numero de titulos
  }

  function mostrarCategorias($arrayValores){
    //Retorna os titulos e/ou nome daquela categoria ou de todas
    $categoria = $arrayValores[0] ?? '';
    $titulo = $arrayValores[1] ?? '';
    $orderBy = $arrayValores[2] ?? '';
    $paginaAtual = $arrayValores[3] ?? '';
    $parametroAval = "";
    $proximasLinhas = 16;

    //Verificando se a variavel de paginação é valida
    if($paginaAtual === '' || !(is_numeric($paginaAtual)) || $paginaAtual === 0 || $paginaAtual === 1 || $paginaAtual < 0)
      $paginaAtual = 0;//Se não for, adiciona a pagina padrão
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

    $select = sqlsrv_query($this->conn, $sql);

    while($registro = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC))
      //Com a instancia do banco, desse mesmo objeto, faz um query, executando o select acima
      // Seria igual a $this->conn->query($sql) as $registro === $bd->query(sql) as $registro 
      $titulos[$registro['id']] = $registro;
      //Criar um array que recebe todo os registros daquele id especifico

    return $titulos ?? '';//retorna o(s) titulo(s) seperado(s) por id
  }

  function mostrarTitulosDaCategoria($arrayValores){
    //Retorna todos os titulos de tal categoria com exceção daquele titulo especificado
    //variaveis utilizadas
    $categoria = $arrayValores[0] ?? '';
    $titulo = $arrayValores[1] ?? '';
    $orderBy = $arrayValores[2] ?? '';
    $paginaAtual = $arrayValores[3] ?? '';

    //sql para o select
    $sql = "SELECT TOP 8
              t.id, t.nome, sinopse, capa, posX, posY, avaliacaoGeral, c.tipo, temporadas, episodios, duracao, temporadaUnica 
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE c.tipo = ? and t.nome <> ?
            ORDER BY avaliacaoGeral desc";

    $registroUsuario = array($categoria, $titulo);
    $select = sqlsrv_query($this->conn, $sql, $registroUsuario);

    //Se houver registros retornados, separa por id
    if($select)
      while($registro = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC))
        //Com a instancia do banco, desse mesmo objeto, faz um query, executando o select acima
        // Seria igual a $this->conn->query($sql) as $registro === $bd->query(sql) as $registro 
        $titulos[$registro['id']] = $registro;
        //Criar um array que recebe todo os registros daquele id especifico

    return $titulos ?? ''; //retorna o(s) titulo(s) seperado(s) por id
  }

  function verificarExistenciaTitulo($arrayValores){
    //Verifica se existe aquele titulo especificado, se existir retorna os registros
    $categoria = $arrayValores[0] ?? '';
    $titulo = $arrayValores[1] ?? '';
    $orderBy = $arrayValores[2] ?? '';
    $paginaAtual = $arrayValores[3] ?? '';
    
    //Verifica se a categoria do GET existe em alguma categoria do banco
    if(!($categoria === 'Filmes' || $categoria === 'Animes' || $categoria === 'Series')){
      //Se não houver essa categoria, retorna para a pagina categorias com GET de erro
      header('Location: ./categorias.php?nao-encontrado=true');
      exit();
    }

    //Verifica se há titulo passado
    if(!($titulo)){
      //Se não houver titulo, retorna para a pagina categorias com GET de erro
      header('Location: ./categorias.php?nao-encontrado=true');
      exit();
    }

    //Sql para o select
    $sql = "SELECT 
              t.id, t.nome, sinopse, capa, posX, posY, avaliacaoGeral, c.tipo, temporadas, episodios, duracao, temporadaUnica
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE t.nome = ? and c.tipo = ?";
    $registroUsuario = array($titulo, $categoria);
    $select = sqlsrv_query($this->conn, $sql, $registroUsuario);

    //Armazena aquele titulo especifico em array
    while($registro = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC))
      //Com a instancia do banco, desse mesmo objeto, faz um query, executando o select acima
      // Seria igual a $this->conn->query($sql) as $registro === $bd->query(sql) as $registro 
      $titulos[$registro['id']] = $registro;
      //Criar um array que recebe todo os registros daquele id especifico

    //Se o select NÃO retornar algo que foi requisitado, retorna para a pagina categorias com GET de erro
    if($titulos)
      foreach($titulos as $id => $tituloRegistro)
        if(!(isset($tituloRegistro['id']))){
          header('Location: ./categorias.php?nao-encontrado=true');
          exit();
        }

    return $titulos ?? ''; //retorna o(s) titulo(s) seperado(s) por id
  }

  function mostrarTiposDeTitulos(){
    //Retorna todos tipos de titulos registrados

    //Sql para o select
    $sql = "SELECT id, tipo
            FROM categoria";
    $select = sqlsrv_query($this->conn, $sql);

    while($registro = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC))
        $categorias[$registro['id']] = $registro;
        
    return $categorias ?? ''; //Retorna os tipos de titulos
  }

  function mostrarTituloEspecifico($idTitulo){
    //Retorna um titulo especifico para ser editado ou apagado
    $idTitulo = $idTitulo ?? '';
    //Verifica se há id do titulo passado
    if(!($idTitulo))
      return false;
    
    //Sql para o select
    $sql = "SELECT 
              t.id, t.nome, sinopse, capa, posX, posY, avaliacaoGeral, c.tipo, temporadas, episodios, duracao, temporadaUnica
            FROM titulo as t INNER JOIN categoria as c
            ON t.categoria = c.id
            WHERE t.id = ?";
    $registroUsuario = array($idTitulo);
    $select = sqlsrv_query($this->conn, $sql, $registroUsuario);

    while($registro = sqlsrv_fetch_array( $select, SQLSRV_FETCH_ASSOC))
        $tituloEspecifico[$registro['id']] = $registro;
        
    return $tituloEspecifico ?? '';//Retorna o titulo especifico
  }

  function atualizarAvaliacaoTitulo($arrayValores){
    //Atualiza a nota daquele titulo especifico
    $idTitulo = $arrayValores[0] ?? '';
    $nomeTitulo = $arrayValores[1] ?? '';

    //Se não houver id do titulo, retorna false
    if(!($idTitulo) && !($nomeTitulo))
      return false;//Se NÃO der certo, retorna false e não executa o que está abaixo

    //Se houver id, começa o update
    //Select retorna a atual nota do titulo
    $sql = "SELECT ROUND(AVG(o.avaliacao), 1) as 'media titulo'
            FROM opniao o
            INNER JOIN titulo t ON o.titulo = t.id
            WHERE t.id = ? 
              or t.nome = ?";
    $registrosUsuario = array($idTitulo, $nomeTitulo);
    $registroAval = sqlsrv_query($this->conn, $sql, $registrosUsuario);
    $registroAval = sqlsrv_fetch_array( $registroAval, SQLSRV_FETCH_ASSOC);
    if($registroAval['media titulo'] === NULL)
      $registroAval['media titulo'] = 0;

    //Update da nota do titulo
    $sql = "UPDATE titulo 
            SET avaliacaoGeral = ?
            WHERE id = ? 
              or nome = ?";
    //Passando os valores para executar o sql
    $registrosUsuario = array($registroAval['media titulo'], $idTitulo, $nomeTitulo);
    $registroAval = sqlsrv_query($this->conn, $sql, $registrosUsuario);
    if($registroAval)
      return true;
  }
}