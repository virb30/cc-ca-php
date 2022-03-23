<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrders;

use App\Application\UseCase\GetOrder\GetOrderOutput;
use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\OrderRepository;

final class GetOrders
{
  private OrderRepository $orderRepository;

  public function __construct(readonly RepositoryFactory $repositoryFactory) 
  {
    $this->orderRepository = $repositoryFactory->createOrderRepository();
  }

  /**
   * @return GetOrderOutput[]
   */
  public function execute(): array
  {
    $orders = $this->orderRepository->getAll();
    $output = [];
    foreach($orders as $order)
    {
      array_push($output, new GetOrderOutput(
        $order->getTotal(),
        $order->getCode(),
        $order->issueDate
      ));
    }
    return $output;
  }
}