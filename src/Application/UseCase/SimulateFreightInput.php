<?php declare(strict_types=1);

namespace App\Application\UseCase;

class SimulateFreightInput
{
  /**
   * @param \App\Application\UseCase\OrderItemInput[] $orderItems
   */
  public function __construct(
    public readonly array $orderItems,
  ) { }
}