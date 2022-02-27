<?php declare(strict_types=1);

namespace App\Infra\Repository\Memory;

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
      new Product(1, "Instrumentos Musicais", "Guitarra", 1000),
      new Product(2, "Instrumentos Musicais", "Amplificador", 5000),
      new Product(3, "Instrumentos Musicais", "Cabo", 30),
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