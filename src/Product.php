<?php declare(strict_types=1);

namespace App;

final class Product
{

  public function __construct(
    private int $id,
    private string $category,
    private string $description, 
    private float $price
  ) {}

  public function getId()
  {
    return $this->id;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function getQuantity()
  {
    return $this->quantity;
  }
}