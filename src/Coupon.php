<?php declare(strict_types=1);

namespace App;

class Coupon
{
  private string $code;
  private float $percentage;

  public function __construct(string $code, float $percentage = 0)
  {
    $this->code = $code;
    $this->percentage = $percentage;
  }

  private function setPercentage(float $percentage): void
  {
    $this->percentage = $percentage;

    if ($percentage < 0) $this->percentage = 0;
    if ($percentage > 100) $this->percentage = 100;
  }

  public function getPercentage(): float
  {
    return $this->percentage;
  }

  public function __toString()
  {
    return $this->code;
  }
}