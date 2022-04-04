<?php declare(strict_types=1);

namespace App\Application\UseCase\PlaceOrder;

use App\Domain\Entity\Order;
use App\Domain\Entity\StockEntry;
use App\Domain\Factory\RepositoryFactory;
use App\Domain\Repository\CouponRepository;
use App\Domain\Repository\OrderRepository;
use App\Domain\Repository\ProductRepository;
use App\Domain\Repository\StockEntryRepository;
use Exception;

final class PlaceOrder
{
  private ProductRepository $productRepository;
  private CouponRepository $couponRepository;
  private OrderRepository $orderRepository;
  private StockEntryRepository $stockEntryRepository;

  public function __construct(readonly RepositoryFactory $repositoryFactory) 
  {
    $this->productRepository = $repositoryFactory->createProductRepository();
    $this->couponRepository = $repositoryFactory->createCouponRepository();
    $this->orderRepository = $repositoryFactory->createOrderRepository();
    $this->stockEntryRepository = $repositoryFactory->createStockEntryRepository();
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
    foreach($input->orderItems as $orderItem) {
      $this->stockEntryRepository->save(new StockEntry($orderItem->idItem, 'out', $orderItem->quantity));
    }
    $output = new PlaceOrderOutput($order->getCode(), $order->getTotal());
    return $output;
  }
}