<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Entity\StockEntry;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Repository\Database\StockEntryRepositoryDatabase;
use Tests\TestCase;

class StockEntryRepositoryDatabaseTest extends TestCase
{
  private Connection $connection;

  protected function setUp(): void
  {
    $this->connection = new PdoMysqlConnectionAdapter();
  }

  public function testShouldPersistAStockEntry()
  {
    $stockEntryRepository = new StockEntryRepositoryDatabase($this->connection);
    $stockEntryRepository->clean();
    $stockEntryRepository->save(new StockEntry(1, "in", 6));
    $stockEntryRepository->save(new StockEntry(1, "out", 2));
    $stockEntryRepository->save(new StockEntry(1, "in", 2));
    $stockEntries = $stockEntryRepository->getAll(1);
    $this->assertCount(3, $stockEntries);
  }

  protected function tearDown(): void
  {
    $this->connection->close();
  }
}