<?php

class Usuario
{
  //cria objeto Disciplina
  var $conn; //variavel para receber o banco de dados

  function __construct($conn)
  {
    // Essa função será executada quando instanciar o objeto
    $this->conn = $conn; //recebe o banco de dados php my admin
  }


  function criarConta($postCriarConta)
  {
    // Criar conta para usuario
    //Variaveis utilizadaas
    $nome = $postCriarConta['nome'] ?? '';
    if (!($nome)) {
      //Se o usuario não passou nome, randomiza um nome
      $random = rand(1, 99999999);
      $nome = "Usuario{$random}";
    }
    $email = $postCriarConta['email'] ?? '';
    $senha = $postCriarConta['senha'] ?? '';
    //Verificando se há email
    if (!($email))
      return array(false, 'É necessário cadastrar um email!'); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se email já está cadastrado
    $sql = "SELECT id, email
            FROM usuario
            WHERE email = :email";
    //Executando o select
    $select = $this->conn->prepare($sql);
    $select->execute([':email' => $email]);
    $select->fetchAll();
    // $select = sqlsrv_query($this->conn, $sql, $registroUsuario);
    if ($select[0]['email'])
      return array(false, 'Esse endereço de email está indisponível, tente outro.');

    //Preparando o insert para evitar SQL Injection
    $sql = "INSERT INTO 
              usuario (nome, email, senha, avatar, posX, posY, zoom) 
            VALUES 
              (:nome, :email, :senha, :avatar, :posX, :posY, :zoom)";
    //Passando os valores para executar o sql
    $registroUsuario = array(
      ':nome' => $nome,
      ':email' => $email,
      ':senha' => password_hash($senha, PASSWORD_DEFAULT),
      ':avatar' => "user.png",
      ':posX' => 'center',
      ':posY' => 'center',
      ':zoom' => 'cover'
    );
    //Executando o insert
    $insert = $this->conn->prepare($sql);
    $insert->execute($registroUsuario);
    //Verificando se o insert deu certo
    if (!($insert))
      return array(false, 'Houve um erro no cadastro dos dados, tente novamente.'); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Retornado id o usuario
    $sql = "SELECT id 
            FROM usuario 
            WHERE email = :email";
    $select = $this->conn->prepare($sql);
    $select->execute([':email' => $email]);
    $registro = $select->fetchAll();

    $_SESSION['nome'] = $nome;
    $_SESSION['id'] = $registro[0]['id'];
    $_SESSION['avatar'] = "user.png";
    $_SESSION['posX'] = 'center';
    $_SESSION['posY'] = 'center';
    $_SESSION['zoom'] = 'cover';

    //Verificando se há id armazenado em $_SESSION
    if (!(isset($_SESSION['id']))) {
      return array(false, 'Houve um erro no cadastro dos dados, tente novamente.'); //Se NÃO der certo, retorna false e não executa o que está abaixo
    }

    return array(true);
  }

  function login($postLogin)
  {
    // Entrar em um conta existente do usuario
    //Variaveis utilizadas
    $email = $postLogin['email'] ?? '';
    $senhaUsuario = $postLogin['senha'] ?? '';

    //Recuperando o registro com email do usuario
    $sql = "SELECT 
              id, nome, senha, avatar, posX, posY, zoom
            FROM usuario 
            WHERE email = :email";
    $select = $this->conn->prepare($sql);
    $select->execute([':email' => $email]); //Executa a consulta, comparando com o email passado
    $registro = $select->fetchAll(); //Retorna o usuario compativel com o email
    //Verificando há usuario com aquele email
    if (!($registro[0]['email']))
      return array(false, 'Email e/ou senha inválidos'); //Se NÃO der certo, retorna false e não executa o que está abaixo

    //Verificando se a senha passada pelo usuario é igual a senha da conta armazenada no banco
    if (!(password_verify($senhaUsuario, $registro[0]['senha']))) {
      // (password_verify) verifica se a senha passado pelo usuario é compativel com a senha criptografada guardada
      return array(false, 'Email e/ou senha inválidos'); //Se NÃO der certo, retorna false e não executa o que está abaixo
    }

    //Se a senha for compativel com a do email, adiciona os dados no $_SESSION
    //$_SESSION;Usado para armazenar dados
    $_SESSION['nome'] = $registro[0]['nome'];
    $_SESSION['id'] = $registro[0]['id'];
    $_SESSION['avatar'] = $registro[0]['avatar'];
    $_SESSION['posX'] = $registro[0]['posX'];
    $_SESSION['posY'] = $registro[0]['posY'];
    $_SESSION['zoom'] = $registro[0]['zoom'];

    return array(true);
  }

