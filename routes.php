<?php /** @noinspection PhpUndefinedFieldInspection */

use App\Helpers\Request;
use App\Router\Router;

$router = new Router();

$router->get('/', function (Request $request) {
    return "Hello World";
});

$router->get('/invoices', function () {
    return "This is the invoices page";
});

$router->get('/invoices/{id}/{status}', function (Request $request, $id, $status) {
    var_dump($request, $id, $status);
    return "This is the invoice show page";
});

return $router;