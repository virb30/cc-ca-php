<?php declare(strict_types=1);

use App\Domain\Entity\Coupon;
use App\Domain\Entity\Dimension;
use App\Domain\Entity\Order;
use App\Domain\Entity\Product;
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
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Amplificador', 5000), 1);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30), 3);
    $total = $order->getTotal();
    $this->assertEquals(6090, $total);
  }

  public function testShouldCreateOrderWithCoupon()
  {
    $order = new Order("935.411.347-80");
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Amplificador', 5000), 1);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30), 3);
    $order->applyCoupon(new Coupon("VALE20", 20));
    $total = $order->getTotal();
    $this->assertEquals(4872, $total);
  }

  public function testShouldCreateOrderWithExpiredCoupon()
  {
    $order = new Order("935.411.347-80", new DateTime('2022-02-21'));
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Amplificador', 5000), 1);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30), 3);
    $order->applyCoupon(new Coupon("VALE20", 20, new DateTime('2022-02-20')));
    $total = $order->getTotal();
    $this->assertEquals(6090, $total);
  }

  public function testShouldCreateOrderWith3ItemsAndCalculateFreight()
  {
    $order = new Order("935.411.347-80");
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000, new Dimension(100, 30, 10), 3), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Amplificador', 5000, new Dimension(100, 50, 50), 20), 1);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30, new Dimension(10, 10, 10), 1), 3);
    $total = $order->getTotal();
    $freight = $order->getFreight();
    $this->assertEquals(6350,$total);
    $this->assertEquals(260, $freight);
  }


  public function testShouldCreateOrderWithCode()
  {
    $issueDate = new DateTime("2022-01-01");
    $sequence = 1;
    $order = new Order("935.411.347-80", $issueDate, $sequence);
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000, new Dimension(100, 30, 10), 3), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Amplificador', 5000, new Dimension(100, 50, 50), 20), 1);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30, new Dimension(10, 10, 10), 1), 3);
    $code = $order->getCode();
    $this->assertEquals("202200000001",$code);
  }

  public function testShouldNotCreateOrderWithDuplicatedItems()
  {
    $order = new Order("935.411.347-80");
    $this->expectException(DomainException::class);
    
    $order->addItem(new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000, new Dimension(100, 30, 10), 3), 1);
    $order->addItem(new Product(2, 'Instrumentos Musicais', 'Amplificador', 5000, new Dimension(100, 50, 50), 20), 1);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30, new Dimension(10, 10, 10), 1), 3);
    $order->addItem(new Product(3, 'Instrumentos Musicais', 'Cabo', 30, new Dimension(10, 10, 10), 1), 3);
  }
}