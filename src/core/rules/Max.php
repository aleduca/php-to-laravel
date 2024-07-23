<?php

namespace core\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class Max implements RuleInterface
{
  public function validate(
    string $field,
    Request $request,
    string $params = ''
  ): ?Response {
    if (strlen($request->get($field)) > $params) {
      return new Response(
        "The field {$field} must be less than or equal to {$params} characters",
        422
      );
    }
    return null;
  }
}
