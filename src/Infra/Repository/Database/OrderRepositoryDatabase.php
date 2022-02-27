<?php declare(strict_types=1);

namespace App\Infra\Repository\Database;

use App\Domain\Entity\Order;
use App\Domain\Repository\OrderRepository;
use App\Infra\Database\Connection;

class OrderRepositoryDatabase implements OrderRepository
{
  public function __construct(private Connection $connection)
  { }

  public function count(): int
  {
    $data = $this->connection->query("SELECT COUNT(*) FROM `order`", []);
    var_dump($data);
    return $data[0][0];
  }

  public function save(Order $order): void
  {
    $coupon = $order->getCoupon();
    $code = $order->getCode();
    $cpf = $order->cpf;
    $issueDate = $order->issueDate->format('Y-m-d H:i:s');
    $freight = $order->getFreight();
    $sequence = $order->sequence;
    $sql = "INSERT INTO `order` (id_order, coupon, code, cpf, issue_date, freight, sequence) values (?, ?, ?, ?, ?, ?, ?)";
    $this->connection->query($sql, [$sequence, $coupon, $code, $cpf, $issueDate, $freight, $sequence]);
    foreach($order->getItems() as $item) {
      $sql = "INSERT INTO `order_item` (id_order, id_item, price, quantity) values(?, ?, ?, ?)";
      $this->connection->query($sql, [$sequence, $item->idItem, $item->price, $item->quantity]);
    }
  }
}