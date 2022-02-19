<?php declare(strict_types=1);

use App\Coupon;
use App\Order;
use App\Product;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
  public function testShouldCreateOrder()
  {
    $order = new Order("935.411.347-80");

    $this->assertInstanceOf(Order::class, $order);
    $this->assertEquals("935.411.347-80", $order->cpf->getValue());
    $this->assertEquals(0, $order->getTotal());
  }

  public function testShouldNotCreateOrderWithInvalidCpf()
  {
    $this->expectException(DomainException::class);
    new Order("111.111.111-11");
  }  

  public function testShouldCreateOrderWithItems()
  {
    $order = new Order("935.411.347-80");
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 10), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Bateria', 10), 4);
    $order->addItem(new Product(3, 'Acessórios', 'Cabo', 10), 5);
    $total = $order->getTotal();
    $this->assertEquals(100, $total);
  }

  public function testShouldCreateOrderWithCoupon()
  {
    $order = new Order("935.411.347-80");
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 10), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Bateria', 10), 4);
    $order->addItem(new Product(3, 'Acessórios', 'Cabo', 10), 5);
    $order->applyCoupon(new Coupon("DISCOUNT10", 10));
    $total = $order->getTotal();
    $this->assertEquals(90, $total);
  }

  public function testShouldNotApplyDiscountIfCouponIsExpired()
  {
    $expireDate = new DateTime('-1 days');
    $order = new Order("935.411.347-80");
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 10), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Bateria', 10), 4);
    $order->addItem(new Product(3, 'Acessórios', 'Cabo', 10), 5);
    $order->applyCoupon(new Coupon("DISCOUNT10", 10, $expireDate));
    $total = $order->getTotal();
    $this->assertEquals(100, $total);
  }
}