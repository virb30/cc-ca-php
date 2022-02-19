<?php declare(strict_types=1);

namespace App;

final class FreightCalculator
{
  const MIN_FREIGHT = 10;

  public static function calculate(Product $item)
  {
    $freight = 1000 * $item->getVolume() * ($item->getDensity() / 100);
    return max($freight, self::MIN_FREIGHT);
  }
}