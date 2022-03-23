<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Application\UseCase\PlaceOrder\PlaceOrder;
use App\Application\UseCase\PlaceOrder\PlaceOrderInput;
use App\Domain\Factory\RepositoryFactory;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Factory\DatabaseRepositoryFactory;
use Tests\TestCase;

class HttpTest extends TestCase
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
  public function testShouldTestApi()
  {
    $placeOrder = new PlaceOrder($this->repositoryFactory);
    $input = new PlaceOrderInput(
      cpf: "935.411.347-80",
      orderItems: [
        (object) ['idItem' => 1, 'quantity' => 1],
        (object) ['idItem' => 2, 'quantity' => 1],
        (object) ['idItem' => 3, 'quantity' => 3],
      ],
      coupon: "VALE20"
    );
    $placeOrder->execute($input);
    $placeOrder->execute($input);
    $placeOrder->execute($input);
    $response = $this->get('/orders');
    $orders = json_decode((string) $response->getBody());
    $this->assertCount(3, $orders);
  }
}