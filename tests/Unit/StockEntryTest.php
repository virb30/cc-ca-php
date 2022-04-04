<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\StockEntry;
use PHPUnit\Framework\TestCase;

class StockEntryTest extends TestCase
{
  public function testShouldCreateStockEntry()
  {
    $stockEntry = new StockEntry(1, 'in', 6);
    $this->assertEquals(1, $stockEntry->idItem);
    $this->assertEquals('in', $stockEntry->operation);
    $this->assertEquals(6, $stockEntry->quantity);
  }
}