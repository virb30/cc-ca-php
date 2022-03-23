<?php declare(strict_types=1);

namespace Tests\Unit;

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

  public function testShouldNotCreateDimensionWithNegativeHeight()
  {
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage("Height cannot be negative");
    new Dimension(-100, 30, 10);
  }

  public function testShouldNotCreateDimensionWithNegativeWidth()
  {
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage("Width cannot be negative");
    new Dimension(100, -30, 10);
  }

  public function testShouldNotCreateDimensionWithNegativeLength()
  {
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage("Length cannot be negative");
    new Dimension(100, 30, -10);
  }
}