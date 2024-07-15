<?php

namespace core\interfaces;

interface TemplateInterface
{
  public function render(
    string $view,
    array $data = [],
    string $viewPath = VIEW_PATH
  );
}
