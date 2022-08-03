<h2>Create</h2>


<form action="/user/create" method="POST">
  <div>
    <input type="text" name="name">
    <?php echo getFlash('name') ?>
  </div>
  <div>
    <input type="email" name="email">
    <?php echo getFlash('email') ?>
  </div>
  <div>
    <input type="password" name="password">
    <?php echo getFlash('password') ?>
  </div>
  <div>
    <button type="submit">Criar</button>
  </div>
</form>