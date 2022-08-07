<?php $this->layout('master', ['title' => $title]) ?>

<h2>Home</h2>

<ul>
  <?php foreach ($users as $user) : ?>
  <li><?php echo $user->name ?> | <a href="/user/<?php echo $user->id ?>">detalhes</a></li>
  <?php endforeach; ?>
</ul>

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
</script>