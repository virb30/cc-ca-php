<?php declare(strict_types=1);

namespace App\Domain\Entity;

use App\Support\Arr;
use DateTime;
use DateTimeInterface;
use DomainException;

final class Order
{
  public readonly Cpf $cpf;
  /**
   * @var OrderItem[]
   */
  private array $items = [];
  private Coupon|null $coupon = null;
  public readonly DateTimeInterface $issueDate;
  private Freight $freight;
  private OrderCode $code;
  public readonly int $sequence;
  
  public function __construct(
    string $cpf, 
    DateTimeInterface $issueDate = new DateTime(),
    int $sequence = 1
  )
  {
    $this->cpf = new Cpf($cpf);    
    $this->issueDate = $issueDate;
    $this->freight = new Freight();
    $this->sequence = $sequence;
    $this->code = new OrderCode($issueDate, $sequence);
  }

  public function addItem(Product $item, int $quantity)
  {
    $itemExists = Arr::exists($this->items, fn($orderItem) => $orderItem->idItem === $item->getId());
    if($itemExists) throw new DomainException("Duplicated item");
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

    $total += $this->getFreight();
    return $total;
  }

  public function getFreight()
  {
    return $this->freight->getTotal();
  }

  public function getCode()
  {
    return $this->code->value;
  }

  public function getCoupon()
  {
    if(!$this->coupon) return null;
    return $this->coupon->code;
  }
}