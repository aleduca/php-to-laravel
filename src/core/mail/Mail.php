<?php

namespace core\mail;

/**
 * @method static bool send(string $view, array $data, ?\Closure $closure = null)
 * @method static Mail to(string $to)
 * @method static Mail from(string $from)
 * @method static Mail subject(string $subject)
 * @method static Mail isHtml(bool $isHtml)
 * @method static void parseHtml(string $view, array $data)
 */
class Mail
{
  public static function __callStatic(
    string $name,
    array $arguments
  )
  {
    return (new Mailer())->$name(...$arguments);
  }
}