<?php declare(strict_types=1);

namespace App\Infra\Repository\Database;

use App\Domain\Entity\Dimension;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepository;
use App\Infra\Database\Connection;

class ProductRepositoryDatabase implements ProductRepository
{
  public function __construct(private Connection $connection)
  {}

  public function getById(int $idItem): ?Product
  {
    $products = $this->connection->query("SELECT * FROM item WHERE id_item = ?", [$idItem]);
    if(empty($products)) return null;
    $product = $products[0];
    $dimension = new Dimension($product['height'], $product['width'], $product['length']);
    return new Product($product['id_item'], $product['category'], $product['description'], (float) $product['price'], $dimension, $product['weight']);
  }
}