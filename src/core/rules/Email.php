<?php

namespace core\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class Email implements RuleInterface
{
  public function validate(
    string $field,
    Request $request,
    string $params = ''
  ): ?Response {
    if (!filter_var($request->get($field), FILTER_VALIDATE_EMAIL)) {
      return new Response(
        "The field {$field} must be a valid email",
        422
      );
    }
    return null;
  }
}
