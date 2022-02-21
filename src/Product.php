<?php declare(strict_types=1);

namespace App;

use App\Dimension;

final class Product
{
  public function __construct(
    private int $id,
    private string $category,
    private string $description, 
    private float $price,
    private readonly ?Dimension $dimensions = null,
    private readonly ?float $weight = null
  ) {}

  public function getId()
  {
    return $this->id;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function getVolume()
  {
    if($this->dimensions) return $this->dimensions->getVolume();
    return 0;
  }

  public function getDensity()
  {
    if($this->weight && $this->dimensions){
      return round($this->weight / $this->dimensions->getVolume());
    } else {
      return 0;
    }
  }
}