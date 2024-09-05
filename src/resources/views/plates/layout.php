<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="assets/images/tema/favicon.ico" />
  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap" rel="stylesheet">
  <!-- Assets -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  <!-- Fontawesome -->
  <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
  <!--  CSS -->
  <link rel="stylesheet" href="/assets/css/style.css">
  <title><?= $this->e($title ?? 'My title') ?></title>
</head>

<body>
  <?php $this->insert('partials/search') ?>
  <?php $this->insert('partials/menu_mobile') ?>
  <?php $this->insert('partials/header') ?>
  <?= $this->section('content') ?>
  <?php $this->insert('partials/footer') ?>

  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
    </svg>
  </div>

  <!-- JQUERY -->
  <script src="/assets/js/jquery-3.6.0.min.js"></script>
  <!-- BOOTSTRAP -->
  <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- TEMMA -->
  <script src="/assets/js/main.js"></script>

</body>

</html>