<?php declare(strict_types=1);

namespace App\Application\UseCase\ValidateCoupon;
use App\Domain\Repository\CouponRepository;

final class ValidateCoupon
{
  public function __construct(
    private readonly CouponRepository $couponRepository
  ) { }

  public function execute(string $code): bool
  {
    $coupon = $this->couponRepository->getByCode($code);
    if (!$coupon) return false;
    return !$coupon->isExpired();
  }
}