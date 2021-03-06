<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrder;

use DateTimeInterface;

class GetOrderOutput
{
  public function __construct(
    public readonly float $total,
    public readonly string $code,
    public readonly DateTimeInterface $issueDate
  )
  { }
}