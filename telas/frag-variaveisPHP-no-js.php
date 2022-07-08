<?php
// Passando o $_SESSION para o JS

//Passando variaveis necessarias para mostrar o alert de não logado ou alert de deixe sua nota
$idUsuario = $_SESSION['id'] ?? '';
//Mensagem de erro
$erro = $_GET['erro'] ?? '';
//Mensagem de sucesso
$sucesso = $_GET['sucesso'] ?? '';
//Titulo escolhido
$tituloEscolhido = $tituloNome ?? '';
//Verificando se o comentario foi postado
$comentarioPostado = $_GET['comentarioPostado'] ?? '';
//Verificando se o usuario logado já comentou naquele titulo
$usuarioJaComentou = $_GET['usuarioJaComentou'] ?? '';
//Verificando se o usuario logado já comentou naquele titulo
$temporadaUnica = $_GET['temporadaUnica'] ?? '';
//Verificando se o modo admin está ligado
$modoAdmin = $_SESSION['modo-admin'] ?? '';
//Verificando se o usuario está criando um titulo
$tituloCriar = $criarTitulo ?? '';
//Verificando se o usuario está editando um titulo
$tituloEditar = $editarTitulo ?? '';
//Verificando se o usuario está apagando um titulo
$tituloApagar = $apagarTitulo ?? '';
?>
<script defer>
  let variaveisPHP = {};
  variaveisPHP[decodeURIComponent('id')] = decodeURIComponent(parseInt(<?php echo $idUsuario ?>));
  variaveisPHP[decodeURIComponent('erro')] = decodeURIComponent(<?php echo $erro ?>);
  variaveisPHP[decodeURIComponent('sucesso')] = decodeURIComponent(<?php echo $sucesso ?>);
  variaveisPHP[decodeURIComponent('tituloEscolhido')] = decodeURIComponent("<?php echo $tituloEscolhido ?>");
  variaveisPHP[decodeURIComponent('comentarioPostado')] = decodeURIComponent(<?php echo $comentarioPostado ?>);
  variaveisPHP[decodeURIComponent('usuarioJaComentou')] = decodeURIComponent(<?php echo $usuarioJaComentou ?>);
  variaveisPHP[decodeURIComponent('temporadaUnica')] = decodeURIComponent('<?php echo $temporadaUnica ?>');
  variaveisPHP[decodeURIComponent('modo-admin')] = decodeURIComponent('<?php echo $modoAdmin ?>');
  variaveisPHP[decodeURIComponent('criar-titulo')] = decodeURIComponent('<?php echo $tituloCriar ?>');
  variaveisPHP[decodeURIComponent('editar-titulo')] = decodeURIComponent('<?php echo $tituloEditar ?>');
  variaveisPHP[decodeURIComponent('apagar-titulo')] = decodeURIComponent('<?php echo $tituloApagar ?>');
</script>
