<?php declare(strict_types=1);

namespace App\Infra\Repository\Database;

use App\Domain\Entity\Coupon;
use App\Domain\Entity\Cpf;
use App\Domain\Entity\Dimension;
use App\Domain\Entity\Order;
use App\Domain\Entity\Product;
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
    $row = $this->connection->query("SELECT COUNT(*) as count FROM `order`", []);
    return $row[0]['count'];
  }

  public function save(Order $order): void
  {
    $coupon = $order->getCoupon();
    $code = $order->getCode();
    $cpf = $order->cpf;
    $issueDate = $order->issueDate->format('Y-m-d H:i:s');
    $freight = $order->getFreight();
    $sequence = $order->sequence;
    $total = $order->getTotal();
    $this->connection->query(
      "INSERT INTO `order` (coupon, code, cpf, issue_date, freight, sequence, total) values (?, ?, ?, ?, ?, ?, ?)", 
      [$coupon, $code, $cpf, $issueDate, $freight, $sequence, $total]
    );
    $idOrder = $this->connection->lastInsertedId();
    foreach($order->getItems() as $item) {
      $this->connection->query(
        "INSERT INTO `order_item` (id_order, id_item, price, quantity) values(?, ?, ?, ?)", 
        [$idOrder, $item->idItem, $item->price, $item->quantity]
      );
    }
  }

  public function clean(): void
  {
    $this->connection->query("DELETE FROM `stock_entry`", []);
    $this->connection->query("DELETE FROM `order_item`", []);
    $this->connection->query("DELETE FROM `order`", []);
  }

  public function getByCode(string $code): Order
  {
    list($orderData) = $this->connection->query(
      "SELECT * FROM `order` WHERE `code` = ?", 
      [$code]
    );
    if(empty($orderData)) throw new Exception('Order not found');
    $order = new Order(
      $orderData['cpf'],
      new DateTime($orderData['issue_date']),
      $orderData['sequence']
    );
    $orderItemsData = $this->connection->query("SELECT * FROM order_item where id_order = ?", [$orderData['id_order']]);
    foreach($orderItemsData as $orderItemData) {
      list($itemData) = $this->connection->query("SELECT * FROM item where id_item = ?", [$orderItemData['id_item']]);
      $item = new Product(
        $itemData['id_item'], 
        $itemData['category'], 
        $itemData['description'], 
        (float) $orderItemData['price'],
        new Dimension($itemData['height'], $itemData['width'], $itemData['length']),
        $itemData['weight']
      );
      $order->addItem($item, $orderItemData['quantity']);
    }
    if($orderData['coupon']) {
      list($couponData) = $this->connection->query("SELECT * FROM coupon where code = ?", [$orderData['coupon']]);
      $coupon = new Coupon($couponData['code'], (float) $couponData['percentage'], new DateTime($couponData['expire_date']));
      $order->applyCoupon($coupon);
    }
    return $order;
  }

  /**
   * @return Order[]
   */
  public function getAll(): array
  {
    $ordersData = $this->connection->query("SELECT * FROM `order`", []);
    $orders = [];
    foreach ($ordersData as $orderData){
      if(empty($orderData)) throw new Exception('Order not found');
      $order = new Order(
        $orderData['cpf'],
        new DateTime($orderData['issue_date']),
        $orderData['sequence']
      );
      $orderItemsData = $this->connection->query("SELECT * FROM order_item where id_order = ?", [$orderData['id_order']]);
      foreach($orderItemsData as $orderItemData) {
        list($itemData) = $this->connection->query("SELECT * FROM item where id_item = ?", [$orderItemData['id_item']]);
        $item = new Product(
          $itemData['id_item'], 
          $itemData['category'], 
          $itemData['description'], 
          (float) $orderItemData['price'],
          new Dimension($itemData['height'], $itemData['width'], $itemData['length']),
          $itemData['weight']
        );
        $order->addItem($item, $orderItemData['quantity']);
      }
      if($orderData['coupon']) {
        list($couponData) = $this->connection->query("SELECT * FROM coupon where code = ?", [$orderData['coupon']]);
        $coupon = new Coupon($couponData['code'], (float) $couponData['percentage'], new DateTime($couponData['expire_date']));
        $order->applyCoupon($coupon);
      }
      array_push($orders, $order);
    }

    return $orders;
  }
}