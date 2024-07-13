<?php

use core\library\Layout;

function view($view, $data = [], $viewPath = VIEW_PATH)
{
  return Layout::render($view, $data, $viewPath);
}
