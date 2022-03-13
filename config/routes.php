<?php declare(strict_types=1);

use App\Infra\Controllers\HelloWorldController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
  $app->options('/{routes:.*}', function (Request $request, Response $response) {
    return $response;
  });

  $app->get('/', function(Request $request, Response $response) {
    $response->getBody()
      ->write('<a href="/hello/world">Try /hello/world</a>');

    return $response->withStatus(200);
  });

  $app->get('/hello/{name}', HelloWorldController::class);
};