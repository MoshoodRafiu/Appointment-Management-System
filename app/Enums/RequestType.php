<?php

namespace App\Enums;

enum RequestType: string
{
    case GET = 'get';
    case POST = 'post';
    case PUT = 'put';
    case PATCH = 'patch';
    case DELETE = 'delete';

    /**
     * Get an enum case by string
     *
     * @param string $name
     * @return static
     */
    public static function getType(string $name): self
    {
        $name = strtolower($name);
        return match ($name) {
            'get'    => self::GET,
            'post'   => self::POST,
            'put'    => self::PUT,
            'patch'  => self::PATCH,
            'delete' => self::DELETE
        };
    }
}
