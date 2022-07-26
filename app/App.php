<?php

declare(strict_types=1);

namespace App;

use App\Enums\RequestType;
use App\Router\Router;
use Dotenv\Dotenv;

class App
{
    public function __construct(protected Router $router)
    {
    }

    public function boot(): self
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        return $this;
    }

    /**
     * Runs the application
     *
     * @return $this
     * @throws Exceptions\InvalidRouteFoundException
     * @throws Exceptions\RouteNotFoundException
     * @throws \ReflectionException
     */
    public function run(): self
    {
        echo $this->router->resolve(
            RequestType::get($_SERVER['REQUEST_METHOD']),
            $_SERVER['REQUEST_URI']
        );
        return $this;
    }
}