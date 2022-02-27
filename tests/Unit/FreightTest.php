<?php declare(strict_types=1);

use App\Domain\Entity\Dimension;
use App\Domain\Entity\Freight;
use App\Domain\Entity\Product;
use PHPUnit\Framework\TestCase;

class FreightTest extends TestCase
{
  public function testShouldCalculateFreightOfAnItem()
  {
    $item = new Product(1, 'Instrumentos Musicais', 'Guitarra', 10, new Dimension(100, 30, 10), 3);
    $freight = new Freight();
    $freight->addItem($item, 2);
    $this->assertEquals(60, $freight->getTotal());
  }

  public function testShouldCalculateMinimumFreightOfAnItem()
  {
    $item = new Product(1, 'Instrumentos Musicais', 'Cabo', 30, new Dimension(10, 10, 10), 0.9);
    $freight = new Freight();
    $freight->addItem($item, 1);
    $this->assertEquals(10, $freight->getTotal());
  }


}