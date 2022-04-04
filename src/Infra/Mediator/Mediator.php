<?php declare(strict_types=1);

namespace App\Infra\Mediator;

use App\Application\Handler\Handler;
use App\Domain\Event\DomainEvent;

class Mediator 
{
  /**
   * @var Handler[]
   */
  public array $handlers;

  public function __construct()
  {
    $this->handlers = [];
  }

  public function register(Handler $handler)
  {
    array_push($this->handlers, $handler);
  }

  public function publish(DomainEvent $event)
  {
    foreach ($this->handlers as $handler) {
      if ($handler->name === $event->name) {
        $handler->handle($event);
      }
    }
  }
}