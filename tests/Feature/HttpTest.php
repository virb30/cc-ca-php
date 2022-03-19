<?php declare(strict_types=1);

namespace Tests\Feature;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
  public function testShouldTestApi()
  {
    $client = new Client(['base_uri' => 'http://nginx']);

    $response = $client->get('/books');
    $books = json_decode((string) $response->getBody());
    $this->assertCount(3, $books);
    $this->assertEquals('Clean Code', $books[0]->title);
    $this->assertEquals('Refactoring', $books[1]->title);
    $this->assertEquals('Implementing Domain-Driven Design', $books[2]->title);
  }
}