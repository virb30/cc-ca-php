<?php declare(strict_types=1);

namespace App\Application\UseCase;

class OrderItemInput
{
  public int $idItem;
  public int $quantity;
}