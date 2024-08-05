<?php

namespace core\library;

class Csrf
{
  public function __construct(
    private Session $session
  ) {
  }

  public function get(): string
  {
    if (!$this->session->has('csrf')) {
      $this->session->set('csrf', bin2hex(random_bytes(32)));
    }

    return "<input type='hidden' name='_csrf' value='{$this->session->get('csrf')}'>";
  }

  private function viewCsrfNotFound(Request $request, string $view, string $message)
  {
    if ($request->ajax()) {
      response(status: 419)->json(['message' => $message])->send();
      return;
    }
    view(view: $view, status: 419, viewPath: VIEW_PATH_CORE)->send();
  }

  private function regexIgnoredRoutes(): bool
  {
    $excepts = configFile('csrf.ignore');
    if (!empty($excepts)) {
      foreach ($excepts as $except) {
        $pattern = str_replace('/', '\/', trim($except, '/'));
        if (preg_match("/^$pattern$/", trim(REQUEST_URI, '/'))) {
          return true;
        }
      }
    }
    return false;
  }

  public function check(
    Request $request
  ) {
    // pegar somente requisicoes diferentes de GET
    if (REQUEST_METHOD !== 'GET') {

      // verificar se a rota esta liberada em uma lista
      if (!$request->get('_csrf') && $this->regexIgnoredRoutes()) {
        return;
      }

      // verificar se existe o campo oculto
      if (!$request->get('_csrf')) {
        $this->viewCsrfNotFound($request, 'errors/419', 'CSRF token not found');
        die();
      }

      // verificar se o hash bate com o hash da sessao
      if (!hash_equals($request->get('_csrf'), $this->session->get('csrf'))) {
        $this->viewCsrfNotFound($request, 'errors/419', 'CSRF token mismatch');
        die();
        // throw new CSRFException('CSRF token mismatch');
      }

      $this->session->remove('csrf');
    }
  }
}
