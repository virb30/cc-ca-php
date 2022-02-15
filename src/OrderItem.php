<?php declare(strict_types=1);

namespace App;

final class OrderItem
{
  public function __construct(
    private int $idItem,
    private float $price,
    private int $quantity
  )
  { }

  public function getTotal()
  {
    return $this->price * $this->quantity;
  }
}