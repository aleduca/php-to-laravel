<?php $this->layout('layout', ['title' => $title]) ?>

<h2>Home</h2>

<form action="/user/12" method="post">
  <?= csrf() ?>
  <?= method('DELETE') ?>
  <input type="text" placeholder="Your email" name="email">
  <?= flash('email'); ?>
  <input type="text" placeholder="Your password" name="password">
  <?= flash('password'); ?>

  <button type="submit">Create</button>
</form>