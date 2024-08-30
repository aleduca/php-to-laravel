<ul>
  <li><a href="/">Home</a></li>
  <li><a href="/product/mouse">Products</a></li>
  <?php if (auth()->guest()): ?>
    <li>
      <a href="/login">Login</a>
    </li>
  <?php else: ?>
    <li>
      Olá, <?= auth()->user()->firstName; ?>
      <form action="/logout" method="post">
        <?= csrf() ?>
        <?= method('DELETE') ?>
        <button type="submit">Logout</button>
      </form>
    </li>
  <?php endif; ?>
</ul>