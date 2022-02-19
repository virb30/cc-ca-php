<?php declare(strict_types=1);

use App\Coupon;
use App\Dimensions;
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
    $order = new Order("935.411.347-80", new DateTime('2022-02-21'));
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 10), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Bateria', 10), 4);
    $order->addItem(new Product(3, 'Acessórios', 'Cabo', 10), 5);
    $order->applyCoupon(new Coupon("DISCOUNT10", 10, new DateTime('2022-02-20')));
    $total = $order->getTotal();
    $this->assertEquals(100, $total);
  }

  /**
   * @dataProvider productProvider
   */
  public function testShouldCalculateFreight($products, $expected)
  {
    $order = new Order("935.411.347-80");
    foreach($products as $product) {
      $order->addItem($product, 1);
    }
    $shippingPrice = $order->getFreight();
    $this->assertEquals($expected, $shippingPrice);
  }


  public function productProvider()
  {
    $guitar = new Product(1, 'Instrumentos Musicais', 'Guitarra', 10, new Dimensions(100, 30, 10), 3);
    $camera = new Product(1, 'Eletrônicos', 'Camera', 10, new Dimensions(20, 15, 10), 1);
    $freezer = new Product(1, 'Eletrodomésticos', 'Geladeira', 10, new Dimensions(200, 100, 50), 40);

    return [
      'guitar' => [[$guitar], 30],
      'camera' => [[$camera], 10],
      'freezer' => [[$freezer], 400],
      'all' => [[$guitar, $camera, $freezer], 440]
    ];
  }
}