<?php

namespace core\templates;

use core\interfaces\TemplateInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig implements TemplateInterface
{
  public function render(
    string $view,
    array $data = [],
    string $viewPath = VIEW_PATH
  ) {
    $loader = new FilesystemLoader($viewPath . '/twig');
    $twig = new Environment($loader, [
      'cache' => $viewPath . '/twig/cache',
    ]);

    echo $twig->render($view . '.html', $data);
  }
}
