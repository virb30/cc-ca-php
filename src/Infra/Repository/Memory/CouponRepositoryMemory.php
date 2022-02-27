<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

use App\Domain\Entity\Coupon;
use App\Domain\Repository\CouponRepository;
use App\Helpers\Arr;

final class CouponRepositoryMemory implements CouponRepository
{
  /**
   * @var Coupon[]
   */
  private array $coupons = [];

  public function __construct()
  {
    $this->coupons = [
      new Coupon("VALE20", 20)
    ];
  }

  public function getByCode(string $code): ?Coupon
  {
    return Arr::find(
      $this->coupons, 
      fn(Coupon $coupon) => $coupon->code === $code
    );
  }
}