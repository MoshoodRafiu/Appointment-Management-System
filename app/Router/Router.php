<?php

declare(strict_types=1);

namespace App\Router;

use App\Enums\RequestType;
use App\Exceptions\InvalidRouteFoundException;
use App\Exceptions\RouteNotFoundException;
use App\Helpers\Request;

class Router
{
  /**
   * Stores a list of all registered routes
   *
   * @var array
   */
  private array $routes = [];

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
    $params = $this->getPathParams($uri);
    $this->routes[$method->value][$uri] = [
      'action' => $action,
      'params' => $params
    ];
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
    $uri = explode('?', $uri)[0];
    $route = $this->routes[$requestMethod->value][$uri] ?? null;

    if (!$route) {
      foreach (
        ($this->routes[$requestMethod->value] ?? []) as $k => $v
      ) {
        if (!empty($v['params'])) {
          $route = $v;
          $routeUriArr = explode('/',
            preg_replace("/(^\/)|(\/$)/",'', $k)
          );
          $cleanedRequestUriArr =  explode('/',
            preg_replace("/(^\/)|(\/$)/",'',$uri)
          );

          foreach ($routeUriArr as $_k => $_v) {
            preg_match_all('/(?<={).+?(?=})/', $k, $matches);
            if (
              (count($routeUriArr) === count($cleanedRequestUriArr)) &&
              (in_array($_k, array_keys($v['params'])) || $_v === $cleanedRequestUriArr[$_k])
            ) {
              continue;
            }
            $route = [];
            break;
          }
          if ($route) {
            break;
          }
        }
      }
    }

    if (!$route) {
      throw new RouteNotFoundException();
    }

    ['action' => $action] = $route;

    $request = new Request($_REQUEST);

    if (is_callable($action)) {
      return call_user_func($action, $request);
    }

    [$class, $method] = $action;

    if (class_exists($class)) {
      $class = new $class;
      if (method_exists($class, $method)) {
        return call_user_func_array([new $class, $method], []);
      }
    }

    throw new InvalidRouteFoundException();
  }

  /**
   * Get all registered routes
   *
   * @return array
   */
  public function getRoutes(): array
  {
    return $this->routes;
  }

  /**
   * Gets the parameters in uri
   *
   * @param string $uri
   * @return array
   */
  public function getPathParams(string $uri): array
  {
    $params = [];

    preg_match_all('/(?<={).+?(?=})/', $uri, $matches);
    $matches = [...$matches[0]];

    $routeUriArr = explode('/',
      preg_replace("/(^\/)|(\/$)/",'', $uri)
    );

    foreach ($routeUriArr as $k => $v) {
      $v = str_replace(['{', '}'], '', $v);
      if (in_array($v, $matches)) {
        $params[$k] = $v;
      }
    }

    return $params;
  }
}