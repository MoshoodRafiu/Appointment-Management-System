<?php

namespace Tests\DataProviders;

use App\Enums\RequestType;

class RouteDataProvider
{
  public function routeRegisterCases(): array
  {
    return [
      [RequestType::GET, '/test', fn() => "Test"],
      [RequestType::POST, '/test', fn() => "Test"],
      [RequestType::PUT, '/test', fn() => "Test"],
      [RequestType::PATCH, '/test', fn() => "Test"],
      [RequestType::DELETE, '/test', fn() => "Test"]
    ];
  }
}