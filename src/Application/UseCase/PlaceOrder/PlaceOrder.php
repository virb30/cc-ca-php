<?php declare(strict_types=1);

namespace App\Application\UseCase\PlaceOrder;

use App\Domain\Entity\Order;
use App\Domain\Entity\StockEntry;
use App\Domain\Event\OrderPlaced;
use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\CouponRepository;
use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;
use App\Infra\Mediator\Mediator;
use Exception;

final class PlaceOrder
{
  private ProductRepository $productRepository;
  private CouponRepository $couponRepository;
  private OrderRepository $orderRepository;

  public function __construct(readonly RepositoryFactory $repositoryFactory, readonly Mediator $mediator = new Mediator()) 
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
    $this->mediator->publish(new OrderPlaced($order));
    $output = new PlaceOrderOutput($order->getCode(), $order->getTotal());
    return $output;
  }
}