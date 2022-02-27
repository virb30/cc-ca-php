<?php declare(strict_types=1);

namespace App\Application\UseCase;

class OrderItemInput
{
  public int $idItem;
  public int $quantity;
}

class PlaceOrderInput
{
  /**
   * Undocumented function
   *
   * @param string $cpf
   * @param OrderItemInput[] $orderItems
   * @param string|null $coupon
   */
  public function __construct(
    public readonly string $cpf,
    public readonly array $orderItems,
    public readonly ?string $coupon
  ) { }
}