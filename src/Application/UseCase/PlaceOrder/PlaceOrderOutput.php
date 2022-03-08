<?php declare(strict_types=1);

namespace App\Application\UseCase\PlaceOrder;

class PlaceOrderOutput
{
  public function __construct(
    public readonly string $code,
    public readonly float $total
  ) {}
}