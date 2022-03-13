<?php declare(strict_types=1);

namespace Tests;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use PHPUnit\Framework\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  protected App $app; 

  protected function setUp(): void
  {
    parent::setUp();
    $this->app = $this->createApplication();
  }

     /**
     * @param string $method
     * @param string $path
     * @param array  $headers
     * @param array  $cookies
     * @param array  $serverParams
     * @return Request
     */
    protected function createRequest(
      string $method,
      string $path,
      array $headers = ['HTTP_ACCEPT' => 'application/json'],
      array $cookies = [],
      array $serverParams = []
  ): Request {
      $uri = new Uri('', '', 80, $path);
      $handle = fopen('php://temp', 'w+');
      $stream = (new StreamFactory())->createStreamFromResource($handle);

      $h = new Headers();
      foreach ($headers as $name => $value) {
          $h->addHeader($name, $value);
      }

      return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
  }

  public function makeRequest(SlimRequest $request): ResponseInterface
  {
    return $this->app->handle($request);
  }

  public function get($path = '', $headers = [], $cookies = [], $params = [])
  {
    $request = $this->createRequest('GET', $path, $headers, $cookies, $params);
    return $this->makeRequest($request);
  }

  public function post($path = '', $headers = [], $cookies = [], $params = [])
  {
    $request = $this->createRequest('POST', $path, $headers, $cookies, $params);
    return $this->makeRequest($request);
  }

  public function put($path = '', $headers = [], $cookies = [], $params = [])
  {
    $request = $this->createRequest('PUT', $path, $headers, $cookies, $params);
    return $this->makeRequest($request);
  }

  public function delete($path = '', $headers = [], $cookies = [], $params = [])
  {
    $request = $this->createRequest('DELETE', $path, $headers, $cookies, $params);
    return $this->makeRequest($request);
  }
}

