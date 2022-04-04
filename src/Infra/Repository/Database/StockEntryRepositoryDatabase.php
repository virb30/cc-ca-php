<?php declare(strict_types=1);

namespace App\Infra\Repository\Database;

use App\Domain\Entity\StockEntry;
use App\Domain\Repository\StockEntryRepository;
use App\Infra\Database\Connection;

class StockEntryRepositoryDatabase implements StockEntryRepository
{
  public function __construct(public readonly Connection $connection)
  {
  }

  public function save(StockEntry $stockEntry): void
  {
    $this->connection->query(
      "INSERT INTO `stock_entry` (id_item, operation, quantity) values (?, ?, ?)", 
      [$stockEntry->idItem, $stockEntry->operation, $stockEntry->quantity]
    );
  }

  /**
   * @param integer $idItem
   * @return StockEntry[]
   */
  public function getAll(int $idItem): array
  {
    $stockEntriesData = $this->connection->query("SELECT * FROM `stock_entry` WHERE id_item = ?", [$idItem]);
    $stockEntries = [];
    foreach($stockEntriesData as $stockEntryData) {
      array_push($stockEntries, new StockEntry($stockEntryData['id_item'], $stockEntryData['operation'], $stockEntryData['quantity']));
    }
    return $stockEntries;
  }

  public function clean(): void
  {
    $this->connection->query("DELETE FROM `stock_entry`", []);
  }

}