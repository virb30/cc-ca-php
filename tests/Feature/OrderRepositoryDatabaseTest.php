<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Entity\Coupon;
use App\Domain\Entity\Dimension;
use App\Domain\Entity\Order;
use App\Domain\Entity\Product;
use App\Domain\Repository\OrderRepository;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Repository\Database\OrderRepositoryDatabase;
use App\Infra\Repository\Memory\OrderRepositoryMemory;
use DateTime;
use PHPUnit\Framework\TestCase;

class OrderRepositoryDatabaseTest extends TestCase
{
  private Connection $connection;
  private OrderRepository $orderRepository;

  protected function setUp(): void
  {
    $this->connection = new PdoMysqlConnectionAdapter();
    $this->orderRepository = new OrderRepositoryDatabase($this->connection);
    // $this->orderRepository = new OrderRepositoryMemory();
  }

  public function testShouldSaveOrder()
  {
    $this->orderRepository->clean();
    $order = new Order("935.411.347-80", new DateTime("2021-03-01T10:00:00"), 1);
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000, new Dimension(100, 30, 10), 3), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Amplificador', 5000, new Dimension(100, 50, 50), 20), 1);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30, new Dimension(10, 10, 10), 1), 3);
    $order->applyCoupon(new Coupon("VALE20", 20));
    $this->orderRepository->save($order);
    $count = $this->orderRepository->count();
    $this->assertEquals(1, $count);
    $savedOrder = $this->orderRepository->getByCode("202100000001");
    $this->assertEquals("202100000001", $savedOrder->getCode());
    $this->assertEquals(5132, $savedOrder->getTotal());
    $this->assertEquals(260, $savedOrder->getFreight());
  }

  protected function tearDown(): void
  {
    parent::tearDown();
    $this->connection->close();
  }
}