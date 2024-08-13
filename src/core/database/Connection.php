<?php

namespace core\database;

class Connection
{
  private static $instance;

  public static function getInstance(): \PDO
  {
    if (!self::$instance) {
      // get host with docker
      $host = env('DB_HOST');
      $database = env('DB_DATABASE');
      $username = env('DB_USERNAME');
      $password = env('DB_PASSWORD');
      self::$instance = new \PDO("mysql:host=$host;dbname=$database", $username, $password, [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
      ]);
    }

    return self::$instance;
  }
}
