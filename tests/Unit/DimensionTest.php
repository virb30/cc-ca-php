<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\Dimension;
use DomainException;
use PHPUnit\Framework\TestCase;

class DimensionTest extends TestCase
{
  public function testShouldCreateDimensions()
  {
    $dimension = new Dimension(100, 30, 10);
    $volume = $dimension->getVolume();
    $this->assertEquals(0.03, $volume);
  }

  public function testShouldThrowsExceptionIfDimensionIsNegative()
  {
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage("Invalid dimensions");
    new Dimension(-100, -30, -10);
  }
}