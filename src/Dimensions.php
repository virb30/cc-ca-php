<?php declare(strict_types=1);

namespace App;

final class Dimensions
{
  public function __construct(
    public readonly int $height = 0,
    public readonly int $width = 0,
    public readonly int $depth = 0
  )
  {}

  public function getVolume()
  {
    return ($this->width / 100) * ($this->height / 100) * ($this->depth / 100);
  }
}