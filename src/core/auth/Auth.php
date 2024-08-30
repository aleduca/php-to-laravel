<?php

namespace core\auth;

use app\database\models\User;
use core\library\Session;

class Auth
{
  public function __construct(
    private Session $session
  ) {}

  public static function create(
    Session $session
  ): self {
    return new self($session);
  }

  public function attempt(
    string $email,
    string $password
  ): bool {
    $user = User::select('id', 'firstName', 'lastName', 'email', 'password')->find('email', $email);

    if (!$user) {
      return false;
    }

    if (password_verify($password, $user->password)) {
      $user->removeAttribute('password');
      $this->session->set('user', $user);
      session_regenerate_id();
      return true;
    }

    return false;
  }

  public function logout()
  {
    $this->session->remove('user');

    session_regenerate_id();

    return redirect('/');
  }
}
