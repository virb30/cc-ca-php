<?php declare(strict_types=1);

use App\Cupom;
use App\Order;
use App\Product;
use PHPUnit\Framework\TestCase;

// Order
// Cupom
// Item

class PlaceOrderTest extends TestCase
{

  public function testShouldNotPlaceOrderWithInvalidCpf()
  {
    $this->expectException(DomainException::class);
    new Order("111.111.111-11", []);
  }

  public function testShouldNotPlaceOrderWithoutItems()
  {
    $this->expectException(InvalidArgumentException::class);
    new Order("935.411.347-80", []);
  }

  public function testShouldPlaceOrder()
  {
    $items = [
      new Product('Product 1', 10, 1),
      new Product('Product 2', 10, 4),
      new Product('Product 3', 10, 5)
    ];

    $order = new Order("935.411.347-80", $items);

    $this->assertInstanceOf(Order::class, $order);
    $this->assertCount(3, $order->getItems());
    $this->assertEquals(100, $order->getTotal());
  }

  public function testShouldPlaceOrderWithCupom()
  {
    $items = [
      new Product('Product 1', 10, 1),
      new Product('Product 2', 10, 4),
      new Product('Product 3', 10, 5)
    ];
    $cupom = new Cupom("DISCOUNT10", 10);
    
    $order = new Order("935.411.347-80", $items, $cupom);

    $this->assertEquals(90, $order->getTotal());
  }
}