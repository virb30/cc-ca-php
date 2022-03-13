<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrder;

class OrderItemOutput
{
  public function __construct(
    public readonly string $description,
    public readonly float $price,
    public readonly int $quantity
  ) 
  { }
}