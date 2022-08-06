<?php $this->layout('master', ['title' => $title]) ?>

<h2>Login</h2>
<?php echo getFlash('message') ?>

<?php if (logged()) return redirect('/') ?>

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