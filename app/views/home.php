<h2>Home</h2>

<ul>
  <?php foreach ($users as $user) : ?>
  <li><?php echo $user->nome ?> | <a href="/user/<?php echo $user->id ?>">detalhes</a></li>
  <?php endforeach; ?>
</ul>