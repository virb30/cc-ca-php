<?php declare(strict_types=1);

use App\Dimensions;
use App\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
  public function testShouldCalculateProductDensity()
  {
    $product = new Product(1, 'Instrumentos Musicais', 'Guitarra', 10, new Dimensions(100, 30, 10), 3);
    $density = $product->getDensity();
    $this->assertEquals(100, $density);
  }

  public function testShouldCalculateProductVolume()
  {
    $product = new Product(1, 'Instrumentos Musicais', 'Guitarra', 10, new Dimensions(100, 30, 10), 3);
    $volume = $product->getVolume();
    $this->assertEquals(0.03, $volume);
  }
}