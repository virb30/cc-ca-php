<?php declare(strict_types=1);

use App\Application\UseCase\PlaceOrder\PlaceOrder;
use App\Application\UseCase\PlaceOrder\PlaceOrderInput;
use App\Infra\Repository\Memory\CouponRepositoryMemory;
use App\Infra\Repository\Memory\OrderRepositoryMemory;
use App\Infra\Repository\Memory\ProductRepositoryMemory;
use PHPUnit\Framework\TestCase;

class PlaceOrderTest extends TestCase
{
  protected function setUp(): void
  {
    parent::setUp();
    // $connection = new PdoMysqlConnectionAdapter();
    $this->productRepository = new ProductRepositoryMemory();
    $this->orderRepository = new OrderRepositoryMemory();
    $this->couponRepository = new CouponRepositoryMemory();
  }
  public function testShouldPlaceOrder () 
  {
    $placeOrder = new PlaceOrder(
      $this->productRepository,
      $this->orderRepository,
      $this->couponRepository
    );
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
    $placeOrder = new PlaceOrder(
      $this->productRepository,
      $this->orderRepository,
      $this->couponRepository
    );
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
    $placeOrder = new PlaceOrder(
      $this->productRepository,
      $this->orderRepository,
      $this->couponRepository
    );
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
}