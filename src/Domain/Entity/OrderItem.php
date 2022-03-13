<?php declare(strict_types=1);

namespace App\Domain\Entity;

use DomainException;

final class OrderItem
{
  public readonly int $quantity;

  public function __construct(
    public readonly int $idItem,
    public readonly float $price,
    int $quantity
  )
  { 
    $this->setQuantity($quantity);
  }

  private function setQuantity(int $quantity)
  {
    if($quantity < 0) {
      throw new DomainException("Quantity must be positive");
    }

    $this->quantity = $quantity;
  }

  public function getTotal()
  {
    return $this->price * $this->quantity;
  }
}