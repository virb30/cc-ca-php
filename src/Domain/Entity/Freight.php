<?php declare(strict_types=1);

namespace App\Domain\Entity;

class Freight
{
  private $total;
  const DISTANCE = 1000;
  const MIN_FREIGHT = 10;

  public function __construct()
  {
    $this->total = 0;
  }

  public function addItem(Product $item, int $quantity)
  {
    $this->total += self::DISTANCE * $item->getVolume() * ($item->getDensity() / 100) * $quantity;
  }

  public function getTotal()
  {
    if($this->total > 0 && $this->total < self::MIN_FREIGHT) return self::MIN_FREIGHT;
    return $this->total;
  }
}