<?php declare(strict_types=1);

namespace App\Application\UseCase\SimulateFreight;

class SimulateFreightOutput
{
  public function __construct(public readonly float $total)
  {}
}