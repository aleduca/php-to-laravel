<?php

namespace core\auth;

use app\database\models\User;
use core\library\Session;

class AuthManager
{
  public function __construct(
    private Session $session
  ) {}

  public static function create(): self
  {
    return new self(Session::create());
  }

  public function user(): ?User
  {
    return $this->session->get('user');
  }

  public function check(): bool
  {
    return $this->session->has('user');
  }

  public function guest()
  {
    return !$this->check();
  }
}
