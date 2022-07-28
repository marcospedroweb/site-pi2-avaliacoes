<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
</head>

<body>
  <div class="container">
    <?php
    //Recebendo o arquivo que será "imprimido" de acordo com a URI
    require_once VIEWS . $view;
    ?>
  </div>
</body>

</html>