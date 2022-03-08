<?php declare(strict_types=1);

use App\Domain\Entity\OrderCode;
use PHPUnit\Framework\TestCase;

class OrderCodeTest extends TestCase
{
  public function testShouldCreateOrderCode ()
  {
    $date = new DateTime('2021-03-01T10:00:00');
    $sequence = 1;
    $orderCode = new OrderCode($date, $sequence);
    $this->assertEquals('202100000001', $orderCode->value);
  }
}