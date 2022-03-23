<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\Coupon;
use DateTime;
use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
  public function testPrintCouponMustReturnCouponCode()
  {
    $coupon = new Coupon("VALE20", 20);
    $this->assertEquals("VALE20", (string) $coupon);
  }

  public function testShouldCreateAValidCoupon()
  {
    $coupon = new Coupon("VALE20", 20, new DateTime('2022-02-19T10:00:00'));
    $today = new DateTime('2022-02-19T10:00:00');
    $this->assertFalse($coupon->isExpired($today));
  }

  public function testShouldCreateAnExpiredCoupon()
  {
    $coupon = new Coupon("VALE20", 20, new DateTime('2022-02-19T10:00:00'));
    $today = new DateTime('2022-02-20');
    $this->assertTrue($coupon->isExpired($today));
  }

  public function testShouldApplyDiscount()
  {
    $coupon = new Coupon("VALE10", 10, new DateTime('2022-02-19'));
    $discount = $coupon->calculateDiscount(100);
    $this->assertEquals(10, $discount);
  }
}