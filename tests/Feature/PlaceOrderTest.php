<?php declare(strict_types=1);

use App\Application\UseCase\PlaceOrder;
use App\Application\UseCase\PlaceOrderInput;
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
      date: new DateTime("2021-01-01")
    );
    $output = $placeOrder->execute($input);
    $this->assertEquals("202100000001", $output->code);
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