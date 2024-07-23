<?php

namespace core\interfaces;

use core\library\Request;
use core\library\Response;

interface RuleInterface
{
  /**
   * @return Response|null Returns a Response object if the validation fails and the status code must be 422
   */
  public function validate(
    string $field,
    Request $request,
    string $params = ''
  ): ?Response;
}
