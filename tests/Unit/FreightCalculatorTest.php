<?php declare(strict_types=1);

use App\Dimensions;
use App\FreightCalculator;
use App\Product;
use PHPUnit\Framework\TestCase;

class FreightCalculatorTest extends TestCase
{
  public function testShouldCalculateFreight()
  {
    $dimensions = new Dimensions(200, 100, 50);
    $weight = 40;
    $item = new Product(1, 'Eletrodomésticos', 'Geladeira', 10, $dimensions, $weight);

    $freight = FreightCalculator::calculate($item);
    $this->assertEquals(400, $freight);
  }
}