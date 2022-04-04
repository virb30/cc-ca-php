<?php declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Product;

final class FreightCalculator
{
  const MIN_FREIGHT = 10;

  public static function calculate(Product $item, int $quantity)
  {
    $freight = 1000 * $item->getVolume() * ($item->getDensity() / 100) * $quantity;
    return max($freight, self::MIN_FREIGHT);
  }
}