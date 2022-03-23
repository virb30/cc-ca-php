<?php declare(strict_types=1);

namespace App\Infra\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class SymfonyHttp implements Http
{
  public $routes;
  public RequestContext $context;

  public function __construct()
  {
    $this->routes = new RouteCollection();
    $this->context = new RequestContext();
  }

  public function route(string $method, string $url, callable $callback)
  {
    $this->routes->add($url, new Route(
      $url,
      ['handler' => function(Request $request) use($callback) {
        $result = $callback($request->query->all(), $request->request->all());
        $response = new Response(json_encode($result));
        $headers = new ResponseHeaderBag(['Content-Type' => 'application/json']);
        $response->headers = $headers;
        $response->send();
      }],
      [],
      [],
      '',
      [],
      [strtoupper($method)]
    ));
  }

  public function run()
  {
    $request = Request::createFromGlobals();
    $this->context->fromRequest($request);
    $matcher = new UrlMatcher($this->routes, $this->context);
    $parameters = $matcher->match($this->context->getPathInfo());
    $parameters['handler']($request);
  }
}