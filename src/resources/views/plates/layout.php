<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->e($title ?? 'My title') ?></title>
  <?= $this->section('styles') ?>
</head>

<body>
  <?php $this->insert('partials/header') ?>
  <?= $this->section('content') ?>
</body>

</html>