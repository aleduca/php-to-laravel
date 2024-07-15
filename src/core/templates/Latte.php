<?php

namespace core\templates;

use core\interfaces\TemplateInterface;
use Latte\Engine;

class Latte implements TemplateInterface
{
  public function render(
    string $view,
    array $data = [],
    string $viewPath = VIEW_PATH
  ) {
    $templatePath = $viewPath . '/latte/';
    $latte = new Engine;
    // diretório de cache
    $latte->setTempDirectory($templatePath . 'cache');
    // render à saída
    $latte->render($templatePath . $view . '.latte', $data);
  }
}
