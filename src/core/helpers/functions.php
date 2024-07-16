<?php

use core\library\Container;
use core\library\Layout;
use core\library\Response;

function view($view, $data = [], $viewPath = VIEW_PATH): Response
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

function response(
  string $content = '',
  int $status = 200,
  array $headers = []
): Response {
  return new Response($content, $status, $headers);
}
