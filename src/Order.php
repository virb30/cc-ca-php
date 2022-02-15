<?php declare(strict_types=1);

namespace App;
use App\Cpf;
use App\OrderItem;
use App\Coupon;

final class Order
{
  public Cpf $cpf;
  /**
   * @var Product[]
   */
  private array $items = [];
  private Coupon|null $coupon = null;

  public function __construct(string $cpf)
  {
    $this->cpf = new Cpf($cpf);    
  }

  public function addItem(Product $item, int $quantity)
  {
    $orderItem = new OrderItem($item->getId(), $item->getPrice(), $quantity);
    array_push($this->items, $orderItem);
  }

  public function applyCoupon(Coupon $coupon)
  {
    $this->coupon = $coupon;
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
        return $acc + $item->getTotal();
      }, 0);

    if(!!$this->coupon){
      $total -= $total * $this->coupon->getPercentage() / 100;
    }

    return $total;
  }
}