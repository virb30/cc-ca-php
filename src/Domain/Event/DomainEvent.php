<?php declare(strict_types=1);

namespace App\Domain\Event;

abstract class DomainEvent
{
  public string $name;
}