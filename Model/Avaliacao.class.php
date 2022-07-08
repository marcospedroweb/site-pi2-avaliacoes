<?php
require_once __DIR__ . '/Model.class.php';

class Avaliacao extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->tabela = 'avaliacao';
  }


  public function criar(array $dados): bool
  {
    // Registrar o comentario e/ou nota para o titulo
    //Variaveis utilizadas
    $dadosPost = $dadosPost ?? '';
    $tituloNome = $titulo ?? '';
    $usuario = $usuario ?? '';
    //Verifica há id passado
    if (!($usuario))
      return array(false, "Houve um erro ao postar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Se tiver um id armazenado, começa a preparação para o insert
    //Recuperando o id do titulo
    $sql = "SELECT t.id, c.tipo
            FROM titulo t 
            INNER JOIN categoria c
            ON t.categoria = c.id
            WHERE t.nome = :";
    $select = sqlsrv_query($this->conn, $sql, array($tituloNome));
    $registroTitulo = sqlsrv_fetch_array($select, SQLSRV_FETCH_ASSOC);
    //Verificando se há id do titulo
    if (!(isset($registroTitulo['id'])))
      return array(false, "Houve um erro ao postar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se há comentario duplicado
    $sql = "SELECT count(usuario) as 'qtd de Comentarios'
            FROM 
              opniao
            WHERE
              titulo = ?
              and usuario = :";
    $select = sqlsrv_query($this->conn, $sql, array($registroTitulo['id'], $usuario)); //Executa a consulta, comparando com o email 
    if ($select) {
      $comentarioDuplicado = sqlsrv_fetch_array($select, SQLSRV_FETCH_ASSOC); //Retorna o usuario compativel com o email
      //Se houver um comentario comentado pelo mesmo usuario, impede adicionar outro comentario
      if ($comentarioDuplicado['qtd de Comentarios'] > 0)
        //Se for maior que 0, o usuario já comentou esse titulo
        return array(false, "Você já comentou nesse titulo");
    }

    //Se existir o titulo e o comentario não é duplicado, começa o insert do comentario
    $comentario = $dadosPost['comentar-textarea'] ?? ''; //text area comentario
    if (strlen($comentario) > 1250)
      return array(false, 'Quantidade de caracteres permitidos excedido');
    $avaliacao = $dadosPost['avaliacao-usuario'] ?? ''; // nota do usuario
    $dataComentario = (new DateTime())->getTimestamp(); // timestamp
    $sql = "INSERT INTO opniao 
              (titulo, usuario, avaliacao, comentario, dataPublicado) 
            VALUES 
              (:, :, :, :, ?)";


    //Passando os valores para executar o sql
    $registroUsuario = array(
      $registroTitulo['id'],
      $usuario,
      $avaliacao,
      $comentario,
      $dataComentario
    );
    $insert = sqlsrv_query($this->conn, $sql, $registroUsuario); //Executa a consulta, comparando com o email passado
    //Verificando se o insert deu certo
    if (!($insert))
      return array(false, "Houve um erro ao postar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Atualizando a nota daquele titulo
    $success = (new Categoria($this->conn))->atualizarAvaliacaoTitulo(array($registroTitulo['id']));
    if ($success)
      return array(true, "Comentario postado com sucesso!");
    else
      return array(false, "Houve um erro ao postar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo
  }

  public function atualizar(array $dados): bool
  {
    //Edita um comentario existente
    //Variaveis utilizadas
    $avaliacaoUsuario = $dadosPost['editar-avaliacao'] ?? '';
    $textareaUsuario = $dadosPost['editar-comentario-textarea'] ?? '';
    $idComentario = $dadosPost['id-comentario'] ?? '';
    $idUsuario = $dadosPost['editar-id-usuario'] ?? '';
    $nomeTitulo = $dadosPost['editar-titulo'] ?? '';

    //Verificando se o id do usuario é o mesmo em opniao
    $sql = "SELECT o.id, titulo, usuario
            FROM opniao o
            INNER JOIN titulo t
            ON o.titulo = t.id
            WHERE o.id = ?
              and usuario = ? 
              and t.nome = :";
    //Passando os valores para executar o sql
    $registroUsuario = array($idComentario, $idUsuario, $nomeTitulo);
    $select = sqlsrv_query($this->conn, $sql, $registroUsuario);
    $registroOpniao = sqlsrv_fetch_array($select, SQLSRV_FETCH_ASSOC);
    //Se não houver id, não permite atualizar o comentario
    if (!(isset($registroOpniao['id'])))
      return array(false, "Houve um erro ao editar o comentario, tente novamente.");; //Se NÃO der certo, retorna false e não executa o que está abaixo
    /*
      Verificando se o id do usuario é o mesmo do id de $_SESSION['id'], 
      Verificando se avaliação é valida,
      Verificando de há nome do titulo
    */

    if (!(intval($idUsuario) === $registroOpniao['usuario'] && is_numeric($avaliacaoUsuario) && ($avaliacaoUsuario >= 0.5 && $avaliacaoUsuario <= 5) && $nomeTitulo))
      return false; //Se NÃO der certo, retorna false e não executa o que está abaixo
    //Sql para update
    $sql = "UPDATE o
            SET avaliacao = :,
              comentario = ?
            FROM opniao o
            INNER JOIN titulo t
            ON o.titulo = t.id
            WHERE o.id = ?
              and o.usuario = ?
              and t.nome = :";

    //Passando os valores para executar o sql
    $registroUsuario = array(
      $avaliacaoUsuario,
      $textareaUsuario,
      $idComentario,
      $idUsuario,
      $nomeTitulo,
    );
    $update = sqlsrv_query($this->conn, $sql, $registroUsuario);
    //Verificando se o update deu certo
    if (!($update))
      return array(false, "Houve um erro ao editar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Atualizando a nota daquele titulo
    $success = (new Categoria($this->conn))->atualizarAvaliacaoTitulo(array($registroOpniao['titulo']));
    if ($success)
      return array(true, "Comentario atualizado com sucesso!");
    else
      return array(false, "Houve um erro ao editar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo
  }

  public function apagar(array $dados): bool
  {
    //Apaga um comentario existente
    //Variaveis utilizadas
    $idComentario = intval($idComentario) ?? '';
    $idtitulo = intval($idtitulo) ?? '';
    $idUsuarioComentario = intval($usuario) ?? '';
    $idSessao = $_SESSION['id'] ?? '';

    //Verifica se os valores passados são iguais no banco
    if (!(($idUsuarioComentario === $idSessao) || $idSessao === 3))
      return array(false, 'Houve um erro ao apagar o comentario.'); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se é o admin apagando o comentario
    if ($idSessao === 3) {
      $sql = "SELECT usuario
              FROM opniao
              WHERE id = :";
      $select = sqlsrv_query($this->conn, $sql, array($idComentario));
      $registroOpniao = sqlsrv_fetch_array($select, SQLSRV_FETCH_ASSOC);
      if (!($select))
        return array(false, 'Houve um erro ao apagar o comentario.');

      $idUsuarioComentario = $registroOpniao['usuario'];
    }

    //Se for igual, faz o delete daquela opnião
    $sql = "DELETE FROM opniao 
            WHERE id = ? 
              and titulo = ?
              and usuario = :";
    //Passando os valores para executar o sql
    $registroUsuario = array($idComentario, $idtitulo, $idUsuarioComentario);
    $registroAval = sqlsrv_query($this->conn, $sql, $registroUsuario);
    //Verificando se o delete deu certo
    if (!($registroAval))
      return array(false, "Houve um erro ao apagar o comentario, tente novamente.");; //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Atualizando a nota daquele titulo
    $success = (new Categoria($this->conn))->atualizarAvaliacaoTitulo(array($idtitulo));
    if ($success || $success === NULL)
      return array(true, "Comentario apagado com sucesso!");
    else
      return array(false, "Houve um erro ao apagar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo*/
  }
  public function listar(array $dados): bool
  {
    //Retorna todos os dados de cada comentario

    $idTitulo = $idTitulo ?? '';
    $paginaAtual = $pagina ?? '';
    $proximasLinhas = 8;
    //Verificando se o há id do titulo
    if (!($idTitulo)) {
      header("Location: ./categorias.php");
      exit();
    }

    //Verificando se a variavel de paginação é valida
    if ($paginaAtual === '' || !(is_numeric($paginaAtual)) || $paginaAtual === 0 || $paginaAtual === 1 || $paginaAtual < 0)
      $paginaAtual = 0; //Se não for, adiciona a pagina padrão
    else if ($paginaAtual !== 0 && $paginaAtual !== 1)
      $paginaAtual = ($paginaAtual - 1) * 8;

    //sql para retornar os comentarios
    $sql = "SELECT 
              o.id, o.usuario, t.nome, u.nome, u.avatar, u.posX, u.posY, u.zoom, avaliacao, comentario, dataPublicado 
            FROM 
              opniao o
            INNER JOIN 
              titulo t ON t.id = o.titulo
            INNER JOIN 
              usuario u ON u.id = o.usuario
            INNER JOIN 
              categoria c ON c.id = t.categoria
            WHERE 
              t.id = ?
            ORDER BY avaliacao desc, dataPublicado desc
            OFFSET {$paginaAtual} ROWS
            FETCH NEXT {$proximasLinhas} ROWS ONLY";

    $registroUsuario = array($idTitulo);
    $select = sqlsrv_query($this->conn, $sql, $registroUsuario);

    //Se o select trazer algum comentario, guarda-os em um array
    if ($select)
      while ($registro = sqlsrv_fetch_array($select, SQLSRV_FETCH_ASSOC))
        $comentarios[$registro[0]['id']] = $registro;

    return $comentarios ?? '';
  }

  function atualizarAvaliacaoTitulo($arrayValores)
  {
    //Atualiza a nota daquele titulo especifico
    $idTitulo = $arrayValores[0] ?? '';
    $nomeTitulo = $arrayValores[1] ?? '';

    //Se não houver id do titulo, retorna false
    if (!($idTitulo) && !($nomeTitulo))
      return false; //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Se houver id, começa o update
    //Select retorna a atual nota do titulo
    $sql = "SELECT ROUND(AVG(o.avaliacao), 1) as 'media titulo'
            FROM opniao o
            INNER JOIN titulo t ON o.titulo = t.id
            WHERE t.id = ? 
              or t.nome = ?";
    $registrosUsuario = array($idTitulo, $nomeTitulo);
    $registroAval = sqlsrv_query($this->conn, $sql, $registrosUsuario);
    $registroAval = sqlsrv_fetch_array($registroAval, SQLSRV_FETCH_ASSOC);
    if ($registroAval['media titulo'] === NULL)
      $registroAval['media titulo'] = 0;

    //Update da nota do titulo
    $sql = "UPDATE titulo 
            SET avaliacaoGeral = ?
            WHERE id = ? 
              or nome = ?";
    //Passando os valores para executar o sql
    $registrosUsuario = array($registroAval['media titulo'], $idTitulo, $nomeTitulo);
    $registroAval = sqlsrv_query($this->conn, $sql, $registrosUsuario);
    if ($registroAval)
      return true;
  }

  function contarComentariosRegistrados($idTitulo)
  {
    //Retorna a quantidade de comentarios disponiveis

    $idTitulo = $idTitulo ?? '';
    if (!($idTitulo))
      return array(false, 'Titulo indisponível.');

    $sql = "SELECT count(*) as 'qtdComentarios'
            FROM opniao
            WHERE titulo = :";
    $select = sqlsrv_query($this->conn, $sql, array($idTitulo));
    if (!($select))
      return array(false, 'Houve um erro ao buscar a quantidade de comentarios.');

    $registroOpniao = sqlsrv_fetch_array($select, SQLSRV_FETCH_ASSOC);

    return array(true, $registroOpniao['qtdComentarios']);
  }
}
