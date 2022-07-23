<?php /** @noinspection ALL */

namespace Tests\Unit;

use App\Enums\RequestType;
use App\Exceptions\InvalidRouteFoundException;
use App\Exceptions\RouteNotFoundException;
use App\Router\Router;
use PHPUnit\Framework\TestCase;
use Tests\DataProviders\RouteDataProvider;

class RouterTest extends TestCase
{
  public Router $router;

  /**
   * @return void
   */
  protected function setUp(): void
  {
    $this->router = new Router();
  }

  /**
   * Test that routes are resolved
   *
   * @test
   * @param RequestType $method
   * @param string $uri
   * @param callable|array $action
   * @dataProvider \Tests\DataProviders\RouteDataProvider::routeRegisterCases
   * @return void
   */
  public function it_registers_routes(
    RequestType $method, string $uri, callable|array $action
  ): void
  {
    $this->router->register($method, $uri, $action);

    $params = $this->router->getParams($uri);
    $expected = [
      $method->value => [
        $uri => [
          'action' => $action,
          'params' => $params
        ]
      ]
    ];

    $this->assertEquals($expected, $this->router->getRoutes());
  }

  /**
   * Test that routes are resolved
   *
   * @test
   * @param RequestType $method
   * @param string $uri
   * @param callable|array $action
   * @dataProvider Tests\DataProviders\RouteDataProvider::routeResolveCases
   * @return void
   */
  public function it_resolves_routes(
    RequestType $method, string $uri, callable|array $action
  ): void
  {
    $this->router->register($method, $uri, $action);

    $params = $this->router->getParams($uri);

    if (is_callable($action)) {
      $expected = call_user_func($action);
    } else {
      [$class, $methodName] = $action;
      $expected = call_user_func_array([new $class, $methodName], []);
    }

    $this->assertEquals($expected, $this->router->resolve($method, $uri));
  }

  /**
   * Tests that the router throws route not found execption
   *
   * @test
   * @throws RouteNotFoundException
   * @return void
   */
  public function it_throws_route_not_found_exception(): void
  {
    $this->expectException(RouteNotFoundException::class);
    $this->router->resolve(RequestType::GET, '/not-found');
  }

  /**
   * Tests that the router throws route not found execption
   *
   * @test
   * @throws InvalidRouteFoundException
   * @return void
   */
  public function it_throws_invalid_route_exception(): void
  {
    $class = new class {};
    $this->router->register(RequestType::GET, '/invalid', [$class::class, 'invalid']);
    $this->expectException(InvalidRouteFoundException::class);
    $this->router->resolve(RequestType::GET, '/invalid');
  }
}