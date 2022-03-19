<?php declare(strict_types=1);

namespace Tests;

use App\Infra\Http\Http;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  protected Http $app; 

  protected function setUp(): void
  {
    parent::setUp();
    $this->createApplication();
  }

  /**
   * @param string $method
   * @param string $path
   * @param array  $headers
   * @return ResponseInterface
  */
  protected function makeRequest(
      string $method,
      string $path,
      array $options = [
        'headers' => [
          'HTTP_ACCEPT' => 'application/json'
        ]
      ],
  ): ResponseInterface {
    $client = new Client(['base_uri' => 'http://nginx']);
    $response = $client->request($method, $path, $options);
    return $response;
  }


  public function get($path = '', $headers = [], $cookies = [], $params = [])
  {
    $options = [];
    $options[RequestOptions::HEADERS] = $headers;
    $options[RequestOptions::COOKIES] = $cookies;
    $options[RequestOptions::QUERY] = $params;
    return $this->makeRequest('GET', $path, $options);
  }

  public function post($path = '', $headers = [], $cookies = [], $params = [])
  {
    $options = [];
    $options[RequestOptions::HEADERS] = $headers;
    $options[RequestOptions::COOKIES] = $cookies;
    $options[RequestOptions::BODY] = $params;
    return $this->makeRequest('POST', $path, $options);
  }

  public function put($path = '', $headers = [], $cookies = [], $params = [])
  {
    $options = [];
    $options[RequestOptions::HEADERS] = $headers;
    $options[RequestOptions::COOKIES] = $cookies;
    $options[RequestOptions::BODY] = $params;
    return $this->makeRequest('PUT', $path, $options);
  }

  public function delete($path = '', $headers = [], $cookies = [], $params = [])
  {
    $options = [];
    $options[RequestOptions::HEADERS] = $headers;
    $options[RequestOptions::COOKIES] = $cookies;
    $options[RequestOptions::BODY] = $params;
    return $this->makeRequest('DELETE', $path, $options);
  }
}

