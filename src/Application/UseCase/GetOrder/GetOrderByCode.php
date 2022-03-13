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
    $orderProducts = [];
    foreach($order->getItems() as $orderItem) {
      $product = $this->productRepository->getById($orderItem->idItem);
      array_push($orderProducts, new OrderItemOutput($product->description, $orderItem->price, $orderItem->quantity));
    }

    $output = new OrderOutput(
      $order->getCode(),
      $order->getTotal(),
      $orderProducts,
      $order->getCoupon(),
      $order->issueDate
    );

    return $output;
  }
}