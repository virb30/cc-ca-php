<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

use App\Domain\Entity\Order;
use App\Domain\Repository\OrderRepository;
use Illuminate\Contracts\Queue\EntityNotFoundException;

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

  public function count(): int
  {
    return count($this->orders);
  }

  public function getByCode(string $code): Order
  {
    $order = array_filter($this->orders, function($order) use ($code) {
      return $order->getCode() === $code;
    });

    if(empty($order)) {
      throw new EntityNotFoundException('Order', $code);
    }

    return $order[0];
  }
}