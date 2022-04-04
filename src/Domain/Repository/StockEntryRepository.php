<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\StockEntry;

interface StockEntryRepository
{
  public function save(StockEntry $stockEntry): void;
  /**
   * @param integer $idItem
   * @return StockEntry[]
   */
  public function getAll(int $idItem): array;
  public function clean(): void;
}