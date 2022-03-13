<?php declare(strict_types=1);

use App\Application\UseCase\GetOrder\GetOrdersByCpf;
use App\Domain\Entity\Cpf;
use App\Domain\Entity\Order;
use App\Infra\Repository\Memory\OrderRepositoryMemory;
use App\Infra\Repository\Memory\ProductRepositoryMemory;
use PHPUnit\Framework\TestCase;

class GetOrdersByCpfTest extends TestCase
{
  protected function setUp(): void
  {
    $this->productRepository = new ProductRepositoryMemory();
    $this->orderRepository = new OrderRepositoryMemory();

    $order = new Order("935.411.347-80", new DateTime('2021-01-01'), 1);
    $product = $this->productRepository->getById(1);
    $order->addItem($product, 1);
    $this->orderRepository->save($order);

    $order = new Order("935.411.347-80", new DateTime('2021-01-01'), 2);
    $product = $this->productRepository->getById(2);
    $order->addItem($product, 1);
    $this->orderRepository->save($order);
  }

  public function testShouldGetOrdersByCpf()
  {
    $getOrders = new GetOrdersByCpf($this->orderRepository, $this->productRepository);
    $cpf = "935.411.347-80";
    $orders = $getOrders->execute($cpf);
    $this->assertCount(2, $orders);
  }
}