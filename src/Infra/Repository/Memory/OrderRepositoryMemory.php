<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

use App\Domain\Entity\Order;
use App\Domain\Repository\OrderRepository;

final class OrderRepositoryMemory implements OrderRepository
{
  /**
   * @var Order[]
   */
  private array $orders = [];

  public function save(Order $order): void
  {
    array_push($this->orders, $order);
  }
}