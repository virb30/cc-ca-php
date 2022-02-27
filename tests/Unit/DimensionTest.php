<?php declare(strict_types=1);

use App\Domain\Entity\Dimension;
use PHPUnit\Framework\TestCase;

class DimensionTest extends TestCase
{
  public function testShouldCreateDimensions()
  {
    $dimension = new Dimension(100, 30, 10);
    $volume = $dimension->getVolume();
    $this->assertEquals(0.03, $volume);
  }
}