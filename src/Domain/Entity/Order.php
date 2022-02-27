<?php declare(strict_types=1);

namespace App\Domain\Entity;
use DateTime;
use DateTimeInterface;

final class Order
{
  public readonly Cpf $cpf;
  /**
   * @var Product[]
   */
  private array $items = [];
  private Coupon|null $coupon = null;
  private readonly DateTimeInterface $issueDate;
  private Freight $freight;
  private OrderCode $code;
  
  public function __construct(
    string $cpf, 
    DateTimeInterface $issueDate = new DateTime(),
    int $sequence = 1
  )
  {
    $this->cpf = new Cpf($cpf);    
    $this->issueDate = $issueDate;
    $this->freight = new Freight();
    $this->code = new OrderCode($issueDate, $sequence);
  }

  public function addItem(Product $item, int $quantity)
  {
    $orderItem = new OrderItem($item->getId(), $item->getPrice(), $quantity);
    $this->freight->addItem($item, $quantity);
    array_push($this->items, $orderItem);
  }

  public function applyCoupon(?Coupon $coupon)
  {
    if($coupon && !$coupon->isExpired($this->issueDate)) {
      $this->coupon = $coupon;
    }
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
      $total -= $this->coupon->calculateDiscount($total);
    }

    $total += $this->freight->getTotal();
    return $total;
  }

  public function getCode()
  {
    return $this->code->value;
  }
}