<?php declare(strict_types=1);

namespace App;

use DateTime;
use DateTimeInterface;

class Coupon
{
  public function __construct(
    private string $code, 
    private float $percentage = 0, 
    private ?DateTimeInterface $expireDate = null
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

  public function isExpired(DateTime $today = new DateTime())
  {
    if(!$this->expireDate) return false;
    return $this->expireDate->getTimestamp() < $today->getTimestamp();
  }

  public function calculateDiscount(float $amount)
  {
    return ($amount * $this->percentage / 100);
  }
}