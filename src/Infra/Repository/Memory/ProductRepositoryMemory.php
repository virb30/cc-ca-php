<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

use App\Domain\Entity\Dimension;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepository;
use App\Helpers\Arr;

final class ProductRepositoryMemory implements ProductRepository
{
  /**
   * @var Product[]
   */
  private array $products;

  public function __construct()
  {
    $this->products = [
      new Product(1, "Instrumentos Musicais", "Guitarra", 1000, new Dimension(100, 30, 10), 3),
      new Product(2, "Instrumentos Musicais", "Amplificador", 5000, new Dimension(100, 50, 50), 20),
      new Product(3, "Instrumentos Musicais", "Cabo", 30, new Dimension(10, 10, 10), 1),
    ];
  }

  public function getById(int $idItem): ?Product
  {
    return Arr::find(
      $this->products, 
      fn(Product $product) => $product->id === $idItem
    );
  }
}