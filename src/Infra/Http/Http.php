<?php declare(strict_types=1);

namespace App\Infra\Http;

interface Http
{
  public function route(string $method, string $url, callable $callback);
  public function run();
}