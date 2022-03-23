<?php declare(strict_types=1);

namespace App\Infra\Controllers;

use App\Application\UseCase\GetOrders\GetOrders;
use App\Domain\Factory\RepositoryFactory;

class OrdersController
{
  public function __construct(readonly RepositoryFactory $repositoryFactory)
  { }

  /**
   * @return GetOrderOutput[]
   */
  public function getOrders(): array
  {
    $getOrders = new GetOrders($this->repositoryFactory);
    $output = $getOrders->execute();
    return $output;
  }
}