<?php declare(strict_types=1);

namespace App\Infra\Factory;

use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\CouponRepository;
use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;
use App\Domain\Repository\StockEntryRepository;
use App\Infra\Database\Connection;
use App\Infra\Repository\Database\CouponRepositoryDatabase;
use App\Infra\Repository\Database\OrderRepositoryDatabase;
use App\Infra\Repository\Database\ProductRepositoryDatabase;
use App\Infra\Repository\Database\StockEntryRepositoryDatabase;

class DatabaseRepositoryFactory implements RepositoryFactory
{
  public function __construct(
    public readonly Connection $connection
  ) { }

  public function createCouponRepository(): CouponRepository
  {
    return new CouponRepositoryDatabase($this->connection);
  }

  public function createProductRepository(): ProductRepository
  {
    return new ProductRepositoryDatabase($this->connection);
  }

  public function createOrderRepository(): OrderRepository
  {
    return new OrderRepositoryDatabase($this->connection);
  }

  public function createStockEntryRepository(): StockEntryRepository
  {
    return new StockEntryRepositoryDatabase($this->connection);
  }
}