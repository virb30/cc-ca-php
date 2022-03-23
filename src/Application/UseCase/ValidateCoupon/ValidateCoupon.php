<?php declare(strict_types=1);

namespace App\Application\UseCase\ValidateCoupon;

use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\CouponRepository;

final class ValidateCoupon
{
  private readonly CouponRepository $couponRepository;

  public function __construct(readonly RepositoryFactory $repositoryFactory) 
  { 
    $this->couponRepository = $repositoryFactory->createCouponRepository();
  }

  public function execute(string $code): bool
  {
    $coupon = $this->couponRepository->getByCode($code);
    if (!$coupon) return false;
    return !$coupon->isExpired();
  }
}