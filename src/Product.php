<?php declare(strict_types=1);

namespace App;

use App\Dimensions;

final class Product
{

  public function __construct(
    private int $id,
    private string $category,
    private string $description, 
    private float $price,
    private Dimensions $dimensions = new Dimensions(),
    private float $weight = 0
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
    return $this->dimensions->getVolume();
  }

  public function getDensity()
  {
    $volume = $this->getVolume();
    if($volume === 0) {
      return 0;
    }
    return round($this->weight / $volume);
  }
}