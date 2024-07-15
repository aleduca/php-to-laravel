<?php

namespace core\templates;

use core\interfaces\TemplateInterface;
use Smarty\Smarty as SmartyTemplate;

class Smarty implements TemplateInterface
{
  public function render(
    string $view,
    array $data = [],
    string $viewPath = VIEW_PATH
  ) {
    $smarty = new SmartyTemplate();
    $smarty->setTemplateDir($viewPath . '/smarty');
    $smarty->setConfigDir($viewPath . '/smarty/config');
    $smarty->setCompileDir($viewPath . '/smarty/compile');
    $smarty->setCacheDir($viewPath . '/smarty/cache');

    if (!empty($data)) {
      foreach ($data as $key => $value) {
        $smarty->assign($key, $value);
      }
    }
    $smarty->display($view . '.tpl');
  }
}
