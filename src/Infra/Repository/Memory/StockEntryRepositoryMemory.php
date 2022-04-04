<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

use App\Domain\Entity\StockEntry;
use App\Domain\Repository\StockEntryRepository;

class StockEntryRepositoryMemory implements StockEntryRepository
{
  /**
   * @var StockEntry[]
   */
  public array $stockEntries;

  public function __construct()
  {
    $this->stockEntries = [];  
  }

  public function save(StockEntry $stockEntry): void
  {
    array_push($this->stockEntries, $stockEntry);
  }

  public function getAll(int $idItem): array
  {
    return array_filter($this->stockEntries, fn(StockEntry $stockEntry) => $stockEntry->idItem === $idItem); 
  }

  public function clean(): void
  {
    $this->stockEntries = [];
  }
}