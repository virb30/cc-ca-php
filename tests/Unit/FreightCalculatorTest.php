<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\Dimension;
use App\Domain\Service\FreightCalculator;
use App\Domain\Entity\Product;
use PHPUnit\Framework\TestCase;

class FreightCalculatorTest extends TestCase
{
  public function testShouldCalculateFreightOfAnItem()
  {
    $item = new Product(1, 'Instrumentos Musicais', 'Guitarra', 10, new Dimension(100, 30, 10), 3);
    $freight = FreightCalculator::calculate($item, 2);
    $this->assertEquals(60, $freight);
  }
}