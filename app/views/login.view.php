<h2>Login</h2>
<?php echo getFlash('message') ?>

<form action="/login" method="POST">
  <div>
    <input type="email" name="email" value="email@email.com">
  </div>
  <div>
    <input type="password" name="password" value="123">
  </div>
  <div>
    <button type="submit">Login</button>
  </div>

</form>