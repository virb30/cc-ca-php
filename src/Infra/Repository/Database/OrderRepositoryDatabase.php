<?php declare(strict_types=1);

namespace App\Infra\Repository\Database;

use App\Domain\Entity\Cpf;
use App\Domain\Entity\Order;
use App\Domain\Repository\OrderRepository;
use App\Infra\Database\Connection;
use DateTime;
use Exception;

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

  public function getByCode(string $code): Order
  {
    $sql = "SELECT * FROM `order` WHERE `code` = ?";
    $orderData = $this->connection->query($sql, [$code]);

    if(empty($orderData)) {
      throw new Exception('Order not found');
    }

    $order = new Order(
      $orderData['cpf'],
      new DateTime($orderData['issue_date']),
      $orderData['sequence']
    );
    
    return $order;
  }

  /**
   *
   * @param Cpf $cpf
   * @return Order[]
   */
  public function getByCpf(Cpf $cpf): array
  {
    $sql = "SELECT * FROM `order` WHERE `cpf` = ?";
    $ordersData = $this->connection->query($sql, [$cpf]);

    $orders = [];
    foreach($ordersData as $orderData) {
      array_push($orders, new Order(
        $orderData['cpf'],
        new DateTime($orderData['issue_date']),
        $orderData['sequence']
      ));
    }

    return $orders;
  }
}