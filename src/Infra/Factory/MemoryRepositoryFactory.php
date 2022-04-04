<?php declare(strict_types=1);

namespace App\Infra\Factory;

use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\CouponRepository;
use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;
use App\Domain\Repository\StockEntryRepository;
use App\Infra\Repository\Memory\CouponRepositoryMemory;
use App\Infra\Repository\Memory\OrderRepositoryMemory;
use App\Infra\Repository\Memory\ProductRepositoryMemory;

class MemoryRepositoryFactory implements RepositoryFactory
{
  public function createCouponRepository(): CouponRepository
  {
    return new CouponRepositoryMemory();
  }

  public function createProductRepository(): ProductRepository
  {
    return new ProductRepositoryMemory();
  }

  public function createOrderRepository(): OrderRepository
  {
    return new OrderRepositoryMemory();
  }

  public function createStockEntryRepository(): StockEntryRepository
  {
    return new StockEntryRepositoryMemory();
  }
}