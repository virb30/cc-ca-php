<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\OrderItem;
use DomainException;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
  public function testShouldCreateOrderItem()
  {
    $orderItem = new OrderItem(1, 10, 10);
    $total = $orderItem->getTotal();
    $this->assertEquals(100, $total);
  }

  public function testShouldNotCreateOrderItemWithNegativeQuantity()
  {
    $this->expectException(DomainException::class);
    $orderItem = new OrderItem(1, 10, -1);
  }
}