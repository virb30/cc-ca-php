<?php declare(strict_types=1);

use App\Coupon;
use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
  public function testPrintCouponMustReturnCouponCode()
  {
    $coupon = new Coupon("VALE20", 20);
    $this->assertEquals("VALE20", (string) $coupon);
  }
}