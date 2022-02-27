<?php declare(strict_types=1);

namespace App\Application\UseCase;

class PlaceOrderOutput
{
  public function __construct(public readonly float $total)
  {
    
  }
}