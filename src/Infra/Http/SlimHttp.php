<?php declare(strict_types=1);

namespace App\Infra\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Factory\AppFactory;

class SlimHttp implements Http
{
  public App $app;

  public function __construct()
  {
    $this->app = AppFactory::create();
    $this->app->addErrorMiddleware(true, false, false);
  }

  public function route(string $method, string $url, callable $callback)
  {
    $method = strtolower($method);
    $this->app->$method($url, function(ServerRequestInterface $request, ResponseInterface $response) use($callback) {
      $result = $callback($request->getQueryParams(), $request->getParsedBody());
      $result['from'] = 'slim';
      $response->getBody()->write(json_encode($result));
      return $response->withHeader('Content-Type', 'application/json');
    });
  }

  public function run()
  {
    $this->app->run();
  }
}