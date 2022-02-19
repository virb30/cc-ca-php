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

  public function testCouponIsNotExpired()
  {
    $expireDate = new DateTime();
    $coupon = new Coupon("VALE20", 20, $expireDate);
    $this->assertFalse($coupon->isExpired());
  }

  public function testCouponIsExpired()
  {
    $expireDate = new DateTime('-1 days'); 
    $coupon = new Coupon("VALE20", 20, $expireDate);
    $this->assertTrue($coupon->isExpired());
  }
}