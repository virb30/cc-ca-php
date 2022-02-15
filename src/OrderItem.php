<?php declare(strict_types=1);

namespace App;

final class OrderItem
{
  public function __construct(
    public readonly int $idItem,
    public readonly float $price,
    public readonly int $quantity
  )
  { }

  public function getTotal()
  {
    return $this->price * $this->quantity;
  }
}