<?php declare(strict_types=1);

namespace App;
use App\Cpf;
use App\OrderItem;
use App\Coupon;
use DateTime;
use DateTimeInterface;

final class Order
{
  public Cpf $cpf;
  /**
   * @var Product[]
   */
  private array $items = [];
  private Coupon|null $coupon = null;
  private DateTimeInterface $orderDate;
  private $freight = 0;
  
  public function __construct(string $cpf, DateTimeInterface $orderDate = new DateTime())
  {
    $this->cpf = new Cpf($cpf);    
    $this->orderDate = $orderDate;
  }

  public function addItem(Product $item, int $quantity)
  {
    $orderItem = new OrderItem($item->getId(), $item->getPrice(), $quantity);
    $this->freight += FreightCalculator::calculate($item) * $quantity;
    array_push($this->items, $orderItem);
  }

  public function applyCoupon(Coupon $coupon)
  {
    if($coupon->isExpired($this->orderDate)) return;
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
      $total = $this->coupon->applyDiscount($total);
    }

    return $total;
  }

  public function getFreight()
  {
    return $this->freight;
  }
}