<?php declare(strict_types=1);

use App\Application\UseCase\ValidateCoupon\ValidateCoupon;
use App\Domain\Factory\RepositoryFactory;
use App\Infra\Database\Connection;
use App\Infra\Factory\MemoryRepositoryFactory;
use App\Infra\Repository\Memory\CouponRepositoryMemory;
use PHPUnit\Framework\TestCase;

class ValidateCouponTest extends TestCase
{
  private Connection $connection;
  private RepositoryFactory $repositoryFactory;

  protected function setUp(): void
  {
    $this->repositoryFactory = new MemoryRepositoryFactory();
  }

  public function testShouldValidateCoupon()
  {
    $validateCoupon = new ValidateCoupon($this->repositoryFactory);
    $isValid = $validateCoupon->execute("VALE20");
    $this->assertTrue($isValid);
  }

  public function testShouldNotValidateCouponIfNotFound()
  {
    $validateCoupon = new ValidateCoupon($this->repositoryFactory);
    $this->assertFalse($validateCoupon->execute("VALE50"));
  }

  public function testShouldNotValidateCouponIfExpired()
  {
    $validateCoupon = new ValidateCoupon($this->repositoryFactory);
    $this->assertFalse($validateCoupon->execute("VALE20VENCIDO"));
  }
}