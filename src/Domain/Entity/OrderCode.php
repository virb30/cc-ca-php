<?php declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeInterface;

class OrderCode
{
  public readonly string $value;

  public function __construct(DateTimeInterface $date, int $sequence)
  {
    $this->value = $this->generateCode($date, $sequence);
  }

  private function generateCode(DateTimeInterface $date, int $sequence)
  {
    $year = $date->format('Y');
    return $year.str_pad((string) $sequence, 8, "0", STR_PAD_LEFT);
  }
}