<?php $this->layout('layout', ['title' => $title]) ?>

<h2>Login</h2>

<?= flash('status'); ?>

<form action="/login" method="post">
  <?= csrf() ?>

  <input type="text" placeholder="Your email" name="email">
  <?= flash('email'); ?>
  <input type="text" placeholder="Your password" name="password">
  <?= flash('password'); ?>

  <button type="submit">Login</button>

</form>