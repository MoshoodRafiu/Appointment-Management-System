<?php

declare(strict_types=1);

namespace App;

use App\Enums\RequestType;
use App\Router\Router;

class App
{
  public function __construct(protected Router $router)
  {
  }

  public function boot(): self
  {
    return $this;
  }

  public function run(): self
  {
    echo $this->router->resolve(
      RequestType::getType($_SERVER['REQUEST_METHOD']),
      $_SERVER['REQUEST_URI']
    );
    return $this;
  }
}