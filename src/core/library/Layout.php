<?php

namespace core\library;

use core\exceptions\ClassNotFoundException;
use core\exceptions\ViewNotFoundException;
use core\interfaces\TemplateInterface;
use core\templates\Plates;
use League\Plates\Engine;
use MyContainer;

class Layout
{
  public static function render(
    string $view,
    array $data = [],
    string $viewPath = VIEW_PATH
  ): Response {
    $template = resolve('engine');

    if (!class_exists($template)) {
      throw new ClassNotFoundException("Template " . $template::class . "not found.");
    }
    $template = new $template();

    if (!$template instanceof TemplateInterface) {
      throw new ClassNotFoundException("Template " . $template::class . " must implement TemplateInterface.");
    }

    return response(
      content: $template->render($view, $data, $viewPath),
      headers: ['Content-Type' => 'text/html'],
    );
  }
}
