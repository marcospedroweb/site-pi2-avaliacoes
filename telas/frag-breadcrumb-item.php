<?php
$tituloNome = $tituloNome ?? '';
//Se não tiver categoria especifica, mostra todos os titulos de todas categorias
if($categoria !== 'Filmes' && $categoria !== 'Animes' && $categoria !== 'Series'){
?>
  <li class='breadcrumb-item' aria-current='page'>
    <a href='./categorias.php' class='link-primary'>Categorias</a>
  </li>
<?php 
}else if($tituloNome){
?>
<li class='breadcrumb-item'>
  <a href='./categorias.php' class='link-secondary'>Categorias</a>
</li>
<li class='breadcrumb-item' aria-current='page'>
  <a href='./categorias.php?categoria=<?php echo $categoria?>' class='link-secondary'><?php echo $categoria?></a>
</li>
<li class='breadcrumb-item' aria-current='page'>
  <a href='./categoria-escolhida.php?nome=<?php echo $tituloNome?>&categoria=<?php echo $categoria?>' class='link-primary'><?php echo $tituloNome?></a>
</li>
<?php
}else{
  //Se tiver categoria especifica, mostra todos os titulos daquela categoria
?>
  <li class='breadcrumb-item'>
    <a href='./categorias.php' class='link-secondary'>Categorias</a>
  </li>
  <li class='breadcrumb-item' aria-current='page'>
    <a href='./categorias.php?categoria=<?php echo $categoria?>' class='link-primary'><?php echo $categoria?></a>
  </li>
<?php 
}
?>
          