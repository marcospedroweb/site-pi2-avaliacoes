<?php
require_once __DIR__ . '/Model.class.php';

class Avaliacao extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->tabela = 'avaliacao';
  }


  public function criar(array $dados): array
  {
    // Registrar o comentario e/ou nota para o titulo
    //Variaveis utilizadas
    $titulo_nome = $dados['titulo_nome'] ?? '';
    $usuario_id = $dados['usuario_id'] ?? '';
    //Verifica há id passado
    if (!($usuario_id))
      return array(false, "Houve um erro ao postar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Se tiver um id armazenado, começa a preparação para o insert
    //Recuperando o id do titulo
    $sql = "SELECT t.id, c.tipo
            FROM titulo t 
            INNER JOIN categoria c
            ON t.categoria = c.id
            WHERE t.nome = :nome";
    $select = $this->prepare($sql);
    if ($select->execute([':nome' => $titulo_nome]))
      $registroTitulo = $select->fetchAll()[0];
    //Verificando se há id do titulo
    if (!(isset($registroTitulo['id'])))
      return array(false, "Houve um erro ao postar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se há comentario duplicado
    $sql = "SELECT count(usuario) as 'qtd de Comentarios'
            FROM 
              avaliacao
            WHERE
              titulo_id = :titulo_id
              and usuario_id = :usuario_id";
    $select = $this->prepare($sql);
    $resultado = $select->execute([
      ':titulo_id' => $registroTitulo['id'],
      ':usuario_id' => $usuario_id
    ]);

    if ($resultado) {
      $comentarioDuplicado = $select->fetchAll()[0]; //Retorna o usuario compativel com o email
      //Se houver um comentario comentado pelo mesmo usuario, impede adicionar outro comentario
      if ($comentarioDuplicado['qtd de Comentarios'] > 0)
        //Se for maior que 0, o usuario já comentou esse titulo
        return array(false, "Você já comentou nesse titulo");
    }

    //Se existir o titulo e o comentario não é duplicado, começa o insert do comentario
    $comentario = $dados['comentar-textarea'] ?? ''; //text area comentario
    if (strlen($comentario) > 1250)
      return array(false, 'Quantidade de caracteres permitidos excedido');
    $avaliacao = $dados['avaliacao-usuario'] ?? ''; // nota do usuario
    $dataComentario = (new DateTime())->getTimestamp(); // timestamp
    $sql = "INSERT INTO avaliacao 
              (titulo_id, usuario_id, avaliacao, comentario, dataPublicado) 
            VALUES 
              (:titulo_id, :usuario_id, :avaliacao, :comentario, :dataPublicado)";

    $insert = $this->prepare($sql);
    $resultado = $insert->execute([
      ':titulo_id' => $registroTitulo['id'],
      ':usuario_id' => $usuario_id,
      ':avaliacao' => $avaliacao,
      ':comentario' => $comentario,
      ':dataPublicado' => $dataComentario
    ]); //Executa a consulta, comparando com o email passado
    //Verificando se o insert deu certo
    if (!($resultado))
      return array(false, "Houve um erro ao postar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Atualizando a nota daquele titulo
    $success = $this->atualizarAvaliacaoTitulo(array($registroTitulo['id']));
    if ($success)
      return array(true, "Comentario postado com sucesso!");
    else
      return array(false, "Houve um erro ao atualizar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo
  }

  public function atualizar(array $dados): array
  {
    //Edita um comentario existente
    //Variaveis utilizadas
    $notaUsuario = $dados['editar-avaliacao'] ?? '';
    $textareaUsuario = $dados['editar-comentario-textarea'] ?? '';
    $comentario_id = $dados['id-comentario'] ?? '';
    $usuario_id = $dados['editar-id-usuario'] ?? '';
    $titulo_nome = $dados['editar-titulo'] ?? '';

    //Verificando se o id do usuario é o mesmo em avaliacao
    $sql = "SELECT a.id, titulo_id, usuario_id
            FROM avaliacao a
            INNER JOIN titulo t
            ON a.titulo = t.id
            WHERE a.id = :id
              and usuario_id = :usuario_id 
              and t.nome = :titulo_nome";
    $select = $this->prepare($sql);
    $select->execute([
      ':id' => $comentario_id,
      ':usuario_id' => $usuario_id,
      ':titulo_nome' => $titulo_nome
    ]);
    $avaliacao = $select->fetchAll()[0];
    //Se não houver id, não permite atualizar o comentario
    if (!(isset($avaliacao['id'])))
      return array(false, "Houve um erro ao editar o comentario, tente novamente.");; //Se NÃO der certo, retorna false e não executa o que está abaixo
    /*
      Verificando se o id do usuario é o mesmo do id de $_SESSION['id'], 
      Verificando se avaliação é valida,
      Verificando de há nome do titulo
    */

    if (!(intval($usuario_id) === $avaliacao['usuario'] && is_numeric($notaUsuario) && ($notaUsuario >= 0.5 && $notaUsuario <= 5) && $titulo_nome))
      return false; //Se NÃO der certo, retorna false e não executa o que está abaixo
    //Sql para update
    $sql = "UPDATE a
            SET nota = :nota,
              comentario = :comentario
            FROM avaliacao a
            INNER JOIN titulo t
            ON a.titulo = t.id
            WHERE a.id = :comentario_id
              and a.usuario_id = :usuario_i
              and t.nome = :titulo_nome";

    $update = $this->prepare($sql);
    $resultado = $update->execute([
      ':nota' => $notaUsuario,
      ':comentario' => $textareaUsuario,
      ':comentario_id' => $comentario_id,
      ':usuario_id' => $usuario_id,
      ':titulo_nome' => $titulo_nome,
    ]);
    //Verificando se o update deu certo
    if (!($resultado))
      return array(false, "Houve um erro ao editar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Atualizando a nota daquele titulo
    $success = $this->atualizarAvaliacaoTitulo(array($avaliacao['titulo']));
    if ($success)
      return array(true, "Comentario atualizado com sucesso!");
    else
      return array(false, "Houve um erro ao atualizar a nota do titulo, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo
  }

  public function apagar(array $dados): array
  {
    //Apaga um comentario existente
    //Variaveis utilizadas
    $comentario_id = $dados['comentario_id'] ?? '';
    $titulo_id = $dados['titulo_id'] ?? '';
    $comentario_usuario_id = $dados['usuario_id'] ?? '';
    $sessao_id = $_SESSION['id'] ?? '';

    //Verifica se os valores passados são iguais no banco
    if (!(($comentario_usuario_id === $sessao_id) || $sessao_id === 3))
      return array(false, 'Houve um erro ao apagar o comentaria.'); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se é o admin apagando o comentario
    if ($sessao_id === 3) {
      $sql = "SELECT usuario
              FROM avaliacao
              WHERE id = :id";
      $select = $this->prepare($sql);
      $resultado = $select->execute([':id' => $comentario_id]);
      $avaliacao = $select->fetchAll()[0];
      if (!($resultado))
        return array(false, 'Houve um erro ao apagar o comentaria.');

      $comentario_usuario_id = $avaliacao['usuario'];
    }

    //Se for igual, faz o delete daquela opnião
    $sql = "DELETE FROM avaliacao 
            WHERE id = :id 
              and titulo = :titulo_id
              and usuario = :usuario_id";
    //Passando os valores para executar o sql
    $delete = $this->prepare($sql);
    $resultado = $delete->execute([
      ':id' => $comentario_id,
      ':titulo_id' => $titulo_id,
      ':usuario_id' => $comentario_usuario_id
    ]);

    if (!($resultado))
      return array(false, "Houve um erro ao apagar o comentario, tente novamente.");; //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Atualizando a nota daquele titulo
    $success = $this->atualizarAvaliacaoTitulo(array($titulo_id));
    if ($success || $success === NULL)
      return array(true, "Comentario apagado com sucesso!");
    else
      return array(false, "Houve um erro ao atualizar o comentario, tente novamente."); //Se NÃO der certo, retorna false e não executa o que está abaixo*/
  }

  public function listar(array $dados): array
  {
    //Retorna todos os dados de cada comentario

    $titulo_id = $titulo_id ?? '';
    $paginaAtual = $pagina ?? '';
    $proximasLinhas = 8;
    //Verificando se o há id do titulo
    if (!($titulo_id)) {
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
              a.id, a.usuario_id, t.nome, u.nome, u.avatar, u.posX, u.posY, u.zoom, avaliacao, comentario, dataPublicado 
            FROM 
              avaliacao a
            INNER JOIN 
              titulo t ON t.id = a.titulo
            INNER JOIN 
              usuario u ON u.id = a.usuario_id
            INNER JOIN 
              categoria c ON c.id = t.categoria
            WHERE 
              t.id = :titulo_id
            ORDER BY avaliacao desc, dataPublicado desc
            OFFSET {$paginaAtual} ROWS
            FETCH NEXT {$proximasLinhas} ROWS ONLY";

    $select = $this->prepare($sql);
    $resultado = $select->execute([':titulo_id' => $titulo_id]);

    //Se o select trazer algum comentario, guarda-os em um array
    if ($resultado)
      $comentarios = $select->fetchAll();

    return $comentarios ?? '';
  }

  function atualizarAvaliacaoTitulo($arrayValores)
  {
    //Atualiza a nota daquele titulo especifico
    $titulo_id = $arrayValores[0] ?? '';
    $titulo_nome = $arrayValores[1] ?? '';

    //Se não houver id do titulo, retorna false
    if (!($titulo_id) && !($titulo_nome))
      return false; //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Se houver id, começa o update
    //Select retorna a atual nota do titulo
    $sql = "SELECT ROUND(AVG(a.avaliacao), 1) as 'media titulo'
            FROM avaliacao a
            INNER JOIN titulo t ON a.titulo = t.id
            WHERE t.id = :titulo_id
              or t.nome = :titulo_nome";
    $select = $this->prepare($sql);
    $select->execute([
      ':titulo_id' => $titulo_id,
      ':titulo_nome' => $titulo_nome
    ]);
    $avaliacoes = $select->fetchAll()[0];
    if ($avaliacoes['media titulo'] === NULL)
      $avaliacoes['media titulo'] = 0;

    //Update da nota do titulo
    $sql = "UPDATE titulo 
            SET nota = :nota
            WHERE id = :titulo_id 
              or nome = :titulo_nome";
    //Passando os valores para executar o sql
    $update = $this->prepare($sql);
    $resultado = $update->execute([
      ':nota' => $avaliacoes['media titulo'],
      ':titulo_id' => $titulo_id,
      ':titulo_nome' => $titulo_nome
    ]);
    if ($resultado)
      return true;
  }

  function contarComentariosRegistrados($titulo_id)
  {
    //Retorna a quantidade de comentarios disponiveis

    $titulo_id = $titulo_id ?? '';
    if (!($titulo_id))
      return array(false, 'Titulo indisponível.');

    $sql = "SELECT count(*) as 'qtdComentarios'
            FROM avaliacao
            WHERE titulo_id = :titulo_id";
    $select = $this->prepare($sql);
    $resultado = $select->execute(['titulo_id' => $titulo_id]);
    if (!($resultado))
      return array(false, 'Houve um erro ao buscar a quantidade de comentarios.');

    $avaliacao = $select->fetchAll()[0];

    return array(true, $avaliacao['qtdComentarios']);
  }
}
