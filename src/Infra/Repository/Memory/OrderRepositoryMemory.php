<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

use App\Domain\Entity\Cpf;
use App\Domain\Entity\Order;
use App\Domain\Repository\OrderRepository;
use Exception;

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

  public function clean(): void
  {
    $this->orders = [];
  }

  public function getByCode(string $code): Order
  {
    $order = array_filter($this->orders, function($order) use ($code) {
      return $order->getCode() === $code;
    });

    if(empty($order)) {
      throw new Exception('Order not found');
    }

    return $order[0];
  }

  /**
   * @return Order[]
   */
  public function getAll(): array
  {
    return $this->orders;
  }
}