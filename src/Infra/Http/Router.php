<?php declare(strict_types=1);

namespace App\Infra\Http;

use App\Domain\Factory\RepositoryFactory;
use App\Infra\Controllers\OrdersController;

class Router
{
  public function __construct(
    public readonly Http $http, 
    public readonly RepositoryFactory $repositoryFactory
  ) {}

  public function init()
  {
    $this->http->route('get', '/orders', function($params, $body) {
      $ordersController = new OrdersController($this->repositoryFactory);
      return $ordersController->getOrders();
    });
  }
}