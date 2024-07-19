<?php $this->layout('layout', ['title' => $title]) ?>

<h2>Login</h2>

<form action="/login" method="post">
  <input type="text" placeholder="Your email" name="email">
  <input type="text" placeholder="Your password" name="password">

  <button type="submit">Login</button>

</form>