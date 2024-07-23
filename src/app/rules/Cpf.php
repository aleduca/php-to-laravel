<?php

namespace app\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class Cpf implements RuleInterface
{
  public function validate(
    string $key,
    Request $request,
    string $params = ''
  ): ?Response {
    if (!preg_match('/^\d{3}\.\d{3}\.\d{3}\.\d{2}$/', $request->get($key))) {
      return new Response("The {$key} field is not a valid cpf.", 422);
    }
    return null;
  }
}
