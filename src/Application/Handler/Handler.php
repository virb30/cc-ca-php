<?php declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Event\DomainEvent;

abstract class Handler
{
  public string $name;
  /**
   * @param DomainEvent $event
   * @return void
   */
  abstract public function handle($event): void;
}