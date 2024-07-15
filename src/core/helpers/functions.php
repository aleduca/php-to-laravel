<?php

use core\library\Container;
use core\library\Layout;

function view($view, $data = [], $viewPath = VIEW_PATH)
{
  return Layout::render($view, $data, $viewPath);
}

function bind(string $key, mixed $value)
{
  Container::bind($key, $value);
}

function resolve(string $key)
{
  return Container::resolve($key);
}
