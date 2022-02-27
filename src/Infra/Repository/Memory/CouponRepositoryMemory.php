<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

use App\Domain\Entity\Coupon;
use App\Domain\Repository\CouponRepository;
use App\Helpers\Arr;
use DateTime;

final class CouponRepositoryMemory implements CouponRepository
{
  /**
   * @var Coupon[]
   */
  private array $coupons = [];

  public function __construct()
  {
    $this->coupons = [
      new Coupon("VALE20", 20),
      new Coupon("VALE20VENCIDO", 20, new DateTime('2022-01-01'))
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