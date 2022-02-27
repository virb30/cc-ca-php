<?php declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\Order;
use App\Domain\Repository\CouponRepository;
use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;
use Exception;

final class PlaceOrder
{
  public function __construct(
    private ProductRepository $productRepository,
    private OrderRepository $orderRepository,
    private CouponRepository $couponRepository
  ) {}

  public function execute(PlaceOrderInput $input): PlaceOrderOutput
  {
    $order = new Order($input->cpf);
    foreach($input->orderItems as $orderItem){
      $product = $this->productRepository->getById($orderItem->idItem);
      if(!$product) throw new Exception("Product not found");
      $order->addItem($product, $orderItem->quantity);
    }
    if($input->coupon){
      $coupon = $this->couponRepository->getByCode($input->coupon);
      $order->applyCoupon($coupon);
    }
    $this->orderRepository->save($order);
    $output = new PlaceOrderOutput($order->getTotal());
    return $output;
  }
}