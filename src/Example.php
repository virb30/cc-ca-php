<?php declare(strict_types=1);

namespace App;

class Example
{
  public function __construct(
    private bool $isAvailable
  ) {}

  public function execute()
  {
    return $this->isAvailable;
  }
}