<?php

namespace core\library;

use core\library\Session;
use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

use function DI\create;
use function DI\factory;
use Spatie\Ignition\Ignition;

class App
{
  public readonly Container $container;
  public readonly Session $session;

  public static function create(): self
  {
    return new self;
  }

  public function withSession()
  {
    $this->session = new Session();
    $this->session->previousUrl();

    return $this;
  }

  public function withErrorPage()
  {
    Ignition::make()
      ->setTheme('dark')
      ->shouldDisplayException(env('ENV') === 'development')
      ->register();

    return $this;
  }

  public function withMiddlewares(array $middlewares)
  {
    bind('middlewares', $middlewares);

    return $this;
  }

  public function withDependencyInjectionContainer()
  {
    $builder = new ContainerBuilder();
    $builder->addDefinitions([
      Request::class => factory([Request::class, 'create'])->parameter('session', $this->session),
      Session::class => function () {
        return $this->session;
      }
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

  public function withServiceContainer()
  {
    bind(Redirect::class, function () {
      return new Redirect();
    });

    bind(Session::class, function () {
      return $this->session;
    });

    return $this;
  }
}
