<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Application\UseCase\GetOrder\GetOrder;
use App\Application\UseCase\PlaceOrder\PlaceOrder;
use App\Application\UseCase\PlaceOrder\PlaceOrderInput;
use App\Domain\Factory\RepositoryFactory;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Factory\DatabaseRepositoryFactory;
use DateTime;
use PHPUnit\Framework\TestCase;

class GetOrderTest extends TestCase
{
  private Connection $connection;
  private RepositoryFactory $repositoryFactory;

  protected function setUp(): void
  {
    parent::setUp();
    $this->connection = new PdoMysqlConnectionAdapter();
    $this->repositoryFactory = new DatabaseRepositoryFactory($this->connection);
    $orderRepository = $this->repositoryFactory->createOrderRepository();
    $orderRepository->clean();
  }

  public function testShouldGetOrderByCode()
  {
    $placeOrder = new PlaceOrder($this->repositoryFactory);
    $input = new PlaceOrderInput(
      cpf: "935.411.347-80",
      orderItems: [
        (object) ['idItem' => 1, 'quantity' => 1],
        (object) ['idItem' => 2, 'quantity' => 1],
        (object) ['idItem' => 3, 'quantity' => 3],
      ],
      coupon: "VALE20",
      issueDate: new DateTime("2021-03-01T10:00:00")
    );
    $placeOrder->execute($input);
    $getOrder = new GetOrder($this->repositoryFactory);
    $output = $getOrder->execute('202100000001');
    $this->assertEquals(5132, $output->total);
  }

  protected function tearDown(): void
  {
    parent::tearDown();
    $this->connection->close();
  }
}