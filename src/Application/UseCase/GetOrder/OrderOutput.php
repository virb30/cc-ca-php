<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrder;

use DateTimeInterface;

class OrderOutput
{
  public function __construct(
    public readonly string $code,
    public readonly DateTimeInterface $issueDate
  )
  { }
}