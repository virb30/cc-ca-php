<?php declare(strict_types=1);

namespace App\Domain\Entity;

use DomainException;

final class Dimension
{
  public function __construct(
    public readonly int $height = 0,
    public readonly int $width = 0,
    public readonly int $length = 0
  )
  {
    if($height < 0 || $width < 0 || $length < 0) throw new DomainException("Invalid dimensions");
  } 

  public function getVolume()
  {
    return ($this->width / 100) * ($this->height / 100) * ($this->length / 100);
  }
}