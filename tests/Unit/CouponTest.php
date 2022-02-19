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

  public function testCouponIsValid()
  {
    $coupon = new Coupon("VALE20", 20, new DateTime('2022-02-19'));
    $today = new DateTime('2022-02-18');
    $this->assertTrue($coupon->isValid($today));
  }

  public function testCouponIsExpired()
  {
    $coupon = new Coupon("VALE20", 20, new DateTime('2022-02-19'));
    $today = new DateTime('2022-02-20');
    $this->assertTrue($coupon->isExpired($today));
  }

  public function testShouldApplyDiscount()
  {
    $coupon = new Coupon("VALE10", 10, new DateTime('2022-02-19'));
    $total = $coupon->applyDiscount(100);
    $this->assertEquals(90, $total);
  }
}