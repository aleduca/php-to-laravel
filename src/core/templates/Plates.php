<?php

namespace core\templates;

use core\interfaces\TemplateInterface;
use League\Plates\Engine;

class Plates implements TemplateInterface
{
  public function render(
    string $view,
    array $data = [],
    string $viewPath = VIEW_PATH
  ) {
    $templates = new Engine($viewPath . '/plates');

    return $templates->render($view, $data);
  }
}
