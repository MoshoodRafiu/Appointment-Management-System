<?php

namespace App\Exceptions\Container;

use Psr\Container\ContainerExceptionInterface;

class InvalidClassException extends \Exception implements ContainerExceptionInterface
{
}