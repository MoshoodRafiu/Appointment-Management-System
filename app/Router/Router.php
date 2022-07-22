<?php

declare(strict_types=1);

namespace App\Router;

use App\Enums\RequestType;
use App\Exceptions\InvalidRouteFoundException;
use App\Exceptions\RouteNotFoundException;

class Router
{
  /**
   * Stores a list of all registered routes
   *
   * @var array
   */
  public array $routes = [];

  /**
   * Registers a new route
   *
   * @param RequestType $method
   * @param string $uri
   * @param array|callable $action
   * @return $this
   */
  public function register(RequestType $method, string $uri, array|callable $action): self
  {
    $this->routes[$method->value][$uri] = $action;
    return $this;
  }

  /**
   * Registers a get route
   *
   * @param string $uri
   * @param array|callable $action
   * @return $this
   */
  public function get(string $uri, array|callable $action): self
  {
    return $this->register(RequestType::GET, $uri, $action);
  }

  /**
   * Registers a post route
   *
   * @param string $uri
   * @param array|callable $action
   * @return $this
   */
  public function post(string $uri, array|callable $action): self
  {
    return $this->register(RequestType::POST, $uri, $action);
  }

  /**
   * Registers a put route
   *
   * @param string $uri
   * @param array|callable $action
   * @return $this
   */
  public function put(string $uri, array|callable $action): self
  {
    return $this->register(RequestType::PUT, $uri, $action);
  }

  /**
   * Registers a patch route
   *
   * @param string $uri
   * @param array|callable $action
   * @return $this
   */
  public function patch(string $uri, array|callable $action): self
  {
    return $this->register(RequestType::PATCH, $uri, $action);
  }

  /**
   * Registers a delete route
   *
   * @param string $uri
   * @param array|callable $action
   * @return $this
   */
  public function delete(string $uri, array|callable $action): self
  {
    return $this->register(RequestType::DELETE, $uri, $action);
  }


  /**
   * @param RequestType $requestMethod
   * @param string $uri
   * @return string
   * @throws InvalidRouteFoundException
   * @throws RouteNotFoundException
   */
  public function resolve(RequestType $requestMethod, string $uri): string
  {
    $action = $this->routes[$requestMethod->value][$uri] ?? null;

    if (!$action) {
      throw new RouteNotFoundException();
    }

    if (is_callable($action)) {
      return $action();
    }

    [$class, $method] = $action;

    if (class_exists($class)) {
      $class = new $class;
      if (method_exists($class, $method)) {
        return call_user_func_array($method, []);
      }
    }

    throw new InvalidRouteFoundException();
  }
}