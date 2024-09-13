<?php

namespace core\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class Domain implements RuleInterface
{
  private $blackDomains = [
    'teste.com',
    'teste.com.br',
    'email.com',
    'example.com',
    'example.com.br'
  ];

  public function validate(
    string $field,
    Request $request,
    string $params = ''
  ): ?Response {
    $domain = substr(strrchr($request->get($field), "@"), 1);

    if (in_array($domain, $this->blackDomains)) {
      return new Response(
        "The field {$field} must not contain a blacklisted domain",
        422
      );
    }
    return null;
  }
}
