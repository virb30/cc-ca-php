<?php declare(strict_types=1);

namespace App\Application\UseCase\GetOrder;

use App\Domain\Entity\Cpf;
use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;

final class GetOrdersByCpf
{
  public function __construct(
    private OrderRepository $orderRepository,
    private ProductRepository $productRepository
  )
  { }

  /**
   * @param string $cpf
   * @return OrderOutput[]
   */
  public function execute(string $cpf): array
  {
    $cpf = new Cpf($cpf);
    $orders = $this->orderRepository->getByCpf($cpf);
    $output = [];
    foreach($orders as $order)
    {
      array_push($output, new OrderOutput(
        $order->getCode(),
        $order->issueDate
      ));
    }

    return $output;
  }
}