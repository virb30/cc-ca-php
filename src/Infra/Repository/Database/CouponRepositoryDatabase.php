<?php declare(strict_types=1);

namespace App\Infra\Repository\Database;

use App\Domain\Entity\Coupon;
use App\Domain\Repository\CouponRepository;
use App\Infra\Database\Connection;
use DateTime;

class CouponRepositoryDatabase implements CouponRepository
{
  public function __construct(private Connection $connection)
  { }

  public function getByCode(string $code): ?Coupon
  {
    $couponData = $this->connection->query("SELECT * FROM coupon WHERE code = ?", [$code]); 
    if(empty($couponData)) return null;
    $coupon = $couponData[0];
    return new Coupon($coupon['code'], (float) $coupon['percentage'], new DateTime($coupon['expire_date']));
  }
}