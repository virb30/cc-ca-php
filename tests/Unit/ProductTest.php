<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\Dimension;
use App\Domain\Entity\Product;
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

  public function testShouldNotCreateProductWithNegativeWeight()
  {
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage("Weight cannot be negative");
    new Product(1, 'Instrumentos Musicais', 'Guitarra', 1000, new Dimension(100, 30, 10), -3);
  }
}