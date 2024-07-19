<?php

namespace core\library;

use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Spatie\Ignition\Ignition;

class App
{
  public readonly Container $container;

  public static function create(): self
  {
    return new self;
  }

  public function withErrorPage()
  {
    Ignition::make()
      ->setTheme('dark')
      ->shouldDisplayException(env('ENV') === 'development')
      ->register();

    return $this;
  }

  public function withContainer()
  {
    $builder = new ContainerBuilder();
    $builder->addDefinitions([
      Request::class => Request::create()
    ]);
    $this->container = $builder->build();

    return $this;
  }

  public function withEnvironmentVariables()
  {
    try {
      $dotenv = Dotenv::createImmutable(BASE_PATH);
      $dotenv->load();

      return $this;
    } catch (\Throwable $th) {
      dd($th->getMessage());
    }
  }

  public function withTemplateEngine(
    string $engine
  ) {

    bind('engine', $engine);

    return $this;
  }
}
