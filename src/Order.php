<?php declare(strict_types=1);

namespace App;
use App\Cpf;
use InvalidArgumentException;

final class Order
{
  private array $items = [];
  private ?Cupom $cupom;
  private Cpf $cpf;

  public function __construct(string $cpf, array $items = [], ?Cupom $cupom = null)
  {
    $this->cpf = new Cpf($cpf);

    if(empty($items)) {
      throw new InvalidArgumentException("You must have at least one item");
    }

    $this->items = $items;
    $this->cupom = $cupom;
  }

  public function getItems()
  {
    return $this->items;
  }

  public function getTotal()
  {
    $total = array_reduce(
      $this->items, 
      function ($acc, $item) {
        return $acc + ($item->getPrice() * $item->getQuantity());
      }, 0);

    if($this->cupom){
      $total = $this->applyCupom($total);
    }

    return $total;
  }

  private function applyCupom(float $total)
  {
    return $total - ($total * $this->cupom->getPercent() / 100);
  }
}