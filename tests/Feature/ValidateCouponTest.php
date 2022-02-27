<?php declare(strict_types=1);

use App\Application\UseCase\ValidateCoupon;
use App\Infra\Repository\Memory\CouponRepositoryMemory;
use PHPUnit\Framework\TestCase;

class ValidateCouponTest extends TestCase
{
  public function testShouldValidateCoupon()
  {
    $couponRepository = new CouponRepositoryMemory();
    $validateCoupon = new ValidateCoupon($couponRepository);
    $this->assertTrue($validateCoupon->execute("VALE20"));
  }

  public function testShouldNotValidateCouponIfNotFound()
  {
    $couponRepository = new CouponRepositoryMemory();
    $validateCoupon = new ValidateCoupon($couponRepository);
    $this->assertFalse($validateCoupon->execute("VALE50"));
  }

  public function testShouldNotValidateCouponIfExpired()
  {
    $couponRepository = new CouponRepositoryMemory();
    $validateCoupon = new ValidateCoupon($couponRepository);
    $this->assertFalse($validateCoupon->execute("VALE20VENCIDO"));
  }
}