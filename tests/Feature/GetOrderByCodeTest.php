<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Application\UseCase\GetOrder\GetOrderByCode;
use App\Domain\Entity\Order;
use App\Infra\Repository\Memory\OrderRepositoryMemory;
use App\Infra\Repository\Memory\ProductRepositoryMemory;
use DateTime;
use PHPUnit\Framework\TestCase;

class GetOrderByCodeTest extends TestCase
{
  protected function setUp(): void
  {
    $this->productRepository = new ProductRepositoryMemory();
    $this->orderRepository = new OrderRepositoryMemory();
    $order = new Order("935.411.347-80", new DateTime('2021-01-01'), 1);
    $product = $this->productRepository->getById(1);
    $order->addItem($product, 1);
    $this->orderRepository->save($order);
  }
  public function testShouldGetOrderByCode()
  {
    $code = '202100000001';
    $getOrder = new GetOrderByCode($this->orderRepository, $this->productRepository);
    $order = $getOrder->execute($code);
    $this->assertEquals($code, $order->code);
  }
}