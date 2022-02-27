<?php declare(strict_types=1);

namespace App\Infra\Database;

interface Connection
{
  public function query(string $statement, array $parameters): array;
}