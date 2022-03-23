<?php declare(strict_types=1);

namespace App\Application\UseCase\PlaceOrder;

use App\Domain\Entity\Order;
use App\Domain\Factory\RepositoryFactory;
use Exception;

final class PlaceOrder
{
  public function __construct(readonly RepositoryFactory $repositoryFactory) 
  {
    $this->productRepository = $repositoryFactory->createProductRepository();
    $this->couponRepository = $repositoryFactory->createCouponRepository();
    $this->orderRepository = $repositoryFactory->createOrderRepository();
  }

  public function execute(PlaceOrderInput $input): PlaceOrderOutput
  {
    $sequence = $this->orderRepository->count() + 1;
    $order = new Order($input->cpf, $input->issueDate, $sequence);
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
    $output = new PlaceOrderOutput($order->getCode(), $order->getTotal());
    return $output;
  }
}