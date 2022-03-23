<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrder;

use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\OrderRepository;

class GetOrder
{
  private OrderRepository $orderRepository;

  public function __construct(readonly RepositoryFactory $repositoryFactory) 
  {
    $this->orderRepository = $repositoryFactory->createOrderRepository();
  }

  public function execute(string $code): OrderOutput
  {
    $order = $this->orderRepository->getByCode($code);
    $output = new OrderOutput(
      $order->getTotal(),
      $order->getCode(),
      $order->issueDate
    );
    return $output;
  }
}