<?php declare(strict_types=1);

namespace App\Infra\Http;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Application;

class LumenHttp implements Http
{
  public Application $app;

  public function __construct()
  {
    $this->app = new Application();
  }

  public function route(string $method, string $url, callable $callback)
  {
    $this->app->router->addRoute(strtoupper($method), $url, function (Request $request, Response $response) use($callback) {
      $result = $callback($request->query->all(), $request->request->all());
      $response->setContent(json_encode($result));
      $response->header('Content-Type', 'application/json');
      $response->send();
    });
  }

  public function run()
  {
    $this->app->run(); 
  }
}