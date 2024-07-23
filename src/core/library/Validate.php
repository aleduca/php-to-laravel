<?php

namespace core\library;

use core\exceptions\ClassNotFoundException;
use core\interfaces\RuleInterface;

class Validate
{
  private array $errors = [];
  public readonly array $data;

  public function hasErrors(): bool
  {
    return !empty($this->errors);
  }

  public function errors()
  {
    return $this->errors;
  }

  public function validate(
    array $rules,
    Request $request
  ) {

    foreach ($rules as $field => $rules) {
      $rules = explode('|', $rules);
      foreach ($rules as $rule) {

        if (str_contains($rule, ':')) {
          [$rule, $params] = explode(':', $rule);
        }

        $ruleClass = (strpos($rule, '\\') !== false) ? $rule : 'core\\rules\\' . ucfirst($rule);

        if (!class_exists($ruleClass)) {
          throw new ClassNotFoundException("Rule {$rule} not found");
        }

        $rule = new $ruleClass;

        if (!$rule instanceof RuleInterface) {
          throw new ClassNotFoundException("Rule " . $rule::class . " must be an instance of Rule");
        }

        $response = $rule->validate($field, $request, $params ?? '');

        if ($response) {
          $this->errors[$field] = $response->send(return: true);
          break;
        }
      }
    }

    if (!$this->hasErrors()) {
      $this->data = $request->all();
    }

    return $this;
  }
}
