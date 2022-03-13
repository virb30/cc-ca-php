<?php declare(strict_types=1);

namespace App\Domain\Entity;

use DomainException;

final class Dimension
{
  public readonly int $height;
  public readonly int $width;
  public readonly int $length;

  public function __construct(
    int $height = 0,
    int $width = 0,
    int $length = 0
  )
  {
    $this->setHeight($height);
    $this->setWidth($width);
    $this->setLength($length);
  } 

  private function setHeight(int $height): void
  {
    if(!$this->validate($height)){
      throw new DomainException('Height cannot be negative');
    }
    $this->height = $height;
  }

  private function setWidth(int $width): void
  {
    if(!$this->validate($width)){
      throw new DomainException('Width cannot be negative');
    }
    $this->width = $width;
  }

  private function setLength(int $length): void
  {
    if(!$this->validate($length)){
      throw new DomainException('Length cannot be negative');
    }
    $this->length = $length;
  }

  public function validate(int $dimension): bool
  {
    return $dimension >= 0;
  }

  public function getVolume()
  {
    return ($this->width / 100) * ($this->height / 100) * ($this->length / 100);
  }
}