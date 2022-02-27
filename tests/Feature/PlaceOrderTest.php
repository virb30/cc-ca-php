<?php declare(strict_types=1);

use App\Application\UseCase\PlaceOrder;
use App\Application\UseCase\PlaceOrderInput;
use App\Infra\Repository\Memory\CouponRepositoryMemory;
use App\Infra\Repository\Memory\OrderRepositoryMemory;
use App\Infra\Repository\Memory\ProductRepositoryMemory;
use PHPUnit\Framework\TestCase;

class PlaceOrderTest extends TestCase
{
  public function testShouldPlaceOrder () 
  {
    $productRepository = new ProductRepositoryMemory();
    $orderRepository = new OrderRepositoryMemory();
    $couponRepository = new CouponRepositoryMemory();
    $placeOrder = new PlaceOrder(
      $productRepository,
      $orderRepository,
      $couponRepository
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
    $this->assertEquals(4872, $output->total);
  }
}