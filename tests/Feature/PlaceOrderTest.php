<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Application\Handler\StockEntryHandler;
use App\Application\UseCase\GetStock\GetStock;
use App\Application\UseCase\PlaceOrder\PlaceOrder;
use App\Application\UseCase\PlaceOrder\PlaceOrderInput;
use App\Domain\Factory\RepositoryFactory;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Factory\DatabaseRepositoryFactory;
use App\Infra\Mediator\Mediator;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class PlaceOrderTest extends TestCase
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
  public function testShouldPlaceOrder () 
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
    $output = $placeOrder->execute($input);
    $this->assertEquals(5132, $output->total);
  }

  public function testShouldPlaceOrderWithCode () 
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
      issueDate: new DateTime("2021-01-01T10:00:00")
    );
    $placeOrder->execute($input);
    $output = $placeOrder->execute($input);
    $this->assertEquals("202100000002", $output->code);
  }

  public function testShouldThrowsIfProductNotFound () 
  {
    $placeOrder = new PlaceOrder($this->repositoryFactory);
    $input = new PlaceOrderInput(
      cpf: "935.411.347-80",
      orderItems: [
        (object) ['idItem' => 1, 'quantity' => 1],
        (object) ['idItem' => 2, 'quantity' => 1],
        (object) ['idItem' => 3, 'quantity' => 3],
        (object) ['idItem' => 4, 'quantity' => 3],
      ],
      coupon: "VALE20"
    );

    $this->expectException(Exception::class);
    $placeOrder->execute($input);
  }

  public function testShouldPlaceOrderAndWithdrawItemsFromStock () 
  {
    $mediator = new Mediator();
    $mediator->register(new StockEntryHandler($this->repositoryFactory));
    $placeOrder = new PlaceOrder($this->repositoryFactory, $mediator);
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
    $getStock = new GetStock($this->repositoryFactory);
    $total1 = $getStock->execute(1);
    $this->assertEquals(-1, $total1);
    $total2 = $getStock->execute(2);
    $this->assertEquals(-1, $total2);
    $total3 = $getStock->execute(3);
    $this->assertEquals(-3, $total3);
  }
}