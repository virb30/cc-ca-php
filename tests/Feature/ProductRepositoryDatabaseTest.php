<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Repository\ProductRepository;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Repository\Database\ProductRepositoryDatabase;
use PHPUnit\Framework\TestCase;

class ProductRepositoryDatabaseTest extends TestCase
{
  private Connection $connection;
  private ProductRepository $productRepository;

  protected function setUp(): void
  {
    $this->connection = new PdoMysqlConnectionAdapter();
    $this->productRepository = new ProductRepositoryDatabase($this->connection);
  }

  public function testShouldTestProductRepositoryDatabase()
  {  
    $product = $this->productRepository->getById(1);
    $this->assertEquals('Guitarra', $product->description);
  }

  protected function tearDown(): void
  {
    parent::tearDown();
    $this->connection->close();
  }
}