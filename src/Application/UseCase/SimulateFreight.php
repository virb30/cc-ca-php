<?php declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\SimulateFreightInput;
use App\Application\UseCase\SimulateFreightOutput;
use App\Domain\Entity\Freight;
use App\Domain\Repository\ProductRepository;
use Exception;

final class SimulateFreight
{
  public function __construct(
    private ProductRepository $productRepository
  ) { }

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