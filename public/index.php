<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Infra\Http\SlimHttp;
use App\Infra\Http\SymfonyHttp;

$slimHttp = new SlimHttp();

$slimHttp->route('get', '/books', function($params, $body) {
  $books = [
    (object) ['title' => 'Clean Code'],
    (object) ['title' => 'Refactoring'],
    (object) ['title' => 'Implementing Domain-Driven Design'],
  ];
  return $books;
});

$slimHttp->run();
