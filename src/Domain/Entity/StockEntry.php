<?php declare(strict_types=1);

namespace App\Domain\Entity;

class StockEntry
{
  public function __construct(
    public readonly int $idItem,
    public readonly string $operation,
    public readonly int $quantity
  ) { }
}