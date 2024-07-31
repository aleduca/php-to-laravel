<?php

use core\library\Container;
use core\library\Layout;
use core\library\Redirect;
use core\library\Response;
use core\library\Session;

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

function session(): Session
{
  return resolve(Session::class);
}

function redirect(string $to = ''): Response
{
  return resolve(Redirect::class)->to($to);
}

function back(): Response
{
  return resolve(Redirect::class)->back();
}

function flash(
  string $key,
  string $style = 'alert alert-danger'
) {
  return session()->flash()->get($key, $style);
}

function response(
  string $content = '',
  int $status = 200,
  array $headers = []
): Response {
  return new Response($content, $status, $headers);
}
