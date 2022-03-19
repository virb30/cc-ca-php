<?php declare(strict_types=1);

namespace App\Infra\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class SymfonyHttp
{
  public function __construct()
  {
    $routes = new RouteCollection();
    $routes->add('books', new Route(
      '/books',
      ['_controller' => function($request, $response) {
        $books = [
          (object) ['title' => 'Clean Code'],
          (object) ['title' => 'Refactoring'],
          (object) ['title' => 'Implementing Domain-Driven Design'],
        ];
        $response->getBody()->write(json_encode($books));
        return $response->withHeader('Content-Type', 'application/json');
      }]
    ));
 
    // Init RequestContext object
    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());
 
    // Init UrlMatcher object
    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($context->getPathInfo());
    $parameters['_controller']();
  }
}