<?php declare(strict_types=1);

namespace App\Application\UseCase;

class PlaceOrderInput
{
  /**
   * @param string $cpf
   * @param \App\Application\UseCase\OrderItemInput[] $orderItems
   * @param string|null $coupon
   */
  public function __construct(
    public readonly string $cpf,
    public readonly array $orderItems,
    public readonly ?string $coupon
  ) { }
}