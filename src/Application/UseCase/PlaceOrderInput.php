<?php declare(strict_types=1);

namespace App\Application\UseCase;

use DateTime;
use DateTimeInterface;

class PlaceOrderInput
{
  /**
   * @param string $cpf
   * @param \App\Application\UseCase\OrderItemInput[] $orderItems
   * @param string|null $coupon
   * @param DateTimeInterface $date
   */
  public function __construct(
    public readonly string $cpf,
    public readonly array $orderItems,
    public readonly ?string $coupon,
    public readonly DateTimeInterface $date = new DateTime()
  ) { }
}