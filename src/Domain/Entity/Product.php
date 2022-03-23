<?php declare(strict_types=1);

namespace App\Domain\Entity;

use DomainException;

final class Product
{
  public function __construct(
    public readonly int $id,
    public readonly string $category,
    public readonly string $description, 
    public readonly float $price,
    public readonly ?Dimension $dimensions = null,
    public readonly ?float $weight = null
  ) 
  {
    if(!!$weight && $weight < 0 ) throw new DomainException("Invalid weight");
  }

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