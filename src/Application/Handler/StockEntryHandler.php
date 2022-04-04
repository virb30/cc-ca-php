<?php declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Entity\StockEntry;
use App\Domain\Event\OrderPlaced;
use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\StockEntryRepository;

class StockEntryHandler extends Handler
{
  public string $name = 'OrderPlaced';
  private StockEntryRepository $stockEntryRepository;

  public function __construct(public readonly RepositoryFactory $repositoryFactory)
  {
    $this->stockEntryRepository = $repositoryFactory->createStockEntryRepository();
  }
  
  /**
   * @param OrderPlaced $event
   * @return void
   */
  public function handle($event): void
  {
    foreach($event->order->getItems() as $orderItem) {
      $this->stockEntryRepository->save(new StockEntry($orderItem->idItem, 'out', $orderItem->quantity));
    }
  }
}