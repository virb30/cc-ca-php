<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Infra\Http\SlimHttp;
use App\Infra\Http\SymfonyHttp;
use App\Infra\Http\LumenHttp;

$http = new LumenHttp();

$http->route('get', '/books', function($params, $body) {
  $books = [
    (object) ['title' => 'Clean Code'],
    (object) ['title' => 'Refactoring'],
    (object) ['title' => 'Implementing Domain-Driven Design'],
  ];
  return $books;
});

$http->run();
