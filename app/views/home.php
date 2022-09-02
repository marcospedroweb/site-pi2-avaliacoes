<?php $this->layout('master', ['title' => $title]) ?>

<h2>Home</h2>

<form action="/" method="GET">
  <label for="search">Buscar nome</label>
  <input type="text" name="search" value="<?php echo filter_string_polyfill($search) ?>">
  <button type="submit">Buscar</button>
</form>

<div>
  <h3>Usuarios</h3>
  <p><?php echo $users->count ?> Usuarios cadastrados</p>
</div>

<div>
  <ul>
    <?php foreach ($users->rows as $user) : ?>
    <li><?php echo $user->name ?> | <a href="/user/<?php echo $user->id ?>">detalhes</a></li>
    <?php endforeach; ?>
  </ul>
</div>

<div>
  <?php echo $links ?>
</div>
<!-- 
<script>
async function getUsers() {
  try {
    const response = await fetch('/users');
    const users = await response.json();
    console.log(users);
    // return users;
  } catch (error) {
    console.log(error);
  }

}
getUsers();
</script> -->