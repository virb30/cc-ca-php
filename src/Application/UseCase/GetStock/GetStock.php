<?php declare(strict_types=1);

namespace App\Application\UseCase\GetStock;

use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\StockEntryRepository;
use App\Domain\Service\StockCalculator;

class GetStock
{
  public StockEntryRepository $stockEntryRepository;

  public function __construct(readonly RepositoryFactory $repositoryFactory) 
  {
    $this->stockEntryRepository = $repositoryFactory->createStockEntryRepository();

  }

  public function execute(int $idItem): int
  {
    $stockEntries = $this->stockEntryRepository->getAll($idItem);
    $calculator = new StockCalculator();
    $total = $calculator->calculate($stockEntries);
    return $total;
  }
}