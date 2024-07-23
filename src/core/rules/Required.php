<?php

namespace core\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class Required implements RuleInterface
{
  public function validate(
    string $field,
    Request $request,
    string $params = ''
  ): ?Response {
    if (empty($request->get($field))) {
      return new Response(
        "The field {$field} is required",
        422
      );
    }

    return null;
  }
}
