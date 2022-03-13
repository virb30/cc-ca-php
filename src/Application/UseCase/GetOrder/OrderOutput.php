<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrder;

use DateTimeInterface;

class OrderOutput
{
  public function __construct(
    public readonly string $code,
    public readonly float $total,
    public readonly array $items,
    public readonly ?string $coupon,
    public readonly DateTimeInterface $issueDate
  )
  { }
}