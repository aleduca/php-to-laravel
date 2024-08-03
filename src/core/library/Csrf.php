<?php

namespace core\library;

use core\exceptions\CSRFException;
use Smarty\Compiler\Configfile;

class Csrf
{
  public function __construct(
    private Session $session
  ) {
  }

  public function get(): string
  {
    $this->session->set('csrf', bin2hex(random_bytes(32)));

    return "<input type='hidden' name='csrf' value='{$this->session->get('csrf')}'>";
  }

  public function check(
    Request $request
  ) {
    // pegar somente requisicoes diferentes de GET
    if (REQUEST_METHOD !== 'GET') {

      // verificar se a rota esta liberada em uma lista
      if (in_array(REQUEST_URI, configFile('csrf.ignore'))) {
        return;
      }

      // verificar se existe o campo oculto
      if (!$request->get('csrf')) {
        view(view: 'errors/419', status: 419, viewPath: VIEW_PATH_CORE)->send();
        die();
      }

      // verificar se o hash bate com o hash da sessao
      if (!hash_equals($request->get('csrf'), $this->session->get('csrf'))) {
        throw new CSRFException('CSRF token mismatch');
      }
    }
  }
}
