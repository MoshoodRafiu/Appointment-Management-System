<?php

namespace Tests\DataProviders;

use App\Enums\RequestType;
use App\Helpers\Request;

class RouteDataProvider
{
    public function routeRegisterCases(): array
    {
        return [
            [RequestType::GET, '/test/{user}', fn() => "Test"],
            [RequestType::POST, '/test', fn() => "Test"],
            [RequestType::PUT, '/test/{id}/update', fn() => "Test"],
            [RequestType::PATCH, '/test/{status}', fn() => "Test"],
            [RequestType::DELETE, '/test/{id}', fn() => "Test"]
        ];
    }

    public function routeResolveCases(): array
    {
        $class = new class {
            public function index(): string
            {
                return "Hello";
            }
        };

        return [
            [RequestType::GET, '/test/devrom', fn() => "Test"],
            [RequestType::POST, '/test', fn() => "Test"],
            [RequestType::PUT, '/test/1/update', fn() => "Test"],
            [RequestType::PATCH, '/test/success', fn() => "Test"],
            [RequestType::DELETE, '/test/1', fn() => "Test"],
            [RequestType::GET, '/test/moshood', [$class::class, 'index']],
        ];
    }
}