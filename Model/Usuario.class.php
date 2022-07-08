<?php
require_once __DIR__ . '/Model.class.php';

class Usuario extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->tabela = 'usuario';
  }

  public function criar(array $dados): bool
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
  public function atualizar(array $dados): bool
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
            WHERE id = :id";
    $select = $this->conn->prepare($sql);
    $select->execute([':id' => $idUsuario]);
    $registroConta = $select->fetchAll();
    //Verificando se a senha é compativel a da conta sendo editada
    if (!(password_verify($senhaUsuario, $registroConta[0]['senha'])))
      return array(false, 'Email e/ou Senha incorreta.');

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
            SET nome = :nome,
              email = :email,
              avatar = :avatar,
              posX = :posX,
              posY = :posY,
              zoom = :zoom
            WHERE id = :id";
    $registroUsuario = array(
      ':nome' => $novoNome,
      ':email' => $novoEmail,
      ':avatar' => $novoAvatar,
      ':posX' => $novoPosX,
      ':posY' => $novoPosY,
      ':zoom' => $novoZoom,
      ':id' => $idUsuario
    );
    $select = $this->conn->prepare($sql);
    $resultSelect = $select->execute($registroUsuario);
    //Verificando se o update deu certo
    if ($resultSelect) {
      $_SESSION['nome'] = $novoNome;
      $_SESSION['avatar'] = $novoAvatar;
      $_SESSION['posX'] = $novoPosX;
      $_SESSION['posY'] = $novoPosY;
      $_SESSION['zoom'] = $novoZoom;

      return array(true, 'Perfil atualizado com sucesso!');
    } else
      return array(false, 'Houve um erro ao atualizar os dados, tente novamente.');
  }

  function apagar(array $dados): bool
  {
    return array('resultado');
  }

  function listar(array $dados): bool
  {
    return array('resultado');
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
}
