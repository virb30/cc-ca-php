<?php declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Repository\CouponRepository;
use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;
use App\Domain\Repository\StockEntryRepository;

interface RepositoryFactory
{
  public function createProductRepository(): ProductRepository;
  public function createCouponRepository(): CouponRepository;
  public function createOrderRepository(): OrderRepository;
  public function createStockEntryRepository(): StockEntryRepository;
}