<?php

namespace core\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class RepeatedLetters implements RuleInterface
{
  public function validate(
    string $field,
    Request $request,
    string $params = ''
  ): ?Response {
    $repeated = str_repeat('\1', $params - 1);
    $regex = "/([a-z0-9])$repeated/";

    if (preg_match($regex, $request->get($field))) {
      return new Response(
        "The field {$field} must not contain more than {$params} repeated letters",
        422
      );
    }
    return null;
  }
}
