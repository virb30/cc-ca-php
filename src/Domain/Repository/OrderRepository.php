<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Order;

interface OrderRepository
{
  public function save(Order $order): void;
  public function count(): int;
}