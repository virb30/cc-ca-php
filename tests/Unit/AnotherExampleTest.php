<?php

use App\Example;
use PHPUnit\Framework\TestCase;

class AnotherExampleTest extends TestCase
{
  /**
   * @covers Example::execute
   */
  public function testExampleClassFailing()
  {
    $example = new Example(false);
    
    $this->assertFalse($example->execute());
  }
}