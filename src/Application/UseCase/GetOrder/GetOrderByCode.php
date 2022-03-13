<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrder;

use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;

class GetOrderByCode
{
  public function __construct(
    private OrderRepository $orderRepository,
    private ProductRepository $productRepository,
  ) {}

  public function execute(string $code): OrderOutput
  {
    $order = $this->orderRepository->getByCode($code);

    $output = new OrderOutput(
      $order->getCode(),
      $order->issueDate
    );

    return $output;
  }
}