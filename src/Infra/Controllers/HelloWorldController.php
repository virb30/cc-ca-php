<?php declare(strict_types=1);

namespace App\Infra\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HelloWorldController
{
  public function __invoke(Request $request, Response $response)
  {
    $name = $request->getAttribute('name');
    $payload = json_encode(['message' => "Hello, {$name}"]);
    $response->getBody()->write($payload);
    return $response
              ->withHeader('Content-Type', 'application/json')
              ->withStatus(200);
  }
}