<?php $this->layout('master', ['title' => $title]) ?>

<h2>Create</h2>

<?php echo getFlash('message') ?>
<form action="/user/create" method="POST">

  <?php echo getCsrf(); ?>

  <div>
    <input type="text" name="name" value="<?php echo getOld('name') ?>">
    <?php echo getFlash('name') ?>
  </div>
  <div>
    <input type="email" name="email" value="<?php echo getOld('email') ?>">
    <?php echo getFlash('email') ?>
  </div>
  <div>
    <input type="password" name="password" value="<?php echo getOld('password') ?>">
    <?php echo getFlash('password') ?>
  </div>
  <div>
    <button type="submit">Criar</button>
  </div>
</form>