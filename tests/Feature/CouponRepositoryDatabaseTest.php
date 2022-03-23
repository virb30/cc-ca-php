<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Repository\Database\CouponRepositoryDatabase;
use PHPUnit\Framework\TestCase;

class CouponRepositoryDatabaseTest extends TestCase
{
  public function testShouldTestCouponRepository()
  {
    $connection = new PdoMysqlConnectionAdapter();
    $couponRepository = new CouponRepositoryDatabase($connection);
    $coupon = $couponRepository->getByCode("VALE20");
    $this->assertEquals(20, $coupon->getPercentage());
  }
}