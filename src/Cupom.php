<?php declare(strict_types=1);

namespace App;

final class Cupom
{
  private string $description;
  private float $percent;

  public function __construct(string $description, float $percent = 0)
  {
    $this->description = $description;
    $this->setPercent($percent);
  }

  private function setPercent(float $percent): void
  {
    $this->percent = $percent;

    if ($percent < 0) $this->percent = 0;
    if ($percent > 100) $this->percent = 100;
  }

  public function getPercent(): float
  {
    return $this->percent;
  }
}