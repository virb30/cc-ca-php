<?php declare(strict_types=1);

use App\Application\UseCase\SimulateFreight;
use App\Application\UseCase\SimulateFreightInput;
use App\Infra\Repository\Memory\ProductRepositoryMemory;
use PHPUnit\Framework\TestCase;

class SimulateFreightTest extends TestCase
{
  public function testShouldSimulateFreight()
  {
    $productRepository = new ProductRepositoryMemory();
    $simulateFreight = new SimulateFreight($productRepository);
    $input = new SimulateFreightInput(
      orderItems: [
        (object) ['idItem' => 1, 'quantity' => 1],
        (object) ['idItem' => 2, 'quantity' => 1],
        (object) ['idItem' => 3, 'quantity' => 3],
      ]
    );
    $output = $simulateFreight->execute($input);
    $this->assertEquals(260, $output->total);
  }

  public function testShouldTrhowsIfProductNotFound()
  {
    $productRepository = new ProductRepositoryMemory();
    $simulateFreight = new SimulateFreight($productRepository);
    $input = new SimulateFreightInput(
      orderItems: [
        (object) ['idItem' => 1, 'quantity' => 1],
        (object) ['idItem' => 2, 'quantity' => 1],
        (object) ['idItem' => 3, 'quantity' => 3],
        (object) ['idItem' => 4, 'quantity' => 3],
      ]
    );

    $this->expectException(Exception::class);
    $simulateFreight->execute($input);
  }
}