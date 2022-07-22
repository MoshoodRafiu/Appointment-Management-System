<?php

namespace App\Exceptions;

class InvalidRouteFoundException extends \Exception
{
  protected $message = "Invalid Route";
}