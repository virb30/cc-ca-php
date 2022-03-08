<?php declare(strict_types=1);

use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Repository\Database\ProductRepositoryDatabase;
use PHPUnit\Framework\TestCase;

class ProductRepositoryDatabaseTest extends TestCase
{
  public function testShouldTestProductRepositoryDatabase()
  {
    $connection = new PdoMysqlConnectionAdapter();
    $productRepository = new ProductRepositoryDatabase($connection);
    $product = $productRepository->getById(1);
    $this->assertEquals('Guitarra', $product->description);
  }
}