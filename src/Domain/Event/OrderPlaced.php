<?php declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Entity\Order;

class OrderPlaced extends DomainEvent
{
  public string $name = 'OrderPlaced';

  public function __construct(public readonly Order $order)
  {
    
  }
}