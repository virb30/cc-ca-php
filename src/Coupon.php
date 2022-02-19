<?php declare(strict_types=1);

namespace App;

use DateTime;
use DateTimeInterface;

class Coupon
{
  public function __construct(
    private string $code, 
    private float $percentage = 0, 
    private DateTimeInterface $expireDate = new DateTime()
  )
  {}

  public function getPercentage(): float
  {
    return $this->percentage;
  }

  public function __toString()
  {
    return $this->code;
  }

  public function isExpired()
  {
    $now = new DateTime();
    $diff = $now->diff($this->expireDate);
    return $diff->invert === 1 && $diff->days > 0;
  }
}