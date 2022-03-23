<?php declare(strict_types=1);

namespace App\Application\UseCase\SimulateFreight;

use App\Domain\Entity\Freight;
use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\ProductRepository;
use Exception;

final class SimulateFreight
{
  private ProductRepository $productRepository;

  public function __construct(readonly RepositoryFactory $repositoryFactory)
  {
    $this->productRepository = $repositoryFactory->createProductRepository();
  }

  public function execute(SimulateFreightInput $input): SimulateFreightOutput
  {
    $freight = new Freight();
    foreach ($input->orderItems as $orderItem) {
      $item = $this->productRepository->getById($orderItem->idItem);
      if(!$item) throw new Exception("Product not found");
      $freight->addItem($item, $orderItem->quantity);
    }
    $output = new SimulateFreightOutput($freight->getTotal());
    return $output;
  }
}