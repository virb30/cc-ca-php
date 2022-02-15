<?php declare(strict_types=1);

use App\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
  public function testShouldCreateOrderItem()
  {
    $orderItem = new OrderItem(1, 10, 10);
    $total = $orderItem->getTotal();
    $this->assertEquals(100, $total);
  }
}