  function mostrarConta($idUsuario)
  {
    // Mostra todas as informações da conta
    $idUsuario = $idUsuario ?? '';
    if (!($idUsuario))
      return array(false, 'Não há usuario registrado');

    $sql = "SELECT 
              id, nome, email, senha, avatar, posX, posY, zoom
            FROM usuario
            WHERE id = :id";
    $select = $this->conn->prepare($sql);
    $select->execute([':id' => $idUsuario]);
    $registro = $select->fetchAll();

    return $registro[0]['id'] ?? array(false, 'Usuario não encontrado');
  }

  function editarConta($idUsuario, $dadosPost)
  {
    // Edita dados da conta do usuario

    //Variaveis utilizadas
    $idUsuario = $idUsuario ?? '';
    $novoAvatar = $_FILES['novo-avatar']['name'] ?? '';
    $novoNome = $dadosPost['novo-nome'] ?? '';
    $novoEmail = $dadosPost['novo-email'] ?? '';
    $novoPosX = $dadosPost['avatar-posX'] ?? '';
    $novoPosY = $dadosPost['avatar-posY'] ?? '';
    if (!(is_numeric($novoPosX) && is_numeric($novoPosX)))
      return array(false, "Posição do avatar inválida.");
    $novoZoom = $dadosPost['novo-zoom'] ?? '';
    if (!(is_numeric($novoZoom) || $novoZoom === 'cover'))
      return array(false, "Zoom do avatar inválido.");
    $senhaUsuario = $dadosPost['confirmando-senha'] ?? '';

    //Verificando se há id do usuario
    if (!($idUsuario))
      return array(false, 'Houve um erro ao atualizar o perfil, tente novamente.');

    //Select retornando a conta do id
    $sql = "SELECT id, senha, avatar
            FROM usuario
            WHERE id = :";
    $select = sqlsrv_query($this->conn, $sql, array($idUsuario));
    $registroConta = sqlsrv_fetch_array($select, SQLSRV_FETCH_ASSOC);
    //Verificando se a senha é compativel a da conta sendo editada
    if (!(password_verify($senhaUsuario, $registroConta['senha'])))
      return array(false, 'Senha incorreta.');

    $avatarAtual = $registroConta['avatar'];
    //Verificando se usuario inseriu imagem
    if ($novoAvatar) {
      //Variaveis sobre imagem
      $nomeTemporarioArquivo = $_FILES['novo-avatar']['tmp_name'];
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

      //Verificando se usuario já colocou a imagem
      if ($avatarAtual !== $novoAvatar) {
        //Se a extensão for valida, armazena tal imagem com nome aleatorio na pasta
        $random = rand(1, 99999999);
        $novoAvatar = $random . $ext;
        move_uploaded_file($nomeTemporarioArquivo, $pastaDeArquivos . $novoAvatar);
      } else {
        $novoAvatar = $avatarAtual;
      }
    } else {
      $novoAvatar = $avatarAtual;
    }

    //Update da conta
    $sql = "UPDATE usuario
            SET nome = ?,
              email = ?,
              avatar = ?,
              posX = ?,
              posY = ?,
              zoom = ?
            WHERE id = :";
    $registroUsuario = array(
      $novoNome,
      $novoEmail,
      $novoAvatar,
      $novoPosX,
      $novoPosY,
      $novoZoom,
      $idUsuario
    );
    $select = sqlsrv_query($this->conn, $sql, $registroUsuario);
    //Verificando se o update deu certo
    if ($select) {
      $_SESSION['nome'] = $novoNome;
      $_SESSION['avatar'] = $novoAvatar;
      $_SESSION['posX'] = $novoPosX;
      $_SESSION['posY'] = $novoPosY;
      $_SESSION['zoom'] = $novoZoom;

      return array(true, 'Perfil atualizado com sucesso!');
    }
  }

  function avaliar($dadosPost, $usuario, $titulo)
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
              (?, ?, ?, ?, ?)";


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

  function apagarComentario($idComentario, $usuario, $idtitulo)
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

  function editarComentario($dadosPost)
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
            SET avaliacao = ?,
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

  function mostrarComentarios($idTitulo, $pagina)
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
