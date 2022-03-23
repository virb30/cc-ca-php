<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Repository\CouponRepository;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Repository\Database\CouponRepositoryDatabase;
use PHPUnit\Framework\TestCase;

class CouponRepositoryDatabaseTest extends TestCase
{
  private Connection $connection;
  private CouponRepository $couponRepository;

  protected function setUp(): void
  {
    $this->connection = new PdoMysqlConnectionAdapter();
    $this->couponRepository = new CouponRepositoryDatabase($this->connection);
  }
  public function testShouldTestCouponRepository()
  {
    $coupon = $this->couponRepository->getByCode("VALE20");
    $this->assertEquals(20, $coupon->getPercentage());
  }

  protected function tearDown(): void
  {
    parent::tearDown();
    $this->connection->close();
  }
}