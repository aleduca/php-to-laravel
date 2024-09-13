<?php

use core\auth\AuthManager;
use core\library\Container;
use core\library\Layout;
use core\library\Redirect;
use core\library\Response;
use core\library\Session;

function view(string $view, array $data = [], string $viewPath = VIEW_PATH, int $status = 200): Response
{
  return Layout::render($view, $data, $viewPath, $status);
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

function csrf(): string
{
  return session()->csrf()->get();
}

function auth()
{
  return resolve(AuthManager::class);
}

function configFile(string $key)
{
  $file = BASE_PATH . '/app/config/config.php';

  if (!file_exists($file)) {
    return [];
  }

  $configFile = require $file;

  if (str_contains($key, '.')) {
    [$index, $subIndex] = explode('.', $key);
    return $configFile[$index][$subIndex];
  }

  return $configFile[$key];
}

function flash(
  string $key,
  string $style = 'alert alert-danger'
) {
  return session()->flash()->get($key, $style);
}

function method(string $method): string
{
  return "<input type='hidden' name='_method' value='$method'>";
}

function timerExpired(string $idSession, int $seconds = 60)
{
  date_default_timezone_set('America/Sao_Paulo');
  if (isset($_SESSION[$idSession])) {
    $lastTry = new DateTime($_SESSION[$idSession]);
    $now = new DateTime();

    if ($lastTry > $now) {
      return false;
    }

    unset($_SESSION[$idSession]);
    return true;
  }

  $_SESSION[$idSession] = (new DateTime())->modify("+{$seconds} seconds")->format('Y-m-d H:i:s');

  // $now = new DateTime();

  // dd($now->format('Y-m-d H:i:s'), $_SESSION[$idSession]);
  return false;
}


function response(
  string $content = '',
  int $status = 200,
  array $headers = []
): Response {
  return new Response($content, $status, $headers);
}
