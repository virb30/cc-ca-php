<?php declare(strict_types=1);

namespace App;

final class Product
{

  public function __construct(
    private string $description, 
    private float $price, 
    private int $quantity = 1
  ) {}


  public function getPrice()
  {
    return $this->price;
  }

  public function getQuantity()
  {
    return $this->quantity;
  }
}