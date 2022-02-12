<?php

use App\Example;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
  /**
   * @covers Example::execute
   */
  public function testExampleClassShouldReturnTrue()
  {
    $example = new Example(true);
    
    $this->assertTrue($example->execute());
  }
}