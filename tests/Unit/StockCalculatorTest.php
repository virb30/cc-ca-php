<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\StockEntry;
use App\Domain\Service\StockCalculator;
use PHPUnit\Framework\TestCase;

class StockCalculatorTest extends TestCase
{
  public function testShouldCalculateStockOfAnItem()
  {
    $calculator = new StockCalculator();
    $stockEntries = [
      new StockEntry(1, 'in', 6),
      new StockEntry(1, 'out', 2),
      new StockEntry(1, 'in', 2),
    ];
    $total = $calculator->calculate($stockEntries);
    $this->assertEquals(6, $total);
  }
}