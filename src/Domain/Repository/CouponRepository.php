<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Coupon;

interface CouponRepository
{
  public function getByCode(string $code): ?Coupon;
}