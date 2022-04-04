<?php declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\StockEntry;

class StockCalculator
{
  /**
   * @param StockEntry[] $stockEntries
   * @return int
   */
  public function calculate(array $stockEntries): int
  {
    $total = 0;
    foreach($stockEntries as $stockEntry){
      if($stockEntry->operation === "in") $total += $stockEntry->quantity;
      if($stockEntry->operation === "out") $total -= $stockEntry->quantity;
    }
    return $total;
  }
}