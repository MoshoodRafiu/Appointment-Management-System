<?php /** @noinspection PhpPureAttributeCanBeAddedInspection */

declare(strict_types=1);

namespace App;

use App\Database\SqlDatabase;
use App\Enums\RequestType;
use App\Interfaces\DatabaseInterface;
use App\Router\Router;
use Dotenv\Dotenv;

class App
{
    public function __construct(
        protected Container $container,
        protected ?Router $router = null
    ) {
    }

    public function boot(): self
    {
        $this->container->set(
            DatabaseInterface::class,
            fn($container) => $container->get(SqlDatabase::class)
        );
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