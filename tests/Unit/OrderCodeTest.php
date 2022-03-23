<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\OrderCode;
use DateTime;
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