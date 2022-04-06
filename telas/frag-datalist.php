<template id="listtemplate"> 
    <?php 
    // loop para imprimir cada option com os titulos
    foreach($registrosDatalist as $id => $titulo){
    ?>
        <option value='<?php echo $titulo['nome']?>' label='Em <?php echo $titulo['tipo']?>'>
    <?php 
    }
    ?>
</template>
<datalist id="opcoes-datalist">
</datalist>