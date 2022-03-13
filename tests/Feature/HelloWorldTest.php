<?php declare(strict_types=1);

use Tests\TestCase;

class HelloWorldTest extends TestCase
{
  public function testGetHelloWorld()
  {
    $response = $this->get( "/hello/world");
    $body = (string) $response->getBody();
    $this->assertJson($body);
    $this->assertStringContainsString('Hello, world', $body);
    $this->assertEquals(200, $response->getStatusCode());
  }
}