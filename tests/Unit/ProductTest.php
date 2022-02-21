<?php declare(strict_types=1);

use App\Dimension;
use App\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
  public function testShouldCalculateProductVolume()
  {
    $product = new Product(1, "Instrumentos Musicais", "Guitarra", 1000, new Dimension(100, 30, 10), 3);
    $volume = $product->getVolume();
    $this->assertEquals(0.03, $volume);
  }
  public function testShouldCalculateProductDensity()
  {
    $product = new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000, new Dimension(100, 30, 10), 3);
    $density = $product->getDensity();
    $this->assertEquals(100, $density);
  }
}