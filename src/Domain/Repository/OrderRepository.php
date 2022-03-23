<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Cpf;
use App\Domain\Entity\Order;

interface OrderRepository
{
  public function save(Order $order): void;
  public function count(): int;
  public function clean(): void;
  public function getByCode(string $code): Order;
  /**
   * @return Order[]
   */
  public function getAll(): array;
}